<?php

namespace App\src\controller;

use App\config\Parameter;

class AdminController extends Controller
{
    private function checkLoggedIn()
    {
        if(!$this->session->get('pseudo')) {
            $this->session->set('need_login', 'Vous devez vous connecter pour accéder à cette page');
            $this->redirect('Location: ../public/index.php?route=login');
        } else {
            return true;
        }
    }

    private function checkAdmin()
    {
        $this->checkLoggedIn();
        if(!($this->session->get('role') === 'admin')) {
            $this->session->set('not_admin', 'Vous n\'avez pas le droit d\'accéder à cette page');
            $this->redirect('Location: ../public/index.php?route=profile');
        } else {
            return true;
        }
    }

    public function administration()
    {
        if($this->checkAdmin()) {
            $articles = $this->articleDAO->getArticles();
            $comments = $this->commentDAO->getCommentsToValidate();
            $users = $this->userDAO->getUsers();

            return $this->view->render('administration.html.twig', [
                'articles' => $articles,
                'comments' => $comments,
                'users' => $users
            ]);   
        }
    }

    public function editArticle(Parameter $post, $articleId)
    {
        if($this->checkAdmin()) {
            $article = $this->articleDAO->getArticle($articleId);
            if ($post->get('submit')) {
                $errors = $this->validation->validate($post, 'Article');
                if (!$errors) {
                    $this->articleDAO->editArticle($post, $articleId, $this->session->get('id'));
                    $this->session->set('edit_article', 'L\' article a bien été modifié');
                    $this->redirect('Location: ../public/index.php?route=blog');
                }
                return $this->view->render('edit_article.html.twig', [
                    'post' => $post,
                    'errors' => $errors
                ]);

            }
            $post->set('id', $article->getId());
            $post->set('title', $article->getTitle());
            $post->set('content', $article->getContent());
            $post->set('author', $article->getAuthor());

            return $this->view->render('edit_article.html.twig', [
                'post' => $post
            ]);
        }
    }

    public function deleteArticle($articleId)
    {
        if($this->checkAdmin()) {
            $this->articleDAO->deleteArticle($articleId);
            $this->session->set('delete_article', 'L\' article a bien été supprimé');
            $this->redirect('Location: ../public/index.php?route=blog');
        }
    }

    public function validateComment($commentId)
    {
        if($this->checkAdmin()) {
            $this->commentDAO->validateComment($commentId);
            $this->session->set('unflag_comment', 'Le commentaire a bien été validé');
            $this->redirect('Location: ../public/index.php?route=administration');
        }
    }

    public function deleteComment($commentId)
    {
        if($this->checkAdmin()) {
            $this->commentDAO->deleteComment($commentId);
            $this->session->set('delete_comment', 'Le commentaire a bien été supprimé');
            $this->redirect('Location: ../public/index.php?route=administration');
        }
    }

    public function deleteUser($userId)
    {
        if($this->checkAdmin()) {
            $this->userDAO->deleteUser($userId);
            $this->session->set('delete_user', 'L\'utilisateur a bien été supprimé');
            $this->redirect('Location: ../public/index.php?route=administration');
        }
    }

    public function validateUser($userId)
    {
        if($this->checkAdmin()) {
            $this->userDAO->validateUser($userId);
            $this->redirect('Location: ../public/index.php?route=administration');
        }
    }
}