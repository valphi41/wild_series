<?php
// src/Controller/ProgramController.php
namespace App\Controller;



use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Repository\ProgramRepository;
use App\Service\ProgramDuration;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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

    #[Route('/{slug}', name: 'show')]
    public function show(Program $program, ProgramDuration $programDuration): Response
    {
        if (!$program){
            throw $this->createNotFoundException(
                'No program found in programs table.'
            );
        }
        return $this->render('program/show.html.twig',
        ['program' => $program,
            'programDuration' => $programDuration->calculate($program),
        ]);
    }

    #[Route("/{program_slug}/{season_id}", name: 'season_show')]
    #[Entity('program', options: ['mapping'=>['program_slug'=>'slug']])]
    #[Entity('season', options: ['mapping'=>['season_id'=>'id']])]
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
    #[Route('/{program_slug}/{season_id}/{episode_slug}', name: 'episode_show')]
    #[Entity('program', options: ['mapping'=>['program_slug'=>'slug']])]
    #[Entity('season', options: ['mapping'=>['season_id'=>'id']])]
    #[Entity('episode', options: ['mapping'=>['episode_slug'=>'slug']])]
    public function showEpisode(Program $program,Season $season, Episode $episode): Response
    {
        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode]);
    }
}