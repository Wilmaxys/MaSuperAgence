<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * PropertyController constructor.
     *
     * @param PropertyRepository     $repository Repository to manage properties
     * @param EntityManagerInterface $em         Entity manager instance
     */
    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    public function index(): Response
    {
        $property = $this->repository->find(1);

        return $this->render('property/index.html.twig',[
            'current-menu' => 'properties'
        ]);
    }

    public function show(Property $property, string $slug): Response{
        if ($property->getSlug() !== $slug){
            return $this->redirectToRoute('property', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        return $this->render('property/show.html.twig',[
            'current-menu' => 'properties',
            'property' => $property
        ]);
    }
}
