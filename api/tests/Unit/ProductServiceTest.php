<?php

namespace App\Tests\Unit;

use App\DataObject\ProductDataObject;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Services\Product\ProductService;
use App\Services\Product\ProductServiceInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

class ProductServiceTest extends TestCase
{
    private ProductServiceInterface $productService;

    const PRODUCT_NAME = 'Test name';
    const PRODUCT_PRICE = '2.50';
    const PRODUCT_UUID = '22982f25-8fdd-406d-ae8e-ca0469406a29';
    const PRODUCT_FAKE_DATA = [
        'name' => self::PRODUCT_NAME,
        'price' => self::PRODUCT_PRICE,
        'uuid' => self::PRODUCT_UUID,
    ];

    protected function setUp(): void
    {
        $product = $this->mockProductEntity();
        $productRepository = $this->mockProductRepository($product);

        $serializer = $this->createMock(SerializerInterface::class);

        $this->productService = new ProductService($productRepository, $serializer);

        parent::setUp();
    }

    public function testAll(): void
    {
        $result = $this->productService->all();

        $this->assertCount(count(self::PRODUCT_FAKE_DATA), $result);
    }

    public function testGet(): void
    {
        $result = $this->productService->get(self::PRODUCT_UUID);

        $this->assertInstanceOf(Product::class, $result);
        $this->assertEquals(self::PRODUCT_UUID, $result->getUuid());
    }

    public function testCreate(): void
    {
        $productDataObject = $this->createMock(ProductDataObject::class);
        $productDataObject->name = 'Test name';
        $productDataObject->price = self::PRODUCT_PRICE;

        $result = $this->productService->create($productDataObject);

        $this->assertInstanceOf(Product::class, $result);
        $this->assertEquals(self::PRODUCT_UUID, $result->getUuid());
    }

    public function testUpdate(): void
    {
        $productDataObject = $this->createMock(ProductDataObject::class);
        $productDataObject->name = 'Test name';
        $productDataObject->price = self::PRODUCT_PRICE;

        $result = $this->productService->update($productDataObject, self::PRODUCT_UUID);

        $this->assertInstanceOf(Product::class, $result);
        $this->assertEquals(self::PRODUCT_UUID, $result->getUuid());
    }

    public function testDelete(): void
    {
        $this->assertNull($this->productService->delete(self::PRODUCT_UUID));
    }

    private function mockProductEntity(): Product
    {
        $product = $this->createMock(Product::class);
        $product
            ->expects($this->any())
            ->method('getPrice')
            ->willReturn(self::PRODUCT_PRICE);

        $product
            ->expects($this->any())
            ->method('getName')
            ->willReturn('Test name');

        $product
            ->expects($this->any())
            ->method('getUuid')
            ->willReturn(self::PRODUCT_UUID);

        return $product;
    }

    private function mockProductRepository(Product $product): ProductRepository
    {
        $productRepository = $this->createMock(ProductRepository::class);
        $productRepository
            ->expects($this->any())
            ->method('findAll')
            ->willReturn(self::PRODUCT_FAKE_DATA);

        $productRepository
            ->expects($this->any())
            ->method('findOneBy')
            ->willReturn($product);

        $productRepository
            ->expects($this->any())
            ->method('save')
            ->willReturn($product);

        return $productRepository;
    }
}
