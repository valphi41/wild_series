<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/comment', name: 'comment_')]
class CommentController extends AbstractController
{
    #[Route('/new', name: 'new')]
    public function new(Request $request, CommentRepository $commentRepository): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $commentRepository->save($comment, true);

            return $this->redirectToRoute('app_index');
        }
        return $this->render('comment/new.html.twig', [
            'form' => $form,
        ]);
    }
}
