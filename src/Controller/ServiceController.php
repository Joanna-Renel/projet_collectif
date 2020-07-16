<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\CommentsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiceController extends AbstractController
{
    // Méthode qui permet l'affiche de la page services et qui permet de laisser un commentaire sur les services utilisés par les membres.

    /**
     * @Route("/service", name="service")
     */
    public function comment(Comments $comments = null, Request $request, EntityManagerInterface $manager)
    {   
        // Création d'un nouveau commentaire
        $comments = new Comments;

        // Création du formulaire pour enregistrer un commentaire
        $form = $this->createForm(CommentsType::class, $comments);

        $form->handleRequest($request); 
        
        if($form->isSubmitted() && $form->isValid())

        {  // On génère la date pour l'insertion en BDD
           $comments->setCreatedAt(new \DateTime())

                    // On relie l'utilisateur au commentaire 
                    ->setUtilisateur($utilisateur);

            // On prépare l'insertion        
            $manager->persist($comments);

            // On execute l'insertion
            $manager->flush();
            
            // Redirection vers la page d'accueil avec affichage du commentaire enregistré ?
            //return $this->redirectToRoute('home', [ 
            //    'id' => $comments->getId() ]);

        }
        return $this->render('service/service.html.twig', [
            'controller_name' => 'ServiceController',
            'formCommentaire' => $form->createView()
        ]);
    }
}
