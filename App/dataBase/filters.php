<?php

namespace app\dataBase;

class Filters
{

    private array $filters = [];

    public function where(string $field, string $operator, mixed $value, string $logic = ''): void
    {

        $formatter = '';
        if (is_array($value)) {
            $formatter = "('" . implode("','", $value) . "')";
        } else if (is_string($value)) {
            $formatter = "'{$value}'";
        } else if (is_bool($value)) {
            $formatter = $value ? '1' : '0';
        } else {
            $formatter = $value;
        }

        $value = strip_tags($formatter);
        $this->filters['where'][] = "{$field} {$operator} {$value} {$logic}";
    }

    public function limit(int $limit)
    {
        $this->filters['limit'] = "limit {$limit}";
    }

    public function orderBy(string $field, string $order = 'ASC')
    {
        $this->filters['orderBy'] = "order by {$field} {$order} ";
    }

    public function join(string $foreignTable, string $joinTable1, string $operator, string $joinTable2, string $joinType = 'INNER JOIN')
    {
        $this->filters['join'][] = "{$joinType} {$foreignTable} ON {$joinTable1} {$operator} {$joinTable2}";
    }

    public function dump()
    {

        $filters = !empty($this->filters['join']) ? ' ' . implode(' ', $this->filters['join']) : '';
        $filters .= !empty($this->filters['where']) ? ' WHERE ' . implode(' ', $this->filters['where']) : '';
        $filters .= $this->filters['orderBy'] ?? '';
        $filters .= $this->filters['limit'] ?? '';
        return $filters;
    }
}
