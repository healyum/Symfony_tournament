<?php

namespace App\Controller;

use App\Entity\Tournament;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/homepage", name="homepage")
     */
    public function index(Request $request): Response
    {
        $tournaments = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(Tournament::class)
            ->findAll()
        ;

        return $this->render('homepage.html.twig',
            ['tournaments' => $tournaments,
            'message' => $request->query->get('message','default message')]);
    }
}