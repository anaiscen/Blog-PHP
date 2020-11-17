<?php

namespace App\src\model;

use App\config\Request;
use Twig\Environment;

class View
{
    private $request;
    protected $twig;

    public function __construct(Environment $twig)
    {
        $this->request = new Request();
        $this->session = $this->request->getSession();
        $this->twig = $twig;
    }

    public function render($template, $data = [])
    {
        print_r( $this->twig->render($template, $data) );
    }
}