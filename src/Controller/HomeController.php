<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * HomeController constructor.
     *
     * @param PropertyRepository     $repository Repository to manage properties
     */
    public function __construct(PropertyRepository $repository)
    {
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
