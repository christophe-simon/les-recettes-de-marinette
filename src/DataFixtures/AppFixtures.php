<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Recipe;
use App\Entity\Ingredient;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Ingredients
        $ingredients = [];
        for ($i = 1; $i <= 50; $i++) {
            $ingredient = new Ingredient();
            $ingredient->setName($faker->word())
                ->setPrice(mt_rand(0.01, 100));

            $ingredients[] = $ingredient;
            $manager->persist($ingredient);
        }

        // Recipes
        for ($j = 1; $j <= 25; $j++) {
            $recipe = new Recipe();
            $recipe->setName($faker->word())
                ->setPreparationTime(mt_rand(0, 1) == 1 ? mt_rand(1, 1439) : null)
                ->setNumberOfPeople(mt_rand(0, 1) == 1 ? mt_rand(1, 49) : null)
                ->setDifficulty(mt_rand(0, 1) == 1 ? mt_rand(1, 5) : null)
                ->setDescription($faker->text(300))
                ->setPrice(mt_rand(0, 1) == 1 ? mt_rand(1, 999) : null)
                ->setIsFavorite(mt_rand(0, 1) == 1 ? true : false);

            for ($k = 1; $k <= mt_rand(5, 15); $k++) {
                $recipe->addIngredient($ingredients[mt_rand(0, count($ingredients) - 1)]);
            }

            $manager->persist($recipe);
        }

        $manager->flush();
    }
}
