<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/inscription", name="registration")
     */
    public function register(Request $request, EntityManagerInterface $manager)
    {   
        // Création d'une variable pour les données utilisateur à insérer
        $utilisateur = new Utilisateur();

        // La variable $form stocke le formulaire
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        
        // handleRequest récupère les données du formulaire stockées dans $request
        // et crée les seters
        $form->handleRequest($request);

        dump($request);

        if($form->isSubmitted() && $form->isValid())
        {   
        
            // Préparation de la requête d'insertion en BDD
            $manager->persist($utilisateur);

            // Exécution de la requête d'insertion en BDD
            $manager->flush();
            
            // Redirection sur le profil personnel du membre quand l'inscription a été réalisée
              return $this->redirectToRoute('membre');
            
        }

        // render() retourne le template registration.html.twig responsable de l'affichage du formulaire d'inscription/connexion.
        // L'indice 'formUtilisateur' utilise la méthode createView() pour stocker le formulaire qui sera renvoyé sur le template
        return $this->render('registration/register.html.twig', [
            'formUtilisateur'=> $form->createView()
        ]);         

    
    }

    /**
     * @Route("/connexion", name="login")
     */

     // La fonction login permet d'afficher le formulaire de connexion
     public function login(AuthenticationUtils $authenticationUtils) :Response
     {
    
        // AuthenticationUtils est une classe prédéfinie en Symfony qui contient des méthodes qui renvoient un message d'erreur en cas de mauvaise connexion
        // (si l'internaute a saisi des identifiants incorrects au moment de la connexion)
    
        $error = $authenticationUtils->getLastAuthenticationError();

        
        // Elle permet aussi de récupérer le dernier username (email) renseigné par l'internaute en cas d'erreur de connexion.
        $lastUsername = $authenticationUtils->getLastUsername();

        // On envoie le message d'erreur et le dernier email saisi sur le template
        return $this->render('login/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
        
     }
}   

