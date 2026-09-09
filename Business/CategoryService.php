<?php

require_once __DIR__ . "/../data/CategoryRepository.php";

class CategoryService
{
    private $categoryRepository;

    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository();
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->getAllCategories();
    }
}

?>