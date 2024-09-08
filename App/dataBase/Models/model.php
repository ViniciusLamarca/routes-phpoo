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


    //update table set 
    public function update(array $fieldsAndValues, string $conditions = '')
    {
        try {
            // Construa a cláusula SET dinamicamente
            $setClause = [];
            foreach ($fieldsAndValues as $field => $value) {
                // Para valores que são expressões, deixe como estão, caso contrário, use parâmetros
                if (strpos($value, '=') !== false || strpos($value, 'CASE') !== false || strpos($value, 'SELECT') !== false) {
                    $setClause[] = "{$field} = {$value}";
                } else {
                    $setClause[] = "{$field} = :{$field}";
                }
            }
            $setClauseString = implode(', ', $setClause);

            // Construa a consulta SQL final
            $sql = "UPDATE {$this->tables} SET {$setClauseString}";
            if ($conditions) {
                $sql .= " WHERE {$conditions}";
            }

            $query = connection::connect()->prepare($sql);

            // Associe os valores dos parâmetros
            $params = [];
            foreach ($fieldsAndValues as $field => $value) {
                if (strpos($value, '=') === false && strpos($value, 'CASE') === false && strpos($value, 'SELECT') === false) {
                    $params[":{$field}"] = $value;
                }
            }

            $query->execute($params);
            return $query->rowCount();
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }
}
