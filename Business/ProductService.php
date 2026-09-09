<?php

require_once __DIR__ . "/../data/ProductRepository.php";

class ProductService
{
    private $productRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
    }

    public function getAllProducts()
    {
        return $this->productRepository->getAllProducts();
    }

    public function getProductById($id)
    {
        return $this->productRepository->getProductById($id);
    }

    public function createProduct(
        $name,
        $description,
        $price,
        $categoryId,
        $image
    ) {
        if (empty($name)) {
            return "Naziv proizvoda je obavezan.";
        }

        if (!is_numeric($price) || $price <= 0) {
            return "Cena mora biti pozitivan broj.";
        }

        if (empty($categoryId)) {
            return "Kategorija je obavezna.";
        }

        $product = new Product(
            $name,
            $description,
            $price,
            $categoryId,
            $image
        );

        $this->productRepository->createProduct($product);

        return "success";
    }

    public function updateProduct(
        $id,
        $name,
        $description,
        $price,
        $categoryId,
        $image
    ) {
        if (empty($name)) {
            return "Naziv proizvoda je obavezan.";
        }

        if (!is_numeric($price) || $price <= 0) {
            return "Cena mora biti pozitivan broj.";
        }

        if (empty($categoryId)) {
            return "Kategorija je obavezna.";
        }

        $product = new Product(
            $name,
            $description,
            $price,
            $categoryId,
            $image
        );

        $this->productRepository->updateProduct($id, $product);

        return "success";
    }

    public function deleteProduct($id)
    {
        $this->productRepository->deleteProduct($id);
    }
}

?>