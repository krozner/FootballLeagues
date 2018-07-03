<?php

namespace FlBundle\Repository;

use Doctrine\ORM\EntityRepository;
use FlBundle\Entity\League;
use FlBundle\Model\TeamCollection;

class TeamRepository extends EntityRepository
{
    /**
     * @param League $league
     * @return TeamCollection
     */
    public function findByLeague(League $league): TeamCollection
    {
        $results = $this->findBy([
            'league' => $league
        ]);

        return new TeamCollection($results);
    }
}