<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Docs;
use App\Entity\Comments;
use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UtilisateurFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {   
        // J'appelle le namespace Factory et je génère des fixtures/fausses données en français avec la bibliothèque/ Class Faker (https://github.com/fzaninotto/Faker)
        $faker = \Faker\Factory::create('fr_FR');
        
        // Création d'une boucle pour créer 10 utiisateurs en BDD
        for($i = 1; $i <= 10; $i++)
        {
            $utilisateur = new Utilisateur;

            // Création des données utilisateur : prénom, nom, username, email, adresse, password, premium
            $utilisateur->setPrenom($faker->firstName)

                        ->setNom($faker->lastName)

                        ->setUsername($faker->userName)

                        ->setEmail($faker->email)

                        ->setAdresse($faker->address)

                        ->setPassword($faker->password);

                    
            // Création d'un statut premium en fonction de l'indice pair ou impair
            if($i % 2 == 0)
            {
                $utilisateur->setPremium('oui');  
            } else {
                $utilisateur->setPremium('non');
            }
            
            
            // Préparation des requêtes d'insertion dans la table Utilisateur
            $manager->persist($utilisateur);

                // Boucle for permettant de créer entre 4 et 6 commentaires pour chaque utilisateur
                for($j = 1; $j <= mt_rand(4,6); $j++)
                {
                    // Instanciation d'un nouvel objet Comments pour créer de nouveaux commentaires
                    $comments = new Comments;

                    // Création de deux paragraphes distincts à la suite
                    $content = '<p>' . join($faker->paragraphs(2), '<p></p>') . '</p>';

                    // Objet contenant la date actuelle. Il faut faire en sorte d'avoir des dates de commentaires cohérentes,
                    // cad entre la date de création des articles et la date d'aujourd'hui
                    $now = new \DateTime;

                    // Création de la date d'ajout du commentaire utilitsateur en base de données
                    $comments->setCreatedAt($now);

                    // Création de pseudonymes aléatoires grâce à UserName()
                    $comments->setPseudo($faker->userName());
                    
                    // Création du contenu des commentaires
                    $comments->setCommentaire($content);

                    // Liaison des commentaires aux utilisateurs
                    $comments->setUtilisateur($utilisateur);

                    // Préparation de la requête SQL pour l'insertion des commentaires dans la table Comments
                    $manager->persist($comments);

                        // Boucle for permettant de créer les documents enregistrés par les utilisateurs
                        for($k = 1; $k <= 8; $k++)
                        {
                            // Instanciation de la class Docs pour créer de nouveaux documents
                            $document = new Docs;
                            
                            // Instanciation d'un nouvel objet DateTime contenant la date actuelle sous forme de timestamp
                            $now = new \DateTime;

                            // Création des documents : document, taille, date d'ajout en BDD, date d'édition et date d'échéance
                            $document->setDocument($faker->imageUrl())

                                    ->setTaille(($faker->randomDigitNotNull) . 'Mo')

                                    ->setDateEdition($faker->dateTimeBetween('-6 months'))

                                    ->setCreatedAt($faker->dateTimeBetween('-6 months'))

                                    ->setDateEcheance($faker->dateTimeBetween('-6 months'))

                                    // Liaison des documents à chaque utilisateur
                                    ->setUtilisateur($utilisateur);
                            
                                    // Préparation des requêtes d'insertion dans la table Docs
                                    $manager->persist($document);

                        }
                }         
           
           

        }
        // Exécution des requêtes SQL dans la table Utilisateur
         $manager->flush();
    }
}
