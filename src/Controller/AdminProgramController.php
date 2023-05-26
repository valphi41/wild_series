<?php

namespace App\Controller;

use App\Entity\Program;
use App\Form\Program1Type;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/program')]
class AdminProgramController extends AbstractController
{
    #[Route('/', name: 'app_admin_program_index', methods: ['GET'])]
    public function index(ProgramRepository $programRepository): Response
    {
        return $this->render('admin_program/index.html.twig', [
            'programs' => $programRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_program_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProgramRepository $programRepository): Response
    {
        $program = new Program();
        $form = $this->createForm(Program1Type::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $programRepository->save($program, true);

            return $this->redirectToRoute('app_admin_program_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_program/new.html.twig', [
            'program' => $program,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_program_show', methods: ['GET'])]
    public function show(Program $program): Response
    {
        return $this->render('admin_program/show.html.twig', [
            'program' => $program,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_program_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Program $program, ProgramRepository $programRepository): Response
    {
        $form = $this->createForm(Program1Type::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $programRepository->save($program, true);

            return $this->redirectToRoute('app_admin_program_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_program/edit.html.twig', [
            'program' => $program,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_program_delete', methods: ['POST'])]
    public function delete(Request $request, Program $program, ProgramRepository $programRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$program->getId(), $request->request->get('_token'))) {
            $programRepository->remove($program, true);
        }

        return $this->redirectToRoute('app_admin_program_index', [], Response::HTTP_SEE_OTHER);
    }
}
