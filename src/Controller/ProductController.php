<?php
namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->query->getInt('limit', 10);
        $offset = $request->query->getInt('offset');

        $repository = $this->getDoctrine()->getRepository(Product::class);

        try {
          $products = $repository->findBy([], null, $limit, $offset);
        } catch (\Doctrine\DBAL\DBALException $e) {
          return $this->json([ "errors" => [ $e->getMessage() ] ], 400);
        }

        return $this->json($products);
    }

    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->submit($data);

        if (!$form->isValid()) {
            $form_errors = [];
            foreach ($form->getErrors(true) as $form_error) {
                $form_errors[] = $form_error->getMessage();
            }
            
            return $this->json([ "errors" => $form_errors ], 400);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        return $this->json($product, 201);
    }
}
