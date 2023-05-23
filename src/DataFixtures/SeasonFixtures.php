<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $season = new Season();
        $season->setNumber(1);
        $season->setProgram($this->getReference('program_WalkingDead'));
        $season->setYear(2011);
        $season->setDescription('Les débuts de l\'aventure de Rick Grimes');
        $this->addReference('season1_WalkingDead', $season);
        $manager->persist($season);
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            ProgramFixtures::class,
        ];
    }
}
