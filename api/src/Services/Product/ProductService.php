<?php

namespace App\Services\Product;

use App\DataObject\ProductDataObject;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class ProductService implements ProductServiceInterface
{
    private ProductRepository $productRepository;
    private SerializerInterface $serializer;

    public function __construct(
        ProductRepository $productRepository,
        SerializerInterface $serializer,
    ) {
        $this->productRepository = $productRepository;
        $this->serializer = $serializer;
    }

    public function all(): array
    {
        return $this->productRepository->findAll();
    }

    public function get(string $uuid): Product
    {
        return $this->productRepository->findOneBy(['uuid' => $uuid]);
    }

    public function create(ProductDataObject $productDataObject): ?Product
    {
        $product = new Product();
        $product
            ->setName($productDataObject->name)
            ->setPrice($productDataObject->price);

        return $this->productRepository->save($product);
    }

    public function update(ProductDataObject $productDataObject, string $uuid): ?Product
    {
        $product = $this->productRepository->findOneBy(['uuid' => $uuid]);
        $product
            ->setName($productDataObject->name)
            ->setPrice($productDataObject->price);

        return $this->productRepository->save($product);
    }

    public function delete(string $uuid): void
    {
        $this->productRepository->delete($this->productRepository->findOneBy(['uuid' => $uuid]));
    }

    public function export(string $format = 'csv'): string
    {
        $data = $this->productRepository->findAll();

        if ($format === 'csv') {
            return $this->serializer->serialize($data, CsvEncoder::FORMAT);
        }

        if ($format === 'xml') {
            return $this->serializer->serialize($data, XmlEncoder::FORMAT);
        }

    }
}