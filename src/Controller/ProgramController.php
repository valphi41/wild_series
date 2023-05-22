<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProgramController extends AbstractController
{
    #[Route('/program/', name: 'program_index')]
    public function index(): Response
    {
        return $this->render('program/index.html.twig', [
            'website' => 'Wild Series',
         ]);
    }

    #[Route('/program/{id}', methods: ['GET'], requirements: ['id' => '\d+'], name: 'app_program_show')]
    public function show(int $id): Response
    {
        return $this->render('program/show.html.twig',
        ['controller_name' => 'ProgramController',
        'program_id' => $id]);
    }
}