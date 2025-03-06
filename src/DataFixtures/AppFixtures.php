<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Account;
use App\Entity\Article;
use Faker;
use DateTimeImmutable;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
            $faker = Faker\Factory::create('fr_FR');
            // Tableaux
            $accounts=[];
            $categories=[];
            for ($i=0; $i < 50 ; $i++) { 
                //Ajouter un compte
                $account = new Account();
                $account->setFirstname($faker->firstName())
                        ->setLastname($faker->lastName())
                        ->setEmail($faker->email())
                        ->setPassword($faker->password())
                        ->setRoles( "ROLE_USER");
                //Ajout en cache

                $manager->persist($account);
                $accounts[] = $account;
            }

            for($i=0;$i<30;$i++){
                $category = new Category();
                $category->setName($faker->unique()->jobTitle());
    
                // Ajout en cache
                $manager->persist($category);
                $categories[]= $category;
            }


            for($i=0;$i<100;$i++){
                $articles=[];
                // Ajouter des articles
                $article = new Article();
                $article->setTitle($faker->sentence())
                        ->setContent($faker->paragraph())
                        ->setCreateAt(new \DateTimeImmutable($faker->date()))
                        ->setAuthor($accounts[$faker->numberBetween(0,49)]);
                    $article->addCategory($categories[$faker->numberBetween(0,9)]);
                    $article->addCategory($categories[$faker->numberBetween(10,19)]);
                    $article->addCategory($categories[$faker->numberBetween(20,29)]);
                        // Ajout en cache
                    $manager->persist($article);
                    $articles[]= $article;
                    }
            //Enregistrement en base de données     
            $manager->flush();
        }


}
