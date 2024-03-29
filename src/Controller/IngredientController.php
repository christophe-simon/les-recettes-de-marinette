<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IngredientController extends AbstractController
{
    /**
     * This method enables to display all ingredients
     *
     * @param IngredientRepository $repo
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/ingredients', name: 'app_ingredients_index', methods: ['GET'])]
    public function index(IngredientRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $ingredients = $paginator->paginate(
            $repo->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('pages/ingredient/index.html.twig', [
            'ingredients' => $ingredients
        ]);
    }

    /**
     * This method enables to add a new ingredient
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/ingredient/creation', name: 'app_ingredient_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ingredient = $form->getData();

            $manager->persist($ingredient);
            $manager->flush();

            $this->addFlash(
                'success',
                'L\'ingrédient a été créé avec succès!'
            );

            return $this->redirectToRoute('app_ingredients_index');
        }

        return $this->render('pages/ingredient/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * This method enables to update an existing ingredient
     * 
     * @param Ingredient $ingredient
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/ingredient/modification/{id}', name: 'app_ingredient_update', methods: ['GET', 'POST'])]
    public function update(Ingredient $ingredient, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(IngredientType::class, $ingredient);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ingredient = $form->getData();

            $manager->persist($ingredient);
            $manager->flush();

            $this->addFlash(
                'success',
                'L\'ingrédient a été modifié avec succès!'
            );

            return $this->redirectToRoute('app_ingredients_index');
        }

        return $this->render('pages/ingredient/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * This method enables to delete an existing ingredient
     * 
     * @param Ingredient|null $ingredient
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/ingredient/suppression/{id}', name: 'app_ingredient_delete', methods: ['GET'])]
    public function delete(?Ingredient $ingredient, EntityManagerInterface $manager): Response
    {
        if (!$ingredient) {
            $this->addFlash(
                'warning',
                'L\'ingrédient n\'a pas été trouvé.'
            );

            return $this->redirectToRoute('app_ingredients_index');
        }

        $manager->remove($ingredient);
        $manager->flush();

        $this->addFlash(
            'success',
            'L\'ingrédient a été supprimé avec succès!'
        );

        return $this->redirectToRoute('app_ingredients_index');
    }
}
