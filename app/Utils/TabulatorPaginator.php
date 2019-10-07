<?php

namespace App\Utils;

use Illuminate\Http\Request;

class TabulatorPaginator
{
    private $queryBase;
    private $filterables = [];
    private $sortables = [];

    private function __construct($base)
    {
        $this->queryBase = $base;
    }

    static function from($base) {
        return new TabulatorPaginator($base);
    }

    function filterable($fields)
    {
        if (gettype($fields) === 'string') {
            $fields = [$fields];
        }
        $this->filterables = array_merge($this->filterables, $fields);
        return $this;
    }

    function sortable($fields)
    {
        if (gettype($fields) === 'string') {
            $fields = [$fields];
        }
        $this->sortables = array_merge($this->sortables, $fields);
        return $this;
    }

    function paginate()
    {
        $result = $this->queryBase;
        foreach (request('sorters') ?? [] as $sorter) {
            if (array_search($sorter['field'], $this->sortables) !== false) {
                $result = $result->orderBy($sorter['field'], $sorter['dir']);
            } else {
                throw new \InvalidArgumentException("Sorting on " . $sorter['field'] . " is not allowed.");
            }
        }
        foreach (request('filters') ?? [] as $filter) {
            if (array_search($filter['field'], $this->filterables) !== false) {
                $result = $result->where($filter['field'], $filter['type'], '%' . $filter['value'] . '%');
            } else {
                throw new \InvalidArgumentException("Filtering on " . $filter['field'] . " is not allowed.");
            }
        }
        return $result->paginate(request('size'));
    }
}
