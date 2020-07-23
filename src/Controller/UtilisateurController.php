<?php

namespace App\Controller;

use App\Entity\Docs;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/membre/{id}", name="membre")
     */
    public function home(Utilisateur $utilisateur = null, Request $request, EntityManagerInterface $manager, UtilisateurRepository $repo)
    {
        /* 
            On injecte les dépendances:
            Utilisateur pour stocker les données récupérées par le 
            formulaire
            Request qui récupère les données du formulaire grâce à la méthode POST
            et EntityManagerInterface qui contient les méthodes permettant de faire 
            les liens avec la base de données.


            Pour créer un formulaire via les méthodes de Symfony, nous commençons par 
            instancier l'objet $user qui sera le réceptacle des données récupérées par 
            $request
            On déclare un nouvel objet $form qui va créer les champsdu formulaire via 
            la méthode createForm() 

            Les données du formulaire seront récupérées via l'objet $request qui contient
            les infos du formulaire

            $user = $this->getUser();
            Pour récupérer l'id $user->getId();
        */

        // $utilisateur = $repo->find($id);
        
        // Si l'utilisateur n'est pas premium il reçoit une alerte promotionnelle
        
        if($utilisateur->getPremium() == 'non')
        {
           $this->addFlash('success', 'Profitez de notre offre exceptionnelle et devenez membre Premium 
        pour 24€99 seulement !!!');
        }

        $form = $this->createForm(UtilisateurType::class, $utilisateur);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {            
            //stocke les valeurs renseignées dans le formulaire
            // et les met à jour (fais la même chose que $manager->persist() et ->flush())
            $utilisateur = $form->getData();

            // $manager = $this->getDoctrine()->getManager();
            $manager->persist($utilisateur);
            
            $this->addFlash('notice', 'Vos modifications ont bien été prises en compte');
            return $this->redirectToRoute('membre', [
                'id' => $utilisateur->getId(),
            ]);
            
        }
        $manager->flush();
       
        dump($utilisateur);


        return $this->render('utilisateur/membre.html.twig', [
            'formUser' => $form->createView(),
            'utilisateur' => $utilisateur ,
        ]);
    
    }

    // /*
    // Ajouter show() pour tests avec route pour docs et template dans docs
    // */ 
   
    // /**
    //  * @Route("/membre/docs/{id}", name="membre_docs")
    //  */
    // public function show(UtilisateurRepository $repo, $id, EntityManagerInterface $manager)
    // {
    //     $utilisateur = $repo->find($id);
                   
    //     dump($utilisateur);
     

    //     return $this->render('utilisateur/showMyDocs.html.twig', [
    //         'utilisateur' => $utilisateur,
    //     ]);
       
    // }
    /**
     * @Route("/membre/{id}/pwd", name="edit_pwd")
     */
    public function newPassword(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
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


        }
        // Affichage de la confirmation d'inscription du nouveau membre
        $this->addFlash('success', 'Félicitations votre mot de passe est bien mis à jour!');

        // Redirection vers la page de connexion quand l'inscription a été correctement réalisée
        return $this->redirectToRoute("membre");


        // render() retourne le template registration.html.twig responsable de l'affichage du formulaire d'inscription.
        // L'indice 'formUtilisateur' utilise la méthode createView() pour stocker le formulaire qui sera renvoyé sur le template
        return $this->render('utilisateur/pwd.html.twig', [
            // Ce paramètre permet de récupérer le formulaire et de l'envoyer à TWIG.
            'formEdit'=> $form->createView()
        ]);         

    
    }


    
}
