<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    CONST PROGRAMS = [
        [
            'title' => 'Walking Dead',
            'synopsis' => 'Des zombies envahissent la terre',
            'category' => 'category_Horreur'
        ],
        [
            'title' => 'Naruto',
            'synopsis' => 'Un jeune ninja en quête de reconnaissance',
            'category' => 'category_Animation'
        ],
        [
            'title' => 'Breaking Bad',
            'synopsis' => 'Un professeur devient dealer',
            'category' => 'category_Action'
        ],
        [
            'title' => 'Rings Of Power',
            'synopsis' => 'Une elfe veut venger son peuple',
            'category' => 'category_Fantastique'
        ],
        [
            'title' => 'The Last Of Us',
            'synopsis' => 'Un voyage dans un monde apocalyptique',
            'category' => 'category_Aventure'
        ]
    ];
    public function load(ObjectManager $manager)

    {
        foreach (self::PROGRAMS as $key => $programData) {
            $program = new Program();
            $program->setTitle($programData['title']);
            $program->setSynopsis($programData['synopsis']);
            $program->setCategory($this->getReference($programData['category']));
            $manager->persist($program);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }


}