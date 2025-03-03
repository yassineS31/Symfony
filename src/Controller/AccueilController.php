<?php


namespace App\Controller;

use Doctrine\DBAL\Types\Type;
use Symfony\Component\HttpFoundation\Response;
use function PHPUnit\Framework\any;

class AccueilController {
    public function addition(int $n1,int $n2){
        $somme = $n1+$n2;
        if($somme>=0){
        return new Response('<p>L’addition de '.$n1 .'et'. $n2 .'est égale au résultat :'.$somme.'</p>');
        }else{
            return new Response('<p>Les nombres sont négatifs</p>');
        }
    }

    public function calculatrice(  $n1, $n2, string $chaine){
        
        if((is_numeric($n1) ) && (is_numeric( $n2) )){
            
            switch ($chaine) {
                case 'add': 
                    $result = $n1 + $n2;
                
                    break;
                case 'sous':
                    $result = $n1 - $n2;
                
                    break;
                case 'multi':
                    $result = $n1*$n2;
                    break;
                case 'div':if( $n2 == 0 ){
                    return new Response(  'Division imposible par 0 !');
                }
                    $result = $n1/$n2;
                    break;
                default:
                    $result="Erreur, opération incorrect";
                    break;
            } 
            return new Response('Resultat de l\'opération : '.$result);
        
    } else {
        return new Response('Un ou plusieurs des nombre sont pas de type INT');
    }}
}