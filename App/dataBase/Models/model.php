<?php

namespace app\dataBase\Models;

use app\dataBase\connection;
use app\dataBase\Filters;
use PDO;
use PDOException;


abstract class Model
{
    private string $fields = '*';
    private string $filters = '';
    protected string $tables = '';

    public function setFields($fields)
    {
        $this->fields = $fields;
    }
    public function setFilters(Filters $filters)
    {
        $this->filters = $filters->dump();
    }

    public function fetch_all()
    {
        try {
            $sql = "SELECT {$this->fields} FROM {$this->tables} {$this->filters}";
            $query = connection::connect()->query($sql);
            return $query->fetchAll(PDO::FETCH_CLASS, get_called_class());
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }
    public function findBy(string $field = '', string $value = '')
    {
        try {

            $sql = (!empty($this->filters)) ?
                $sql = "SELECT {$this->fields} FROM {$this->tables} WHERE {$field} = :{$field}" :
                $sql = "SELECT {$this->fields} FROM {$this->tables} {$this->filters}";


            $query = connection::connect()->prepare($sql);
            $query->execute(!$this->filters ? ["{$field}" => $value] : []);
            return $query->FetchObject(get_called_class());
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }


    public function first($field = 'id', $order = 'asc')
    {
        try {
            $sql = "SELECT {$this->fields} FROM {$this->tables}  order by {$field} {$order}";
            $query = connection::connect()->query($sql);
            $query->execute();
            return $query->FetchObject(get_called_class());
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }

    public function count()
    {
        try {
            $sql = "SELECT {$this->fields} FROM {$this->tables} {$this->filters}";
            $query = connection::connect()->query($sql);
            $query->execute();
            return $query->rowCount();
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }


    public function delete(string $field = '', string|int $value = '')
    {
        try {
            $sql = (!$this->filters) ?
                $sql = "DELETE FROM {$this->tables} WHERE {$field} = :{$field}" :
                $sql = "DELETE FROM {$this->tables} {$this->filters}";

            $query = connection::connect()->prepare($sql);
            $query->execute(empty($this->filters) ? [$field => $value] : []);
            return $query->rowCount();
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }
}
