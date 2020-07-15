<?php

namespace App\Controller;

use App\Entity\Docs;
use App\Form\DocsType;
use App\Entity\Utilisateur;
use App\Repository\DocsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    /*
    On crée un formulaire d'ajout de documents
    */
      /**
     * @Route("/membre/{id}/docs/ajout", name="docs_add")
     */
    public function addDocs(Docs $docs, Request $request, EntityManagerInterface $manager)
    {
        $docs = new Docs;

        $formDoc = $this->createForm(DocsType::class, $docs);

        $formDoc->handleRequest($request);

        if($formDoc->isSubmitted() && $formDoc->isValid())
        {
            
            $manager->persist($docs);
            $manager->flush();
        }
dump($request);

        return $this->render('docs/ajout_docs.html.twig', [
            'formDoc' => $formDoc->createView(),
            'docs' => $docs
        ]);
    }
    
    /*
    On récupère la liste de documents appartenant au membre et on l'affiche
    sous forme de table
    */
       /**
     * @Route("/membre/{id}/docs", name="docs")
     */
   
    public function showDocs(DocsRepository $repo, $id)
    {
        
        $em = $this->getDoctrine()->getManager();

        $colonnes = $em->getClassMetaData(Docs::class)->getFieldNames();

        $docs = $repo->find($id);

        dump($docs);
        dump($colonnes);

        return $this->render('utilisateur/membre_document.html.twig', [
            'colonnes' => $colonnes,
            'docs' => $docs
        ]);
    }
   


    /*
        On définit la fonction qui permettra d'ajouter un document en BDD
        On appelle l'entité qui permet d'insérer les données en BDD
        EntityManagerInterface

        On crée ensuite la variable $document qui réceptionnera le document 
        ajouté par l'utilisateur puis l'enverra en BDD via $manager
    */
    // public function ajoutDocument(Docs $document, EntityManagerInterface $manager)
    // {
    //     $document = new Docs;

    //     $manager->persist($document);

    //     $manager->flush();

    //     return $this->render('membre/membre_document.html.twig');
    // }

    /*
    On calcule la taille totale des documents présents en BDD
    */
    /**
     * @Route
     */
    public function tailleTotale(Docs $docs, DocsRepository $repo, $taille)
    {
        $docs = $repo->find($taille);
    }



}
