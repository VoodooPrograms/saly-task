<?php

namespace App\Services\Product;

use App\DataObject\ProductDataObject;
use App\Entity\Product;

interface ProductServiceInterface
{
    public function all(): array;

    public function get(string $uuid): Product;

    public function create(ProductDataObject $productDataObject): ?Product;

    public function update(ProductDataObject $productDataObject, string $uuid): ?Product;

    public function delete(string $uuid): void;

    public function export(string $format = 'csv');
}