<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Repository\SeasonRepository;
use App\Repository\ProgramRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProgramController extends AbstractController
{
    #[Route('/program/', name: 'program_index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findall();
        return $this->render('program/index.html.twig', [
            'programs' => $programs,
         ]);
    }

    #[Route('program/show/{id<^[0-9]+$>}', name: 'program_show')]
    public function show(int $id,ProgramRepository $programRepository): Response
    {
        $program = $programRepository->findOneBy(['id'=>$id]);

        if (!$program){
            throw $this->createNotFoundException(
                'No program with id :' . $id . 'found in programs table.'
            );
        }
        return $this->render('program/show.html.twig',
        ['program' => $program,
        ]);
    }

    #[Route("/program/{programId}/season/{seasonId}", name: 'program_season_show')]
    public function showSeason(int $programId, int $seasonId, ProgramRepository $programRepository, SeasonRepository $seasonRepository): Response
    {
        $program = $programRepository->findOneBy(['id'=>$programId]);
        $season = $seasonRepository->find($seasonId);

        if (!$program || !$season) {
            throw $this->createNotFoundException('Program or Season not found');
        }

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season
        ]);
    }
}