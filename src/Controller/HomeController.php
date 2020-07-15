<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */

    // La méthode index() renvoie le contenu de la page d'accueil
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


    /**
     * @Route("/home/contact", name = "contact")
     * 
     */

    // La méthode contact() permet d'afficher le formulaire de contact
    // ContactNotification est la classe contenant la méthode notify() permettant l'envoi d'emails
    public function contact(Request $request, EntityManagerInterface $manager, ContactNotification $notification)
    {   
        // Création d'un nouveau contact
        $contact = new Contact();

        // Création d'un formulaire de contact
        $form = $this->createForm(ContactType::class, $contact);

        // Récupération des données saisies dans le formulaire de contact
        $form->handleRequest($request);

            // Si le formulaire est soumis et valide, préparation et exécution de la requête
            if ($form->isSubmitted() && $form->isValid())
            {   
                // On notifie le contact
                $notification->notify($contact);

                // Confirmation d'envoi de l'email grâce à la méthode addFlash()
                $this->addFlash('success', 'Votre email a bien été envoyé');

                // on prépare l'insertion
                $manager->persist($contact);
                // on execute l'insertion
                $manager->flush(); 
            }
        
        return $this->render("home/contact.html.twig", [
        'formContact' => $form->createView()
        ]);
    }
}
    


