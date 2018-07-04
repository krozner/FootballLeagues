<?php

namespace Tests\Unit\FlBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use FlBundle\Entity\Team;
use FlBundle\Entity\League;
use FlBundle\Repository\TeamRepository;
use FlBundle\Service\TeamManager;
use Tests\Unit\TestCase;

class TeamManagerTest extends TestCase
{
    /**
     * @var TeamManager
     */
    private $manger;

    public function setUp()
    {
        $doctrine = $this->createDoctrineMock();

        $repository = $this->createRepositoryMock(TeamRepository::class, ['findOneBy']);

        $doctrine
            ->expects($this->once())
            ->method("getRepository")
            ->willReturn($repository);

        $repository
            ->expects($this->once())
            ->method("findOneBy")
            ->willReturn(new League());

        $this->manger = new TeamManager($doctrine);
    }

    /**
     * @test
     */
    public function is_team_hydrator_works()
    {
        $data = [
            'name' => "hydrator test name",
            'strip' => "hydrator test strip",
            'league' => 1
        ];

        $this->manger->hydrate($data, $team = new Team());

        $this->assertTrue($team->getName() === $data['name']);
        $this->assertTrue($team->getLeague() !== null);
        $this->assertTrue($team->getStrip() === $data['strip']);
    }
}