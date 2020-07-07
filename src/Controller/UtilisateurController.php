<?php

namespace App\Controller;

use App\Entity\Docs;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UtilisateurController extends AbstractController
{
    // Création d'une nouvelle route pour afficher la page 
    // profil d'un membre
    /**
     * @Route("/membre", name="membre")
     */
    public function profil(UtilisateurRepository $repo)
    {
        /*
            profil() affiche la page du membre après qu'il se soit connecté
            Les informations sélectionnées en BDD s'affichent dans un formulaire
            
            Le formulaire est créé grâce à la méthode Symfony createForm() suivant 
            les champs répertoriés dans la classe UtilisateurType
            
            Les champs du formulaire sont préremplis par les données utilisateur.
            L'utilisateur étant identifié grâce à son id
        */
        $utilisateur = new Utilisateur;
               
        $form = $this->createForm(UtilisateurType::class, $utilisateur);


        return $this->render('utilisateur/membre.html.twig', [
            'formUser' => $form->createView(),
            'prenom' => $utilisateur->getPrenom(),
            'utilisateur' => $utilisateur
        ]);
    }

    /**
     * @Route("/membre/docs", name="membre_docs")
     */
    public function showDocs()
    {
        return $this->render('utilisateur/membre_document.html.twig');
    }

  
    /**
     * @Route("/membre/name", name="page_membre")
     */
    // public function home(Utilisateur $utilisateur, Request $request, EntityManagerInterface $manager)
    // {
    //     /* 
    //         On injecte les dépendances:
    //         Utilisateur pour stocker les données récupérées par le 
    //         formulaire
    //         Request qui récupère les données du formulaire grâce à la méthode POST
    //         et EntityManagerInterface qui contient les méthodes permettant de faire 
    //         les liens avec la base de données.


    //         Pour créer un formulaire via les méthodes de Symfony, nous commençons par 
    //         instancier l'objet $user qui sera le réceptacle des données récupérées par 
    //         $request
    //         On déclare un nouvel objet $form qui va créer les champsdu formulaire via 
    //         la méthode createForm() 

    //         Les données du formulaire seront récupérées via l'objet $request qui contient
    //         les infos du formulaire

    //         Lorsque 

    //     */
    //     $utilisateur = new Utilisateur;

    //     // $form = $this->createForm(UtilisateurType::class, $utilisateur);

    //     // $form->handleRequest($request);
        
    //     // dump($request);

    //     // $manager->persist($utilisateur);
    //     // $manager->flush();

    //     return $this->render('utilisateur/membre.html.twig', [
    //     //         'formUser' => $form->createView(),
    //             // 'edit' => $utilisateur->getId()
    //     ]);
    // }

    
}
