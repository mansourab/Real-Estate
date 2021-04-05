<?php

namespace App\Data;

use App\Entity\Category;

class SearchData
{
    /**
     * @var int
     */
    public $page = 1;

    /**
     * @var null|string
     */
    private $q = '';

    /**
     * @var Category[]
     */
    private $categories = [];


    public function getQ()
    {
        return $this->q;
    }

    public function setQ(string $q)
    {
        $this->q = $q;
        
        return $this;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function setCategories(array $categories)
    {
        $this->categories = $categories;
        
        return $this;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setPage(int $page)
    {
        $this->page = $page;
        
        return $this;
    }
    
}