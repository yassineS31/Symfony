<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController {
    #[Route('/register', name: 'app_register')]
    public function register(): Response {
        return $this->render('user/index.html.twig');
    }
}
