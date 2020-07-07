<?php

namespace App\DataFixtures;

use Faker\Factory;
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

        
        // Exécution des requêtes SQL dans la table Utilisateur
        $manager->flush();

        }


    }
}
