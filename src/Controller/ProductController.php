<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/", name="productIndex")
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            // serialize the array before storing into DB, for loop is required in the view to access items
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/create", name="createProduct")
     */
    public function createProduct(): Response
    {
        // fetch the EntityManager
        $entityManager = $this->getDoctrine()->getManager();

        $product = new Product();
        $product->setName('Soda');
        $product->setPrice(2);
        $product->setBrand('Coca-Cola');

        // tell Doctrine we want to save the product (no queries yet)
        $entityManager->persist($product);

        // executes the queries
        $entityManager->flush();

        return new Response('Saved new product with id ' . $product->getId());
    }

    /**
     * @Route("/product/{id}", name="productById")
     */
    public function show($id)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        return new Response('You asked for the id ' . $id . ', here is the corresponding product : ' . $product->getName());
    }
}
