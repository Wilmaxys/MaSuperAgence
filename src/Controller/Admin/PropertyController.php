<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * AdminPropController constructor.
     *
     * @param PropertyRepository $repository Repository to manipulate property
     */
    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    public function index(): Response
    {
        $properties = $this->repository->findAll();

        return $this->render('admin/property/index.html.twig', [
            'properties' => $properties,
        ]);
    }

    public function new(Request $request): Response
    {
        $property = new Property();

        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($property);
            $this->em->Flush();
            $this->addFlash('success', 'Bien ajouter avec succès. Bravo!');

            return $this->redirectToRoute('admin.properties.show');
        }

        return $this->render('admin/property/new.html.twig', [
            'current-menu' => 'properties',
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }

    public function edit(Property $property, Request $request): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->Flush();
            $this->addFlash('success', 'Bien modifier avec succès.');

            return $this->redirectToRoute('admin.properties.show');
        }

        return $this->render('admin/property/edit.html.twig', [
            'current-menu' => 'properties',
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }

    public function delete(Property $property, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete'.$property->getId(), $request->get('_token'))) {
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success', 'Bien supprimer avec succès.');

        }

        return $this->redirectToRoute('admin.properties.show');
    }
}
