<?php

namespace App\Database\Models;

use App\Core\Database\DatabaseManager;
use PDO;
use PDOException;

abstract class BaseModel
{
    protected DatabaseManager $db;
    protected string $table = '';
    protected string $primaryKey = 'id';
    protected array $fillable = [];
    protected array $hidden = [];

    private string $fields = '*';
    private string $where = '';
    private array $bindings = [];

    public function __construct(DatabaseManager $db = null)
    {
        $this->db = $db ?? app('db');
    }

    public function select(string $fields = '*'): self
    {
        $this->fields = $fields;
        return $this;
    }

    public function where(string $column, string $operator, $value = null): self
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }

        $placeholder = ':' . str_replace('.', '_', $column) . '_' . count($this->bindings);

        if (!empty($this->where)) {
            $this->where .= ' AND ';
        }

        $this->where .= "{$column} {$operator} {$placeholder}";
        $this->bindings[$placeholder] = $value;

        return $this;
    }

    public function orWhere(string $column, string $operator, $value = null): self
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }

        $placeholder = ':' . str_replace('.', '_', $column) . '_' . count($this->bindings);

        if (!empty($this->where)) {
            $this->where .= ' OR ';
        }

        $this->where .= "{$column} {$operator} {$placeholder}";
        $this->bindings[$placeholder] = $value;

        return $this;
    }

    public function find($id)
    {
        return $this->where($this->primaryKey, $id)->first();
    }

    public function first()
    {
        try {
            $sql = "SELECT {$this->fields} FROM {$this->table}";

            if (!empty($this->where)) {
                $sql .= " WHERE {$this->where}";
            }

            $sql .= " LIMIT 1";

            $query = $this->db->connection()->prepare($sql);
            $query->execute($this->bindings);

            $result = $query->fetchObject(static::class);
            $this->resetQuery();

            return $result ?: null;
        } catch (PDOException $e) {
            throw new \RuntimeException("Database error: " . $e->getMessage());
        }
    }

    public function get(): array
    {
        try {
            $sql = "SELECT {$this->fields} FROM {$this->table}";

            if (!empty($this->where)) {
                $sql .= " WHERE {$this->where}";
            }

            $query = $this->db->connection()->prepare($sql);
            $query->execute($this->bindings);

            $results = $query->fetchAll(PDO::FETCH_CLASS, static::class);
            $this->resetQuery();

            return $results;
        } catch (PDOException $e) {
            throw new \RuntimeException("Database error: " . $e->getMessage());
        }
    }

    public function all(): array
    {
        return $this->get();
    }

    public function count(): int
    {
        try {
            $sql = "SELECT COUNT(*) as count FROM {$this->table}";

            if (!empty($this->where)) {
                $sql .= " WHERE {$this->where}";
            }

            $query = $this->db->connection()->prepare($sql);
            $query->execute($this->bindings);

            $result = $query->fetch(PDO::FETCH_OBJ);
            $this->resetQuery();

            return (int) $result->count;
        } catch (PDOException $e) {
            throw new \RuntimeException("Database error: " . $e->getMessage());
        }
    }

    public function create(array $data): bool
    {
        $data = $this->filterFillable($data);

        try {
            $columns = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_map(fn($key) => ':' . $key, array_keys($data)));

            $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";

            $query = $this->db->connection()->prepare($sql);
            return $query->execute($data);
        } catch (PDOException $e) {
            throw new \RuntimeException("Database error: " . $e->getMessage());
        }
    }

    public function update(array $data): bool
    {
        $data = $this->filterFillable($data);

        try {
            $setClause = implode(', ', array_map(fn($key) => "{$key} = :{$key}", array_keys($data)));

            $sql = "UPDATE {$this->table} SET {$setClause}";

            if (!empty($this->where)) {
                $sql .= " WHERE {$this->where}";
                $data = array_merge($data, $this->bindings);
            }

            $query = $this->db->connection()->prepare($sql);
            $result = $query->execute($data);

            $this->resetQuery();

            return $result;
        } catch (PDOException $e) {
            throw new \RuntimeException("Database error: " . $e->getMessage());
        }
    }

    public function delete(): bool
    {
        try {
            $sql = "DELETE FROM {$this->table}";

            if (!empty($this->where)) {
                $sql .= " WHERE {$this->where}";
            } else {
                throw new \RuntimeException("Cannot delete without WHERE clause");
            }

            $query = $this->db->connection()->prepare($sql);
            $result = $query->execute($this->bindings);

            $this->resetQuery();

            return $result;
        } catch (PDOException $e) {
            throw new \RuntimeException("Database error: " . $e->getMessage());
        }
    }

    private function filterFillable(array $data): array
    {
        if (empty($this->fillable)) {
            return $data;
        }

        return array_intersect_key($data, array_flip($this->fillable));
    }

    private function resetQuery(): void
    {
        $this->fields = '*';
        $this->where = '';
        $this->bindings = [];
    }

    public function toArray(): array
    {
        $reflection = new \ReflectionClass($this);
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED);

        $array = [];
        foreach ($properties as $property) {
            if (in_array($property->getName(), ['db'])) {
                continue;
            }

            $property->setAccessible(true);
            $value = $property->getValue($this);

            if (!in_array($property->getName(), $this->hidden)) {
                $array[$property->getName()] = $value;
            }
        }

        return $array;
    }
}
