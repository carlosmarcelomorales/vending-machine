<?php

namespace App\Money\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MoneyController extends AbstractController
{
    public function insertMoney(Request $request): Response
    {
        return new Response('Hola');
    }


}