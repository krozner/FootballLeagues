<?php

declare(strict_types=1);

namespace FlBundle\Controller;

use FlBundle\Entity\League;
use FlBundle\Entity\Team;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class TeamController extends BaseApiController
{
    /**
     * Get a list of football teams in a single league
     *
     * @ParamConverter("league", class="FlBundle:League", isOptional=true)
     * @Route("/api/team/{league}", methods={"GET"})
     */
    public function teamsAction(League $league = null)
    {
        if (null === $league) {
            throw $this->createNotFoundException('League not found');
        }
        $teams = $this->getDoctrine()
            ->getRepository('FlBundle:Team')
            ->findByLeague($league);

        return $this->createCollectionResponse($teams);
    }

    /**
     * Create a football team
     *
     * @Route("/api/team", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $this->get('team_manager')
            ->hydrate($request->request->all(), $team = new Team())
            ->save($team, $this->getUser());

        return $this->createResponse($team);
    }

    /**
     * Modify all attributes of a football team
     *
     * @ParamConverter("team", class="FlBundle:Team", isOptional=true)
     * @Route("/api/team/{team}", methods={"PUT"})
     */
    public function updateAction(Team $team = null, Request $request)
    {
        if (null === $team) {
            throw $this->createNotFoundException('Team not found');
        }

        $this->get('team_manager')
            ->hydrate($request->request->all(), $team)
            ->update($team, $this->getUser());

        return $this->createResponse($team);
    }
}
