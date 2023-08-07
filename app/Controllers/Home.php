<?php

namespace App\Controllers;

// use sarifi library 
use Alphaolomi\Sarufi\Sarufi;
use GuzzleHttp\Client;

class Home extends BaseController
{
    public function index()
    {
        return view('chat');
    }

    //send to sarufi 
    function say($saying) {
        
    }
    // receive from sarufi 
    public function listen(){

    }
}
