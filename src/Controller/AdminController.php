<?php

namespace App\Controller;

use App\Entity\Docs;
use App\Entity\Comments;
use App\Entity\Utilisateur;
use App\Repository\DocsRepository;
use App\Repository\CommentsRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController

{
     /*
    On définit une 1re route pour afficher la page d'accueil du Back Office
    */

    /**
    * @Route("/admin", name="admin")
    */

    public function admin()
    {
        return $this->render('admin/admin.html.twig');

    }

    /*  - Pour sélectionner un membre en BBD, on utilise le principe de route paramétrée admin/membre/{id}.
        Notre route attend un paramètre de type {id}, donc de l'id d'un utilisateur qui est stocké en BDD.
        Lorsque nous transmettons une route dans l'URL, par ex "/admin/membre/9, on envoie un id connu dans l'URL
        et Symfony va automatiquement récupérer ce paramètre pour le transmettre en argument de la méthode adminMembre($id).

        - Cela veut dire que nous avons accès à l'id à l'intérieur de la méthode AdminMembre().
        Le but est de sélectionner les données en BDD de l'id récupéré en paramètre.

        - Pour sélectionner des données en BDD, on a besoin de la classe Repository de la classe Utilisateur.
        Une classe Repository permet uniquement de sélectionner des données en BDD (requête SQL SELECT);
        On a besoin de l'ORM Doctrine pour faire la relation entre la BDD et le controller avec getDoctrine().
        getRepository() est une méthode issue de l'objet Doctrine qui permet d'importer une classe Repository (SELECT).
    */

    /* 
        - $this-> j'accède aux méthodes de l'objet

        - $repo est un objet issu de la classe ArticleRepository qui contient des méthodes prédéfinies par Symfony
        et qui permettent de sélectionner des données en BDD (find(), findBy(), findOneBy(), findAll())

        - Dans l'argument d'adminMembre, l'argument $repo accède à toutes les méthodes de la classe ArticleRepository
          $repo = $this->getDoctrine()->getRepository(Utilisateur::class); // "Doctrine, va chercher le Repository de la classe Utilisateur"
          $repo-> cette variable de réception est un objet issu de la classe ArticleRepository. Elle permet de récupérer la sélection faite en BDD

        - getDoctrine fait la relation avec la BDD
        - getRepository importe le repository d'une classe ("va chercher le repository de la classe Utilisateur et retourne un objet de la classe repository)

    */
    

    /*
    - On définit une 2e route pour récupérer toutes les informations sur les 
    membres en bdd ainsi que les colonnes de la table Utilisateur

    - Cette méthode renvoie le template qui affiche une liste de membres

    - Il s'agit d'une route paramétrée qui attend un id en paramètre

    - On ajoute en paramètre une variable de réception $id
    Elle réceptionne un id qui sera stocké dans la route. Ex: /admin/membre/{id 1} pour l'utilisateur 1
    Symfony ira chercher l'article 1 grâce à son id1.
    */

    /**
    * @Route("/admin/membre/{id}", name="admin_membre")
    */
    public function adminMembre(UtilisateurRepository $repo, $id)
    {   
        // On appelle getManager afin de récupérer le noms des champs et des colonnes
        $meta = $this->getDoctrine()->getManager();

        // On sélectionne les colonnes de la table Utilisateur
        $colonnes = $meta->getClassMetaData(Utilisateur::class)->getFieldNames();
        

        // findAll() est une méthode issue de la classe ArticleRepository permettant de sélectionner l'ensemble d'une table SQL, donc ici de la table Utilisateur
        $utilisateurs = $repo->findAll();


        /*
            Grace à la méthode render(), nous demandons au controller d’envoyer les données sélectionnées en BDD dans le Template admin_membre.html.twig
            afin de traiter le rendu visuel avec les langages HTML / TWIG.
        */
        return $this->render('admin/admin_membre.html.twig', [
            'colonne' => $colonnes,
            'utilisateur' => $utilisateurs,
            'id' => $utilisateurs->getId()
        ]);
    }

    /*
    On définit une 2e route pour la gestion des documents
    */

    /**
    * @Route("/admin/document/{id}", name="admin_document")
    */

    public function adminDocs(DocsRepository $repo, $id)
    {
        $meta = $this->getDoctrine()->getManager();

        $colonnes = $meta->getClassMetaData(Docs::class)->getFieldNames();
        
        $docs = $repo->findAll();


        return $this->render('admin/admin_document.html.twig', [
            'colonne' => $colonnes, 
            'document' => $docs
        ]);
    }

    /*
    On définit une 3e route pour gérer les commentaires
    */

    /**
    * @Route("/admin/commentaire/{id}", name="admin_commentaire")
    */

    public function adminCommentaire(CommentsRepository $repo, $id)
    {
        $meta = $this->getDoctrine()->getManager();

        $colonnes = $meta->getClassMetaData(Comments::class)->getFieldNames();
        
        $docs = $repo->findAll();


        return $this->render('admin/admin_commentaire.html.twig', [
            'colonne' => $colonnes, 
            'commentaire' => $commentaire
        ]);
    }
}
// Pour supprimer un document ou un utilisateur :
// $manager->remove(); ?