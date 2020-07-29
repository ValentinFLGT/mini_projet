<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationList;

class ProductController extends AbstractController
{
    /**
     * @Route("/api/product", name="product_index", methods={"GET"})
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->json($productRepository->findAll(), 200, []);
    }

    /**
     * @Route("/api/product/create", name="product_create", methods={"POST"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function createProduct(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {
        try {
            $receivedJson = $request->getContent();
            $deserializer = $serializer->deserialize($receivedJson, Product::class, 'json');
            $entityManager->persist($deserializer);
            $entityManager->flush();

            return $this->json($deserializer, 201, []);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * @Route("/api/product/{product}", name="product_show", methods={"GET"})
     * @param Product $product
     * @return Response
     */
    public function showProduct(Product $product): Response
    {
        return $this->json($product, 200);
    }

    /**
     * @Route("/api/product/update/{product}", name="product_update", methods={"PUT"})
     * @param Product $product
     * @param Request $request
     * @param EntityManager $entityManager
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateProduct(Product $product, Request $request, EntityManager $entityManager): Response
    {
        $receivedJson = json_decode($request->getContent());

        $product->setName($receivedJson->name);
        $product->setPrice($receivedJson->price);
        $product->setBrand($receivedJson->brand);

        $entityManager->persist($product);
        $entityManager->flush();

        return $this->json($product, 200);
    }


    /**
     * @Route("/api/product/delete/{product}", name="product_delete")
     * @param Product $product
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function deleteProduct(Product $product, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('product_index');
    }
}
