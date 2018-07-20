<?php

declare(strict_types=1);

namespace Tests\Functional\FlBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use FlBundle\Entity\League;

class LeagueDataFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = $manager->getRepository('FlBundle:User')
            ->findOneBy([
                'username' => 'test',
            ]);

        $league = new League();
        $league
            ->setCreatedBy($user)
            ->setName('Test League');

        $manager->persist($league);
        $manager->flush();
    }
}
