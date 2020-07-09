<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Docs;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class DocsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {   
        // J'appelle le namespace Factory et je génère des fixtures en français avec la bibliothèque/ Class Faker (https://github.com/fzaninotto/Faker)
        $faker = \Faker\Factory::create('fr_FR');

        // Création d'une boucle pour créer 10 documents en BDD
        for($i = 1; $i <= 10; $i++)
        {
            // Instanciation d'un nouveau document
            $document = new Docs;

            // Instanciation d'un nouvel objet DateTime contenant la date actuelle
            $now = new \DateTime;


            // Création d'une variable contenant la date d'édition du document : date actuelle - 2 ans.
            // Cette variable renvoie un résultat en année  :
            $edition = ($now->format('Y') - 2);
            
            // Création d'une variable contenant la date d'ajout du document dans la table Docs
            $creation = $document->getCreatedAt();

            // La méthode diff() permet de calculer l'intervalle entre la date d'édition et la date de création
            // Cet intervalle permet de s'assurer que la date d'édition du document sera toujours antérieure à la date de son ajout en base de données.
            
            // $intervalle = $edition->diff(($document->getCreatedAt))->format('Y');
            // $intervalle = $edition->diff(($document->getCreatedAt));
            $intervalle = $creation - $edition;

            // Création d'une variable contenant la date d'échéance du document,
            // correspondant à l'année de son ajout en base de données + 8 ans
            
            $echeance = $creation->format('Y') + 8;

            // Création des documents : type, taille, date d'ajout en BDD, date d'édition et date d'échéance
            $document->setType($faker->file)

                    ->setTaille($document->mt_rand(2,4) . 'Mo')

                    ->setDateEdition($faker->date($edition))

                    ->setCreatedAt($faker->date($creation))

                    ->setDateEcheance($faker->date($echeance));
                
            // Préparation des requêtes d'insertion dans la table Docs
            $manager->persist($document);

            
            // Exécution des requêtes SQL dans la table Docs
            $manager->flush();
        }
    }
}
