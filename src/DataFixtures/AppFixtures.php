<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Item;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR');

        for ($u=0; $u < 10; $u++) { 
            $user = new User();

            $user->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setPassword('password')
            ;
            
            for ($c=0; $c < mt_rand(2, 4); $c++) { 
                $category = new Category();
    
                $category->setName($faker->name());
    
                $manager->persist($category);
    
                for ($i=0; $i < mt_rand(3, 5); $i++) { 
                    $item = new Item();
    
                    $item->setTitle($faker->sentence())
                        ->setDescription($faker->text())
                        ->setImage($faker->imageUrl(640, 480, 'cats', true, 'Faker'))
                        ->setPrice(mt_rand(20000, 200000))
                        ->setType($faker->randomElement(['Location', 'Vente']))
                        ->setPromo(mt_rand(0, 1))
                        ->setPublished(mt_rand(0, 1))
                        ->setStatus($faker->randomElement(['Terminé', 'Vendu', 'Disponible']))
                        ->setPlace($faker->sentence())
                        ->setCategory($category)
                        ->setUser($user)
                    ;
    
                    $manager->persist($item);
    
                }
            }

            $manager->persist($user);
        }

        $manager->flush();
    }
}
