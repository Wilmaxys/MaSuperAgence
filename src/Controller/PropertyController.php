<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;

class PropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * PropertyController constructor.
     *
     * @param PropertyRepository $repository Repository to manage properties
     */
    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);

        $properties = $paginator->paginate(
            $this->repository->findAllVisible($search),
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('property/index.html.twig', [
            'current-menu' => 'properties',
            'properties' => $properties,
            'form' => $form->createView()
        ]);
    }

    public function show(Property $property, string $slug): Response
    {
        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug(),
            ], 301);
        }

        return $this->render('property/show.html.twig', [
            'current-menu' => 'properties',
            'property' => $property,
        ]);
    }
}
