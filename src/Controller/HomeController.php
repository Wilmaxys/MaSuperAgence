<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * HomeController constructor.
     *
     * @param PropertyRepository     $repository Repository to manage properties
     * @param EntityManagerInterface $em         Entity manager instance
     */
    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    public function index(): Response
    {
        $properties = $this->repository->findLatest();

        return $this->render('pages/home.html.twig',
            ['properties' => $properties]
        );
    }
}
