<?php

declare(strict_types=1);

namespace FlBundle\Controller;

use FlBundle\Entity\League;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LeagueController extends Controller
{
    /**
     * Remove football league
     *
     * @ParamConverter("league", class="FlBundle:League", isOptional=true)
     * @Route("/api/league/{league}", methods={"DELETE"})
     */
    public function deleteAction(League $league = null)
    {
        if (null === $league) {
            throw $this->createNotFoundException('League not found');
        }

        $this->get('league_manager')
            ->delete($league, $this->getUser());

        return $this->get('api_response')->create([]);
    }
}
