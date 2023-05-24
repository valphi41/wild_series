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
            'category' => 'category_Horreur',
            'country' => 'USA',
            'reference' => 'program_1'

        ],
        [
            'title' => 'Naruto',
            'synopsis' => 'Un jeune ninja en quête de reconnaissance',
            'category' => 'category_Action'
            ,'country' => 'Japan',
            'reference' => 'program_2'

        ],
        [
            'title' => 'Breaking Bad',
            'synopsis' => 'Un professeur devient dealer',
            'category' => 'category_Action',
            'country' => 'USA',
            'reference' => 'program_3'

        ],
        [
            'title' => 'Rings Of Power',
            'synopsis' => 'Une elfe veut venger son peuple',
            'category' => 'category_Action',
            'country' => 'USA',
            'reference' => 'program_4'
        ],
        [
            'title' => 'The Last Of Us',
            'synopsis' => 'Un voyage dans un monde apocalyptique',
            'category' => 'category_Action',
            'country' => 'USA',
            'reference' => 'program_5'
        ]
    ];
    public function load(ObjectManager $manager)

    {
        foreach (self::PROGRAMS as $key => $programData) {
            $program = new Program();
            $program->setTitle($programData['title']);
            $program->setSynopsis($programData['synopsis']);
            $program->setCategory($this->getReference($programData['category']));
            $program->setCountry($programData['country']);
            $this->addReference($programData['reference'], $program);
            $program->setYear(2007);
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