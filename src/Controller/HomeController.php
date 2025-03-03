<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController{
    public function hello() {
        return new Response('Hello World !') ;
    }
    #[Route(path:'/helloworld',name:'app_home_helloworld')]
    public function helloworld() {
        return new Response('Hello World 2 !') ;
    }
    // #[Route(path:'/hello/{name}',name:'app_home_helloworld')]
    public function helloTo($name) {
        return new Response('Bonjour '. $name) ;
    }

}