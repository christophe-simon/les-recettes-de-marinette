<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Recipe;
use App\Entity\Ingredient;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $uniqueIngredientsNames = [];
        $uniqueRecipesNames = [];

        // Ingredients
        $ingredients = [];
        for ($i = 0; $i < 50; $i++) {
            do {
                $ingredientName = $faker->word();
            } while (in_array($ingredientName, $uniqueIngredientsNames));

            $ingredient = new Ingredient();
            $ingredient->setName($ingredientName)
                ->setPrice(mt_rand(1, 9999) / 100);

            $uniqueIngredientsNames[] = $ingredientName;
            $ingredients[] = $ingredient;
            $manager->persist($ingredient);
        }

        // Recipes
        for ($i = 0; $i < 25; $i++) {
            do {
                $wordsArray = $faker->words(mt_rand(1, 3));
                $recipeName = implode(' ', $wordsArray);
            } while (in_array($recipeName, $uniqueRecipesNames));

            $recipe = new Recipe();
            $recipe->setName($recipeName)
                ->setPreparationTime(mt_rand(0, 1) == 1 ? mt_rand(1, 1439) : null)
                ->setNumberOfPeople(mt_rand(0, 1) == 1 ? mt_rand(1, 49) : null)
                ->setDifficulty(mt_rand(0, 1) == 1 ? mt_rand(1, 5) : null)
                ->setDescription($faker->text(300))
                ->setPrice(mt_rand(0, 1) == 1 ? mt_rand(1, 999) : null)
                ->setIsFavorite(mt_rand(0, 1) == 1 ? true : false);

            $uniqueRecipesNames[] = $recipeName;

            for ($j = 1; $j <= mt_rand(5, 15); $j++) {
                $recipe->addIngredient($ingredients[mt_rand(0, count($ingredients) - 1)]);
            }

            $manager->persist($recipe);
        }

        // Users
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->setFullName($faker->name())
                ->setPseudo($faker->firstName())
                ->setEmail($faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('password');

            $manager->persist($user);
        }

        $manager->flush();
    }
}
