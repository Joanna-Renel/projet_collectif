<?php

namespace App\Controller;

use App\Entity\Docs;
use App\Entity\Utilisateur;
use App\Repository\DocsRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /*
    adminMembre() permet de récupérer toutes les informations sur les 
    membres en bdd ainsi que les colonnes de la table Utilisateur
    */

    /**
     * @Route("/admin/membre, name="admin")
     */
    public function adminMembre(UtilisateurRepository $repo)
    {
        $meta = $this->getDoctrine()->getManager();

        $colonnes = $meta->getClassMetaData(Utilisateur::class)->getFieldNames();
        
        $utilisateurs = $repo->findAll();

        dump($utilisateurs);

        return $this->render('admin/admin.html.twig', [
            'colonne' => $colonnes,
            'utilisateur' =>$utilisateurs
        ]);
    }

    /*
    On définit une 2e route pour la gestion des documents
    */

    /**
     * @Route("/admin/docs", name="admin_docs")
     */
    public function adminDocs(DocsRepository $repo)
    {
        $meta = $this->getDoctrine()->getManager();

        $colonnes = $meta->getClassMetaData(Docs::class)->getFieldNames();
        
        $docs = $repo->findAll();


        return $this->render('admin/admin_docs.html.twig', [
            'colonne' => $colonnes, 
            'document' => $docs
        ]);
    }

    /*
    On définit une 3e route pour gérer le nombre d'abonnements premium
    */
}
