<?php

declare(strict_types=1);

namespace Tests\FlBundle\Functional\Controller;

use Tests\Functional\FlBundle\DataFixtures\LeagueDataFixtures;
use Tests\Functional\FlBundle\DataFixtures\TeamDataFixtures;
use Tests\Functional\WebTestCase;

class TeamControllerTest extends WebTestCase
{
    protected function provideFixtures(): array
    {
        return [
            LeagueDataFixtures::class,
            TeamDataFixtures::class,
        ];
    }

    /**
     * @test
     */
    public function should_get_not_found_league()
    {
        $response = $this->apiRequest('GET', '/api/team/9');
        $this->assertTrue($response->getStatusCode() === 404);
    }

    /**
     * @test
     */
    public function should_get_list_of_league_teams()
    {
        $response = $this->apiRequest('GET', '/api/team/1');

        $teams = json_decode($response->getContent(), true);

        $this->assertTrue(is_array($teams), 'Teams list is not an array');
        $this->assertTrue(count($teams) === 2, 'Wrong number of teams returned');
    }

    /**
     * @test
     */
    public function should_create_new_team()
    {
        $response = $this->apiRequest('POST', '/api/team', [
            'name'   => 'new team',
            'league' => 1,
            'strip'  => 'new strip',
        ]);

        $team = json_decode($response->getContent(), true);

        $this->assertTrue(isset($team['name']));

        $response = $this->apiRequest('GET', '/api/team/1');
        $teams    = json_decode($response->getContent(), true);

        $this->assertTrue(count($teams) === 3, 'Wrong number of teams returned');
    }

    /**
     * @test
     */
    public function should_update_team()
    {
        $response = $this->apiRequest('PUT', '/api/team/1', [
            'name'   => 'updated team',
            'league' => 1,
            'strip'  => 'new strip',
        ]);

        $team = json_decode($response->getContent(), true);

        $this->assertTrue(isset($team['name']) && $team['name'] === 'updated name');
    }
}
