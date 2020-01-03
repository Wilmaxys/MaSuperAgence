<?php

namespace App\Controller;

use App\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class PropertyController extends AbstractController {

    public function index() : Response
    {
        $property = new Property();

        $property->setTitle('Mon premier bine')
            ->setPrice(200000)
            ->setRooms(4)
            ->setBedrooms(3)
            ->setDescription('petite description')
            ->setSurface(60)
            ->setFloor(4)
            ->setHeat(1)
            ->setCity('Laval')
            ->setAddress('74 rue bernard minet')
            ->setPostalCode('53000')
        ;

        $em = $this->getDoctrine()->getManager();

        $em->persist($property);
        $em->flush();

        return $this->render('property/index.html.twig');
    }

}