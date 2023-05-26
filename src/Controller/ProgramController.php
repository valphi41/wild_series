<?php
// src/Controller/ProgramController.php
namespace App\Controller;



use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Repository\SeasonRepository;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findall();
        return $this->render('program/index.html.twig', [
            'programs' => $programs,
         ]);
    }
    #[Route('/new', name: 'new')]
    public function new(Request $request, ProgramRepository $programRepository): Response
    {
        $program = new Program();

        // Create the form, linked with $category
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $programRepository->save($program, true);

            return $this->redirectToRoute('program_index');
        }

        // Render the form

        return $this->render('program/new.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/show/{id<^[0-9]+$>}', name: 'show')]
    public function show(Program $program): Response
    {
        if (!$program){
            throw $this->createNotFoundException(
                'No program found in programs table.'
            );
        }
        return $this->render('program/show.html.twig',
        ['program' => $program,
        ]);
    }

    #[Route("/{program}/season/{season}", name: 'season_show')]
    public function showSeason(Program $program, Season $season): Response
    {

        if (!$program || !$season) {
            throw $this->createNotFoundException('Program or Season not found');
        }

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season
        ]);
    }
    #[Route('/{program}/season/{season}/episode/{episode}', name: 'episode_show')]
    public function showEpisode(Program $program,Season $season, Episode $episode): Response
    {
        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode]);
    }
}