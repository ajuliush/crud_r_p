<?php
namespace App\Repository;
interface IProductRepository{
    public function getAllProducts();
    public function createProduct(array $data);
    public function getSingleProduct($id);
}
?>
