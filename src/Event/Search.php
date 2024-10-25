<?php

namespace AlexWestergaard\PhpGa4\Event;

use AlexWestergaard\PhpGa4\Facade;
use AlexWestergaard\PhpGa4\Model;

class Search extends Model\Event implements Facade\Search
{
    protected $search_term;

    public function getName(): string
    {
        return 'search';
    }

    public function getParams(): array
    {
        return [
            'search_term',
        ];
    }

    public function getRequiredParams(): array
    {
        return [];
    }

    public function setSearchTerm(string $term)
    {
        $this->search_term = $term;
        return $this;
    }
}
