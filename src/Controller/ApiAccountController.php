<?php

namespace App\Controller;

use App\Entity\Account;
use App\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;


class ApiAccountController extends AbstractController
{
    public function __construct(
        private AccountRepository $accountRepository,
        private readonly EntityManagerInterface $em,
        private readonly SerializerInterface $serializer
    ) {}

    #[Route('/api/accounts', name: 'api_account_all')]
    public function getAllAccounts(): Response
    {
        return $this->json(
            $this->accountRepository->findAll(),
            200,
            [],
            ['groups' => 'account:read']
        );
    }

    public function addAccount(Request $request): Response
    {
        //Récupération le body de la requête
        $request = $request->getContent();
        //Convertir en objet account
        $account = $this->serializer->deserialize($request, Account::class, 'json');
        //Tester si le compte n'existe pas
        if (!$this->accountRepository->findOneBy([
            "email" => $account->getEmail()
            ])) {
            $this->em->persist($account);
            $this->em->flush();
            $code = 201;
        }
        //Si le compte existe deja via l'adresse email
        else {
            $account = "L'utilisateur existe déjà";
            $code = 400;
        }
        return $this->json($account, $code, [
            "Access-Control-Allow-Origin" => "*",
            "Content-Type" => "application/json"
        ], []);
    }
}