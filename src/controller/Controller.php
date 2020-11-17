<?php

namespace App\src\controller;

use App\config\Request;
use App\src\constraint\Validation;
use App\src\DAO\ArticleDAO;
use App\src\DAO\CommentDAO;
use App\src\DAO\UserDAO;
use App\src\model\View;

abstract class Controller
{
    protected $articleDAO;
    protected $commentDAO;
    protected $userDAO;
    protected $view;
    private $request;
    protected $get;
    protected $post;
    protected $session;
    protected $validation;

    public function __construct($twig)
    {
        $this->articleDAO = new ArticleDAO();
        $this->commentDAO = new CommentDAO();
        $this->userDAO = new UserDAO();
        $this->view = new View($twig);
        $this->validation = new Validation();
        $this->request = new Request();
        $this->get = $this->request->getGet();
        $this->post = $this->request->getPost();
        $this->session = $this->request->getSession();
    }

    public function redirect($url)
    {
        header($url);
    }
}