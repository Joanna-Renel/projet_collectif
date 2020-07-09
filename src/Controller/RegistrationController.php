<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/inscription", name="registration")
     * @Route("/connexion/{id}/edit", name="login")
     */
    public function register(Utilisateur $utilisateur = null, Request $request, EntityManagerInterface $manager)
    {
        
        // Méthode permettant d'appeler la classe RegistrationType chargée de créer le formulaire
        $form= $this->createForm(RegistrationType::class, $utilisateur);
        
        // handleRequest récupère les données du formulaire stockées dans $request
        // et crée les seters
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {   
            // Si l'id du membre n'existe pas dans la table Utilisateur,
            // création d'un nouveau membre via le formulaire d'inscription
            if(!$utilisateur->getId())
            {
                $utilisateur = new Utilisateur;
            }

            // Préparation de la requête d'insertion en BDD
            $manager->persist($utilisateur);

            // Exécution de la requête d'insertion en BDD
            $manager->flush();

            // Redirection sur le profil personnel du membre

            // return $this->redirectToRoute('route vers le profil membre', [
            //     'id'=> $utilisateur->getId()
            // ]);
        }

        // render() retourne le template registration.html.twig responsable de l'affichage du formulaire d'inscription/connexion.
        // L'indice 'formUtilisateur' utilise la méthode createView() pour stocker le formulaire qui sera renvoyé sur le template
        // Si l'id de l'utilisateur n'est pas nul, l'indice 'login' servira à être redirigé sur le profil 
        return $this->render('registration/register.html.twig', [
            'controller_name' => 'RegistrationController',
            'formUtilisateur'=> $form->createView(),
            // 'login'=>$utilisateur->getId()
            
        ]);
    }
}
