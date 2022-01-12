<?php

namespace App\Controller;

use App\DataObject\ProductDataObject;
use App\Services\Product\ProductServiceInterface;
use App\Services\Validator\ValidatorServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/product', name: 'product')]
class ProductController extends AbstractController
{
    private ProductServiceInterface $productService;
    private SerializerInterface $serializer;
    private ValidatorServiceInterface $validatorService;

    public function __construct(
        ProductServiceInterface $productService,
        SerializerInterface $serializer,
        ValidatorServiceInterface $validatorService
    ) {
        $this->productService = $productService;
        $this->serializer = $serializer;
        $this->validatorService = $validatorService;
    }

    #[Route(name: '_index', methods: ['GET'])]
    public function index(): Response
    {
        $products = $this->productService->all();

        return new Response(
            $this->serializer->serialize($products, JsonEncoder::FORMAT, ['groups' => 'index']),
            Response::HTTP_OK
        );
    }

    #[Route('/{uuid}', name: '_show', methods: ['GET'])]
    public function show(string $uuid): Response
    {
        $product = $this->productService->get($uuid);

        return new Response(
            $this->serializer->serialize($product, JsonEncoder::FORMAT, ['groups' => 'index']),
            Response::HTTP_OK
        );
    }

    #[Route(name: '_store', methods: ['POST'])]
    public function store(Request $request): Response
    {
        $productData = $this->validatorService->validate($request, ProductDataObject::class);

        if ($productData instanceof Response) return $productData;

        $this->productService->create($productData);

        return new Response('Product created', Response::HTTP_CREATED);
    }

    #[Route('/{uuid}', name: '_update', methods: ['PUT'])]
    public function update(Request $request, string $uuid): Response
    {
        $productData = $this->validatorService->validate($request, ProductDataObject::class);

        if ($productData instanceof Response) return $productData;

        $this->productService->update($productData, $uuid);

        return new Response('Product updated', Response::HTTP_OK);
    }

    #[Route('/{uuid}', name: '_delete', methods: ['DELETE'])]
    public function delete(string $uuid): Response
    {
        $this->productService->delete($uuid);

        return new Response('Product deleted', Response::HTTP_OK);
    }

    #[Route('-export', name: '_export', methods: ['GET'])]
    public function export(Request $request): Response
    {
        $format = $request->query->get('format');

        return new Response(
            $this->productService->export($format),
            Response::HTTP_OK,
            ['Content-Disposition' =>
                HeaderUtils::makeDisposition(
                HeaderUtils::DISPOSITION_ATTACHMENT,
                'products.' . $format
                )
            ]
        );
    }

}
