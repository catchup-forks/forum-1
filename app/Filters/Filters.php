<?php namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{

    protected $request, $builder;

    protected $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->request->intersect($this->filters) as $filter => $value) {

            if (!$this->hasFilter($filter)) continue;

            $this->$filter($value);
        }

        return $this->builder;
    }

    /**
     * @param $filter
     * @return bool
     */
    private function hasFilter($filter)
    {
        return method_exists($this, $filter) && $this->request->has($filter);
    }
}