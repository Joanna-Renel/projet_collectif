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
        
        // if($utilisateur->getPremium() == 'non')
        // {
         //   $this->addFlash('success', 'Profitez de notre offre exceptionnelle et devenez membre Premium 
        // pour 24€99 seulement');
        // }

        dump($utilisateur);

        $form = $this->createForm(UtilisateurType::class, $utilisateur);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $utilisateur = $form->getData() ;
            
            //stocke les valeurs renseignées dans le formulaire
            // et les met à jour (fais la même chose que $manager->persist() et ->flush())

            $manager->persist($utilisateur);
            $manager->flush();

            $this->addFlash('success', 'Vos modifications ont bien été prises en compte');

            return $this->redirectToRoute('membre_update', [
                'id' => $utilisateur->getId(),
            ]);

        }

        return $this->render('utilisateur/membre.html.twig', [
            'formUser' => $form->createView(),
            'utilisateur' => $utilisateur ,
        ]);
    
    }


    /**
     * @Route("membre/{id}/update", name="membre_update")
     */
    public function update(Utilisateur $utilisateur, Request $request, EntityManagerInterface $manager)
    {
    
        $form = $this->createForm(UtilisateurType::class, $utilisateur);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {            
            
            $manager->persist($utilisateur);
            $manager->flush();

            $this->addFlash('success', 'Vos modifications ont bien été prises en compte');

            return $this->redirectToRoute('membre_update');

        }

        return $this->render('utilisateur/membre.html.twig', [
            'formUser' => $form->createView(),
            'utilisateur' => $utilisateur ,

            
        ]);
    
    }
    /*
    Ajouter show() pour tests avec route pour docs et template dans docs
    */ 
   
    /**
     * @Route("/membre/docs/{id}", name="membre_docs")
     */
    public function show(UtilisateurRepository $repo, $id, EntityManagerInterface $manager)
    {
        $utilisateur = $repo->find($id);
                   
        dump($utilisateur);
     

        return $this->render('utilisateur/showMyDocs.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
       
    }



    // Création d'une nouvelle route pour afficher la page 
    // profil d'un membre
    /**
     * @Route("/membre/{id}", name="membre")
     */
    // public function profil(UtilisateurRepository $repo, Request $request, $id)
    // {
    //     /*
    //         profil() affiche la page du membre après qu'il se soit connecté
    //         Les informations sélectionnées en BDD s'affichent dans un formulaire
            
    //         Le formulaire est créé grâce à la méthode Symfony createForm() suivant 
    //         les champs répertoriés dans la classe UtilisateurType
            
    //         Les champs du formulaire sont préremplis par les données utilisateur.
    //         L'utilisateur étant identifié par son id
    //     */
    //     $utilisateur = $repo->find($id);
               
    //     $form = $this->createForm(UtilisateurType::class, $utilisateur);

    //     $form->handleRequest($request);

        

    //     return $this->render('utilisateur/membre.html.twig', [
    //         'formUser' => $form->createView(),
    //         'prenom' => $utilisateur->getPrenom(),
    //         'utilisateur' => $utilisateur
    //     ]);
    // }

    // // showDocs() permet d'avoir accès à la liste des documents en BDD
    // /**
    //  * @Route("/membre/docs", name="membre_docs")
    //  */
    // public function showDocs(DocsRepository $repo)
    // {
    //     return $this->render('utilisateur/membre_document.html.twig');
    // }

  
    

    
}
