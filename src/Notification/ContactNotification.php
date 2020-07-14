<?php

namespace App\Notification;
use App\Entity\Contact;
use Twig\Environment;

    // ContactNotification est le controller réservé à l'envoi d'emails.
    class ContactNotification
    {
        /**
        * @var \Swift_Mailer
        */

        private $mailer;

        /**
        * @var Environment
        */

        private $renderer;

        public function __construct(\Swift_Mailer $mailer, Environment $renderer)
        {
            $this->mailer = $mailer;
            $this->renderer = $renderer;
        }

        // La méthode notify() permet de générer des emails et renvoie le template
        // chargé d'afficher l'email de bienvenue reçu à l'inscription sur le site.
    //     public function notify(Contact $contact)
    //     {
    //         $message = (new \Swift_Message('Message : ' . $contact->getMessage()))
            
    //                 // Expéditeur de l'email
    //                 ->setFrom($contact->getEmail())

    //                 // Destinataire de l'email
    //                 ->setTo('joanna.renel@yahoo.fr')

    //                 // Adresse de réponse
    //                 ->setReplyTo($contact->getEmail())

    //                 // Corps de l'email
    //                 ->setBody($this->renderer->render('emails/email.html.twig', [
    //                 'Emailcontact' => $contact
    //                 ]), 'text/html');

    //         // Envoi de l'email
    //         $this->mailer->send($message);
    //     }
     }
    // // $message permet d'afficher l'objet du message à la réception du mail
    // $message = (new \Swift_Message('Message : ' . $contact->getMessage()));
