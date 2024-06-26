<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('pages/homepage/index.html.twig');
    }
}
