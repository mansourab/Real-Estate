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
    public $q = '';

    /**
     * @var Category[]
     */
    public $categories = [];


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
    
}