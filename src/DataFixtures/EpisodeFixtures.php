<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $episode = new Episode();
        $episode->setTitle('Passé décomposé');
        $episode->setNumber(1);
        $episode->setSeason($this->getReference('season1_WalkingDead'));
        $episode->setSynopsis('Après être sorti du coma, Rick se met à la recherche de sa famille; il réalise rapidement que le monde a été dévasté par les morts-vivants; il rencontre en chemin Morgan et Duane, qui lui enseignent les règles de survie.');
        $manager->persist($episode);

        $episode2 = new Episode();
        $episode2->setTitle('Tripes');
        $episode2->setNumber(1);
        $episode2->setSeason($this->getReference('season1_WalkingDead'));
        $episode2->setSynopsis('Rick parvient à s\'échapper du tank grâce à l\'aide de Glenn, dont il avait entendu la voix à la radio. Rick et Glenn se réunissent avec les compagnons de Glenn, un autre groupe de survivants venus pour se ravitailler au supermarché.');

        $manager->persist($episode2);

        $episode3 = new Episode();
        $episode3->setTitle('Les grenouilles');
        $episode3->setNumber(1);
        $episode3->setSeason($this->getReference('season1_WalkingDead'));
        $episode3->setSynopsis('Rick décide de retourner à Atlanta; il doit y récupérer un sac rempli d\'armes à feu et y sauver la vie d\'un homme; Shane et Lori doivent composer avec le retour inattendu d\'une personne qu\'ils croyaient morte.
');
        $manager->persist($episode3);

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            SeasonFixtures::class,
        ];
    }
}
