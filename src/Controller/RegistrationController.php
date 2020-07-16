<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    
    // La méthode register() affiche le formulaire d'inscription qui permet de s'inscrire sur Docx
    // Request est une classe prédéfinie en Symfony qui stocke les données véhiculées par les superglobales et exécute les requêtes en BDD.
    // EntityManagerInterface est une classe prédéfinie en Symfony qui permet de manipuler les lignes de la BDD (INSERT, UPDATE, DELETE)
    // UserPasswordEncoderInterface est une classe prédéfinie en Symfony qui contient des méthodes abstraites pour encoder le mot de passe dans la BDD
    // Il faut donc les déclarer dans le controller, même si elles ne seront pas utilisées par la suite.
    
    /**
     * @Route("/inscription", name="registration")
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {   
        // Création d'une variable qui précise à quelle entité sera reliée notre formulaire.
        $utilisateur = new Utilisateur();

        // La variable $form permet de contruire et de stocker le formulaire.
        // Le deuxième paramètre relie le formulaire à l'entité Utilisateur.
        $form = $this->createForm(RegistrationType::class, $utilisateur);
        
        // handleRequest récupère les données du formulaire stockées dans $request
        // et crée les seters
        $form->handleRequest($request);

        //dump($request);

        if($form->isSubmitted() && $form->isValid())
        {   
            // On transmet à la méthode encodePassword() de l'interface UserPasswordEncoderInterface le mot de passe du formulaire à encoder
            // $hash contient le mot de passe encodé.
            // 1er argument est de type $user car le mot de passe est crypté au moment de l'insertion du nouveau membre.
            // 2e argument est le champ password.
            $hash = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());

            // On transmet le MDP au seter de l'objet $utilisateur pour le hacher
            $utilisateur->setPassword($hash);
-
            // On affecte un ROLE_USER par défaut à chaque nouvel inscrit sur le site. Il n'aura donc pas accès au back office.
            // $utilisateur->setRoles(["ROLE_USER"]);

            // Préparation et stockage de la requête d'insertion en BDD
            $manager->persist($utilisateur);

            // Exécution de la requête d'insertion en BDD
            $manager->flush();

            // Affichage de la confirmation d'inscription du nouveau membre
            $this->addFlash('inscription', 'Félicitations pour votre inscription. Vous pouvez maintenant vous connecter.');

            // Redirection vers la page de connexion quand l'inscription a été correctement réalisée
            return $this->redirectToRoute("login");
    
        }

        // render() retourne le template registration.html.twig responsable de l'affichage du formulaire d'inscription.
        // L'indice 'formUtilisateur' utilise la méthode createView() pour stocker le formulaire qui sera renvoyé sur le template
        return $this->render('registration/register.html.twig', [
            // Ce paramètre permet de récupérer le formulaire et de l'envoyer à TWIG.
            'formInscription'=> $form->createView()
        ]);         

    
    }

    /**
     * @Route("/connexion", name="login")
     */

     // La méthode login() affiche le formulaire de connexion qui permet de se connecter à son profil sur Docx.
     public function login(AuthenticationUtils $authenticationUtils) : Response
     {      
            $utilisateur = new Utilisateur;

            // AuthenticationUtils est une classe prédéfinie en Symfony qui contient des méthodes qui renvoient un message d'erreur en cas de mauvaise connexion
            // (si l'internaute a saisi des identifiants incorrects au moment de la connexion).
            
            // $error affiche le message d'erreur
            $error = $authenticationUtils->getLastAuthenticationError();

            
            // Elle permet aussi de récupérer le dernier username (email) renseigné par l'internaute en cas d'erreur de connexion.
            $lastUsername = $authenticationUtils->getLastUsername();

                // Redirection vers l'espace personnel du membre quand l'inscription a été réalisée.
                // return $this->redirectToRoute("membre", [
                //     'id' => $utilisateur->getId()
                // ]);
            dump($utilisateur);
            // On envoie le message d'erreur et le dernier email saisi sur le template responsable de l'affichage du formulaire de connexion.
            return $this->render('registration/login.html.twig', [
                'last_username' => $lastUsername,
                'error' => $error,
                'id' => $utilisateur->getId()
            ]);
        
     }


    /**
     * @Route("/deconnexion", name="logout")
     *
     */

    // Cette route permet de se déconnecter
    
    public function logout()
    {
        // Cette méthode ne retourne rien. Il nous suffit d'avoir une route pour la déconnexion.
    }
}   

