<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{

    /**
     * @Route("/category/index", name="category_index")
     */
    public function index(CategoryRepository $repo)
    {
        $categories = $repo->findAll();

        return $this->render('category/index.html.twig', compact('categories'));
    }

    /**
     * @Route("/category/create", name="category_create")
     */
    public function create(Request $request, EntityManagerInterface $em)
    {
        $category = new Category();

        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}