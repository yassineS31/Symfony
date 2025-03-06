<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ArticleRepository;

final class ArticleController extends AbstractController
{
    public function __construct(
        private readonly ArticleRepository $articleRepository
    ) {}


    public function showAllArticle(): Response
    {

        return $this->render('articles.html.twig', [
            'articles' => $this->articleRepository->findAll(),

        ]);
    }
}