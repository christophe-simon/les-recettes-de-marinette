<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecipeController extends AbstractController
{
    /**
     * This method enables to display all recipes
     *
     * @param RecipeRepository $repo
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/recettes', name: 'app_recipes_index', methods: ['GET'])]
    public function index(RecipeRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $recipes = $paginator->paginate(
            $repo->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('pages/recipe/index.html.twig', [
            'recipes' => $recipes
        ]);
    }

    /**
     * This method enables to add a new recipe
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/recette/creation', name: 'app_recipe_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();

            $manager->persist($recipe);
            $manager->flush();

            $this->addFlash(
                'success',
                'La recette a été créée avec succès!'
            );

            return $this->redirectToRoute('app_recipes_index');
        }

        return $this->render('pages/recipe/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * This method enables to update an existing recipe
     * 
     * @param Recipe $recipe
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/recette/modification/{id}', name: 'app_recipe_update', methods: ['GET', 'POST'])]
    public function update(Recipe $recipe, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();

            $manager->persist($recipe);
            $manager->flush();

            $this->addFlash(
                'success',
                'La recette a été modifiée avec succès!'
            );

            return $this->redirectToRoute('app_recipes_index');
        }

        return $this->render('pages/recipe/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * This method enables to delete an existing recipe
     * 
     * @param Recipe|null $recipe
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/recette/suppression/{id}', name: 'app_recipe_delete', methods: ['GET'])]
    public function delete(?Recipe $recipe, EntityManagerInterface $manager): Response
    {
        if (!$recipe) {
            $this->addFlash(
                'warning',
                'La recette n\'a pas été trouvée.'
            );

            return $this->redirectToRoute('app_recipes_index');
        }

        $manager->remove($recipe);
        $manager->flush();

        $this->addFlash(
            'success',
            'La recette a été supprimée avec succès!'
        );

        return $this->redirectToRoute('app_recipes_index');
    }
}
