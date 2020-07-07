<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DocsController extends AbstractController
{
    /**
     * @Route("/docs", name="docs")
     */
    public function index()
    {
        return $this->render('docs/index.html.twig', [
            'controller_name' => 'DocsController',
        ]);
    }
}