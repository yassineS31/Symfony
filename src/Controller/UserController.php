<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AccountRepository;
class UserController extends AbstractController {
    #[Route('/register', name: 'app_register')]

    public function __construct(
        private readonly AccountRepository $accountRepository
    ){}
    public function register(): Response {
        return $this->render('user/index.html.twig');
    }

    public function showAllAccounts(): Response
    {
        return $this->render('account.html.twig', [
            'account' => $this->accountRepository->findAll(),
        ]);
    }

}