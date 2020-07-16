<?php

namespace App\Controller;

use App\Entity\Docs;
use App\Form\DocsType;
use App\Entity\Utilisateur;
use App\Repository\DocsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
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
     * @Route("/membre/docs/ajout/{id}", name="add_docs")
     */
    public function addDocs(Docs $docs, Request $request, SluggerInterface $slugger, EntityManagerInterface $manager)
    {
        $docs = new Docs;

        $form = $this->createForm(DocsType::class, $docs);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $docFile = $formDoc->get('docFile')->getData();

            // Le champ docfile n'étant pas requis, le document sera traité uniquement lorsqu'un pdf sera chargé
            // if($docs)
            // {
            //     // $taille = $docs->getDocFile();
            // }
            if ($docFile) {
                $originalFilename = pathinfo($docFile->getClientOriginalName(), PATHINFO_FILENAME);
                // On inclut le nom du fichier comme une partie de l'url
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$docFile->guessExtension();

                // On déplace le fichier vers le dossier de stockage des documents
                try {
                    $docFile->move(
                        $this->getParameter('documents_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->getError();
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $docs->setDocFilename($newFilename);
            }
            $form->getData()
                ->setCreatedAt(new \DateTime('now'))
                ->setDateEdition($date);

              // ... persist the $product variable or any other work
            $manager->persist($docs);
            $manager->flush();

            return $this->redirect($this->generateUrl('app_doc_list'));
           
        }
        dump($request);

        return $this->render('docs/ajout_docs.html.twig', [
            'formDoc' => $form->createView(),
            'docs' => $docs,
            'request' => $request,
            // 'taille' => $taille
        ]);
    }
    
    
    /*
    showDocs() affiche la liste des documents
    On récupère la liste de documents appartenant au membre et on l'affiche
    sous forme de table
    */

    /**
     * @Route("/membre/{id}/docs", name="docs")
     */
    public function showDocs(UtilisateurRepository $repo, $id)
    {
        $utilisateur = $repo->find($id);

        dump($utilisateur);
        return $this->render('docs/show.html.twig', [
            'docs' => $utilisateur,
        ]);
    }

   
   
    // SUPPRESSION DE DOCUMENT
    /**
     * @Route("/docs/delete/{id}", name="delete_docs")
     * Method({"DELETE"})
     */
    public function delete(DocsRepository $repo, Request $request, EntityManagerInterface $manager, $id)
    {
        $doc = $repo->find($id);
    
        $em = $this->getDoctrine()->getManager();
        $manager->remove($doc);
        $manager->flush();

        // On définit un objet $response qui enverra grâce à la méthode send() 
        // une réponse qui sera récupérée par javascript pour afficher l'alerte
        $response = new Response;
        $response->send();
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
    // /**
    //  * @Route
    //  */
    // public function tailleTotale(Docs $docs, DocsRepository $repo, $taille)
    // {
    //     $docs = $repo->find($taille);
    // }



}
