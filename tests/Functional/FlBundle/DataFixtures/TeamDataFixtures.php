<?php

declare(strict_types=1);

namespace Tests\Functional\FlBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use FlBundle\Entity\Team;

class TeamDataFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $league = $manager->getRepository('FlBundle:League')
            ->findOneBy([]);

        $team= new Team();
        $team
            ->setLeague($league)
            ->setCreatedBy($league->getCreatedBy())
            ->setName('test team 1')
            ->setStrip('test strip');

        $manager->persist($team);

        $team = new Team();
        $team
            ->setLeague($league)
            ->setCreatedBy($league->getCreatedBy())
            ->setName('test team 2')
            ->setStrip('test strip');

        $manager->persist($team);

        $manager->flush();
    }
}
