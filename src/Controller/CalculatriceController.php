<?php 

namespace App\Controller;

use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


final class CalculatriceController extends AbstractController{

    public function calculatrice(  $nombre1, $nombre2, string $chaine){
        $resultat =0 ;

        if((is_numeric($nombre1) ) && (is_numeric( $nombre2) )){
            
            switch ($chaine) {
                case 'add': 
                    $resultat = $nombre1 + $nombre2;
                
                    break;
                case 'sous':
                    $resultat = $nombre1 - $nombre2;
                
                    break;
                case 'multi':
                    $resultat = $nombre1*$nombre2;
                    break;
                case 'div':if( $nombre2 == 0 ){
                    return $this->render('/calculatrice.html.twig',[ 
                        'nombre1' => $nombre1,
                        'nombre2' => $nombre2,
                        'chaine' => $chaine,
                        'resulat' => $resultat
                        ]);
                }
                    $resultat = $nombre1/$nombre2;
                    break;
                default:
                    $resultat="Erreur, opération incorrect";
                    break;
            } 
            return $this->render('/calculatrice.html.twig',[ 
                'nombre1' => $nombre1,
                'nombre2' => $nombre2,
                'chaine' => $chaine,
                'resultat' => $resultat
                ]);        
    } else {
        return $this->render('/calculatrice.html.twig',[ 
            'nombre1' => $nombre1,
            'nombre2' => $nombre2,
            'chaine' => $chaine,
            'resultat' => $resultat
            ]);    }}
}



