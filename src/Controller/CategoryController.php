<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CategoryRepository;

final class CategoryController extends AbstractController
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository
    ) {}


    public function showAllCategories(): Response
    {

        return $this->render('categories.html.twig', [
            'categories' => $this->categoryRepository->findAll(),
        ]);
    }
}