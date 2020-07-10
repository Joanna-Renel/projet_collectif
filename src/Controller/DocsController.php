<?php

namespace App\Controller;

use App\Entity\Docs;
use App\Entity\Utilisateur;
use App\Repository\DocsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DocsController extends AbstractController
{
    /*
        On affiche la liste des documents que l'utilisateur identifié 
        par son id a déja enregistré en base de données.

        Cette liste de documents sera affichée dans un tableau.
        On récupère toutes les informations en BDD (metadonnées) concernant la table document 
        De ces métadonnées récupérées, on sélectionne le nom des colonnes

        Les données récupérées seront ensuite envoyées pour affichage 
        dans la vue membre_document
    */

    /**
     * @Route("membre/{id}/docs", name="docs")
     */
    public function showDocs(DocsRepository $repo)
    {

        // $utilisateur = new Utilisateur;
        $em = $this->getDoctrine()->getManager();

        $colonnes = $em->getClassMetaData(Docs::class)->getFieldNames();

        $documents = $repo->findAll();
        dump($documents);
        dump($colonnes);

        return $this->render('utilisateur/membre_document.html.twig', [
            'colonnes' => $colonnes,
            'documents' => $documents
        ]);
    }

    /*
        On définit la fonction qui permettra d'ajouter un document en BDD
        On appelle l'entité qui permet d'insérer les données en BDD
        EntityManagerInterface

        On crée ensuite la variable $document qui réceptionnera le document 
        ajouté par l'utilisateur puis l'enverra en BDD via $manager
    */
    public function ajoutDocument(Docs $document, EntityManagerInterface $manager)
    {
        $document = new Docs;

        $manager->persist($document);

        $manager->flush();

        return $this->render('membre/membre_document.html.twig');
    }

    /*
    */
    /**
     * @Route
     */
}
