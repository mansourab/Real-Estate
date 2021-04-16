<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Item;
use App\Form\ItemFormType;
use App\Form\SearchForm;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ItemController extends AbstractController
{

    private $em;

    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @Route("/items", name="item_index")
     */
    public function index(ItemRepository $repo, Request $request): Response
    {

        $data = new SearchData();

        $data->page = $request->get('page', 1);

        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);

        $items = $repo->findSearch($data);

        return $this->render('item/index.html.twig', [
            'items' => $items,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/item/create", name="item_add")
     */
    public function add(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $item = new Item();

        $form = $this->createForm(ItemFormType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item->setUser($this->getUser());

            $this->em->persist($item);
            $this->em->flush();

            $this->addFlash('success', 'Item successfully added');

            return $this->redirectToRoute('item_index');
        }

        return $this->render('item/create.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/item/edit/{slug}", name="item_edit")
     */
    public function edit(Item $item, Request $request)
    {
        $form = $this->createForm(ItemFormType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            $this->addFlash('success', 'Item modifié avec succès');

            return $this->redirectToRoute('item_index');
        }

        return $this->render('item/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/item/{slug}", name="item_show")
     */
    public function show(Item $item)
    {
        return $this->render('item/show.html.twig', compact('item'));
    }

    /**
     * @Route("/item/delete/{slug}", name="item_delete", methods="DELETE")
     * @param Item $item
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Item $item, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        
        if ($this->isCsrfTokenValid('delete' .$item->getSlug(), $request->get('_token'))) {
            $this->em->remove($item);
            $this->em->flush();

            $this->addFlash('info', 'Item supprimé avec succès');

            return $this->redirectToRoute('account_index');
        }
        
    }

}
