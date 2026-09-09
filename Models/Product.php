<?php

class Product
{
    private $id;
    private $name;
    private $description;
    private $price;
    private $categoryId;
    private $image;

    public function __construct(
        $name,
        $description,
        $price,
        $categoryId,
        $image = null
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->categoryId = $categoryId;
        $this->image = $image;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getCategoryId()
    {
        return $this->categoryId;
    }

    public function getImage()
    {
        return $this->image;
    }
}

?>