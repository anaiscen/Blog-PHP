<?php

namespace App\src\controller;

class ErrorController extends Controller
{
    public function errorNotFound()
    {
        return $this->view->render('error_404.html.twig');
    }

    public function errorServer()
    {
        return $this->view->render('error_500.html.twig');
    }
}