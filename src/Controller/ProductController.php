<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */

// Pourquoi cette fonction bloque ma fonction createProduct ?

//    public function index()
//    {
//        return $this->render('product/index.html.twig', [
//            'controller_name' => 'ProductController',
//        ]);
//    }

    public function createProduct(): Response
    {
        // fetch the EntityManager
        $entityManager = $this->getDoctrine()->getManager();

        $product = new Product();
        $product -> setName('Soda');
        $product -> setPrice(2);
        $product -> setBrand('Coca-Cola');

        // tell Doctrine we want to save the product (no queries yet)
        $entityManager -> persist($product);

        // executes the queries
        $entityManager -> flush();

        Return new Response('Saved new product with id '.$product -> getId());
    }
}
