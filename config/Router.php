<?php

namespace App\config;
use App\src\controller\BackController;
use App\src\controller\ErrorController;
use App\src\controller\FrontController;
use App\src\controller\AdminController;
use Exception;

class Router
{
    private $frontController;
    private $backController;
    private $errorController;
    private $adminController;
    private $request;

    public function __construct($twig)
    {
        $this->request = new Request();
        $this->frontController = new FrontController($twig);
        $this->backController = new BackController($twig);
        $this->errorController = new ErrorController($twig);
        $this->adminController = new AdminController($twig);
    }

    public function run()
    {
        $route = $this->request->getGet()->get('route');
        try{
            if(isset($route))
            {
                $this->runBackController($route);
                $this->runFrontController($route);
                $this->runAdminController($route);
            }
            else{
                $this->frontController->home();
            }
        }
        catch (Exception $e)
        {
            $this->errorController->errorServer();
        }
    }

    private function runFrontController($route)
    {
        if($route === 'article'){
            $this->frontController->article($this->request->getGet()->get('articleId'));
        }
        elseif($route === 'addComment'){
            $this->frontController->addComment($this->request->getPost(), $this->request->getGet()->get('articleId'));
        }
        elseif($route === 'register'){
            $this->frontController->register($this->request->getPost());
        }
        elseif($route === 'login'){
            $this->frontController->login($this->request->getPost());
        }
        elseif($route === 'blog'){
            $this->frontController->blog();
        }
        elseif($route === 'contact'){
            $this->frontController->contact();
        }
    }

    private function runAdminController($route)
    {
        if($route === 'editArticle'){
            $this->adminController->editArticle($this->request->getPost(), $this->request->getGet()->get('articleId'));
        }
        elseif($route === 'deleteArticle'){
            $this->adminController->deleteArticle($this->request->getGet()->get('articleId'));
        }
        elseif($route === 'validateComment'){
            $this->adminController->validateComment($this->request->getGet()->get('commentId'));
        }
        elseif($route === 'deleteComment'){
            $this->adminController->deleteComment($this->request->getGet()->get('commentId'));
        }
        elseif($route === 'deleteUser'){
            $this->adminController->deleteUser($this->request->getGet()->get('userId'));
        }
        elseif($route === 'validateUser'){
            $this->adminController->validateUser($this->request->getGet()->get('userId'));
        }
        elseif($route === 'administration'){
            $this->adminController->administration();
        }
    }


    private function runBackController($route)
    {
        if($route === 'addArticle'){
            $this->backController->addArticle($this->request->getPost());
        }
        elseif($route === 'profile'){
            $this->backController->profile();
        }
        elseif($route === 'updatePassword'){
            $this->backController->updatePassword($this->request->getPost());
        }
        elseif($route === 'logout'){
            $this->backController->logout();
        }
        elseif($route === 'deleteAccount'){
            $this->backController->deleteAccount();
        }
    }
}