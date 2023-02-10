<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ErrorController extends AbstractController
{
    public function showErrorPage(string $message, int $statusCode): Response
    {
        return $this->renderErrorPage(['error'   => $message], $statusCode);
    }

    private function renderErrorPage(array  $data, int  $status): Response
    {
        $response  =  new  Response();
        $response->setStatusCode($status);

        return  $this->render('pages/error.html.twig', $data, $response);
    }
}
