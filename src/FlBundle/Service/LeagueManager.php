<?php

declare(strict_types=1);

namespace FlBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry as DoctrineRegistry;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use FlBundle\Entity\League;
use FlBundle\Entity\User;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class LeagueManager
{
    private $doctrine;

    public function __construct(DoctrineRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function delete(League $league, User $user)
    {
        if ($league->getCreatedBy() !== $user) {
            throw new AccessDeniedHttpException('You cannot remove league created by other user');
        }

        $manager = $this->doctrine->getManager();

        try {
            $manager->remove($league);
            $manager->flush();
        } catch (ForeignKeyConstraintViolationException  $e) {
            throw new \RuntimeException('Cannot remove league it has assigned teams. '
                . 'Try to remove teams from the league first', 500, $e);
        }
    }
}
