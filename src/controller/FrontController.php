<?php

namespace App\src\controller;

use App\config\Parameter;
use Twig\Environment;

class FrontController extends Controller
{
    public function home()
    {
        return $this->view->render('home.html.twig');
    }
    public function contact()
    {
        return $this->view->render('contact.html.twig');
    }
    public function blog()
    {
        $articles = $this->articleDAO->getArticles();
        return $this->view->render('blog.html.twig', [
           'articles' => $articles
        ]);
    }

    public function article($articleId)
    {
        $article = $this->articleDAO->getArticle($articleId);
        $comments = $this->commentDAO->getCommentsFromArticle($articleId);
        return $this->view->render('single.html.twig', [
            'article' => $article,
            'comments' => $comments
        ]);
    }

    public function addComment(Parameter $post, $articleId)
    {
        if($post->get('submit')) {
            $errors = $this->validation->validate($post, 'Comment');
            if(!$errors) {
                $this->commentDAO->addComment($post, $articleId);
                $this->session->set('add_comment', 'Le nouveau commentaire a bien été ajouté');
                $this->redirect("Location: ../public/index.php?route=article&articleId=".$articleId);
            }
            $article = $this->articleDAO->getArticle($articleId);
            $comments = $this->commentDAO->getCommentsFromArticle($articleId);
            return $this->view->render('single', [
                'article' => $article,
                'comments' => $comments,
                'post' => $post,
                'errors' => $errors
            ]);
        }
    }

    public function register(Parameter $post)
    {
        if($post->get('submit')) {
            $errors = $this->validation->validate($post, 'User');
            if($this->userDAO->checkUser($post)) {
                $errors['pseudo'] = $this->userDAO->checkUser($post);
            }
            if(!$errors) {
                $this->userDAO->register($post);
                $this->session->set('register', 'Votre inscription a bien été effectuée');
                $this->session->remove('error_register');
                $this->redirect('Location: ../public/index.php?route=blog');
            }
            else
            {
                $this->session->set('error_register', 'Ce pseudo est déjà utilisé ou le login / mot de passe est absent.');
                $this->redirect('Location: ../public/index.php?route=register');
            }
        }
        return $this->view->render('register.html.twig');
    }

    public function login(Parameter $post)
    {
        if($post->get('submit')) {
            $result = $this->userDAO->login($post);
            if($result && $result['isPasswordValid']) {
                if($result['result']['validated']) 
                {
                    $this->session->set('id', $result['result']['id']);
                    $this->session->set('role', $result['result']['name']);
                    $this->session->set('pseudo', $post->get('pseudo'));
                    $this->session->remove('error_login');
                    $this->redirect('Location: ../public/index.php?route=blog');
                }
                else {
                    $this->session->set('error_login', 'Ce compte est en attente de validation');
                    $this->redirect('Location: ../public/index.php?route=login');
                }
            }
            else {
                $this->session->set('error_login', 'Le pseudo ou le mot de passe sont incorrects');
                $this->redirect('Location: ../public/index.php?route=login');
            }
        }
        return $this->view->render('login.html.twig');
    }
}