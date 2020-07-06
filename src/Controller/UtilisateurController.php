<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/membre/name", name="membre")
     */
    public function index()
    {
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }

    /**
     * @Route("/membre", name="page_membre")
     */
    public function show(Request $request,Utilisateur $user, UtilisateurRepository $repo)
    {
        $user = new Utilisateur;

        $form = $this->createForm(UtilisateurType::class, $user);

        $form->handleRequest($request);

        return $this->render('utilisateur/membre.html.twig', [
                'formUser' => $form->createView(),
                'user' => $user
        ]);
    }


}
