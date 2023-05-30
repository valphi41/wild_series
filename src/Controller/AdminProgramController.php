<?php

namespace App\Controller;

use App\Entity\Program;
use App\Form\Program1Type;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/program')]
class AdminProgramController extends AbstractController
{
    #[Route('/', name: 'app_admin_program_index', methods: ['GET'])]
    public function index(ProgramRepository $programRepository, RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        if (!$session->has('total')) {
            $session->set('total', 0);
        }
        $total = $session->get('total');

            return $this->render('admin_program/index.html.twig', [
            'programs' => $programRepository->findAll(),
                'total' => $total
        ]);
    }

    #[Route('/new', name: 'app_admin_program_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProgramRepository $programRepository, SluggerInterface $slugger, MailerInterface $mailer): Response
    {
        $program = new Program();
        $form = $this->createForm(Program1Type::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($program->getTitle());
            $program->setSlug($slug);
            $programRepository->save($program, true);

            $this->addFlash('success', 'Un nouveau programme a été crée !');

            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to('your_email@example.com')
                ->subject('Une nouvelle série à été publiée !')
                ->html($this->renderView('admin_program/newProgramEmail.html.twig', ['program' => $program]));

            $mailer->send($email);

            return $this->redirectToRoute('app_admin_program_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_program/new.html.twig', [
            'program' => $program,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_admin_program_show', methods: ['GET'])]
    public function show(Program $program): Response
    {
        return $this->render('admin_program/show.html.twig', [
            'program' => $program,
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_admin_program_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Program $program, ProgramRepository $programRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(Program1Type::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($program->getTitle());
            $program->setSlug($slug);
            $programRepository->save($program, true);

            $this->addFlash('success', 'Votre programme à bien été édité !');

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

            $this->addFlash('danger', 'Votre programme a bien été supprimé ! ');
        }

        return $this->redirectToRoute('app_admin_program_index', [], Response::HTTP_SEE_OTHER);
    }
}
