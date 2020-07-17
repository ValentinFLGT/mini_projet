<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_index")
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
     * @Route("/product", name="product_create")
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
     * @Route("/product/{product}", name="product_show")
     * @param Product $product
     * @return Response
     */
    public function showProduct(Product $product)
    {
        return new Response('You asked for the id ' . $product->getId() . ', here is the corresponding product : ' . $product->getName());
    }


}
