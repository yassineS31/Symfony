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
                if(!$this->accountRepository->fin)
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

    public function updateAccount(Request $request): Response
{
    // Récupération du contenu de la requête
    $requestContent = $request->getContent();

    //Convertir en objet account
    $account = $this->serializer->deserialize($requestContent, Account::class, 'json');

    // check si le compte existe via l'email
    $accountInBDD = $this->accountRepository->findOneBy([
        "email" => $account->getEmail()
    ]);

    if (!$accountInBDD) {
        return $this->json(["error" => "L'email n'existe pas en bdd"], 
    $code= 404);
    }

    // Mise à jour des données
    $accountInBDD->setFirstname($account->getFirstname());
    $accountInBDD->setLastname($account->getLastname());
    $code= 200;
    // Sauvegarde en base de données
    $this->em->persist($accountInBDD);
    $this->em->flush();

    return $this->json($account, $code, [
        "Access-Control-Allow-Origin" => "*",
        "Content-Type" => "application/json"
    ], []);

}
// public function deleteAccount(Request $request): Response
// {
//     // Récupération du contenu de la requête
//     $requestContent = $request->getContent();

//     // Convertir en objet Account
//     $account = $this->serializer->deserialize($requestContent, Account::class, 'json');

//     // Vérification de l'existence du compte via l'email
//     $accountInBDD = $this->accountRepository->findOneBy([
//         "email" => $account->getEmail()
        
//     ]);

//     if (!$accountInBDD) {
//         $code = 404;
//         return $this->json(["error" => "L'email n'existe pas en BDD"], 
//     $code);
//     }

//     // Suppression du compte
//     $this->em->remove($accountInBDD);
//     $this->em->flush();
//     $code = 200;
//     return $this->json($account, $code, [
//         "Access-Control-Allow-Origin" => "*",
//         "Content-Type" => "application/json"
//     ], []);
// }
public function deleteAccount(int $id): Response
{
    // récupération de l'id
    $account = $this->accountRepository->find($id);
    // verifer si le compte existe
    if (!$account) {
        return $this->json(["error" => "l'id n'existe pas"], $code =404);
    }

    // Suppression du compte
    $this->em->remove($account);
    $this->em->flush();

    return $this->json($account, $code = 200, [
        "Access-Control-Allow-Origin" => "*",
        "Content-Type" => "application/json"
    ], []);
}

}