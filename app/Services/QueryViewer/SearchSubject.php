<?php

namespace App\Services\QueryViewer;

class SearchSubject extends QueryHandle
{
    public function run($q)
    {
        return $q->where('name', 'like', '%' . request($this->getClass()) . '%');
    }
}