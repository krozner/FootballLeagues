<?php

declare(strict_types=1);

namespace FlBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry as DoctrineRegistry;
use FlBundle\Entity\Team;
use FlBundle\Entity\User;

class TeamManager
{
    private $doctrine;

    public function __construct(DoctrineRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function hydrate(array $data, Team $team)
    {
        $keys = ['league' => true, 'name' => true, 'strip' => false];

        foreach ($keys as $key => $required) {
            if ($required && ! isset($data[$key])) {
                throw new \InvalidArgumentException("Invalid '{$key}' parameters");
            } elseif (! isset($data[$key])) {
                $data[$key] = null;
            }
        }

        $league = $this->doctrine->getRepository('FlBundle:League')
            ->findOneBy([
                'id' => (int)$data['league'],
            ]);

        if (! $league) {
            throw new \InvalidArgumentException("League not found or invalid 'league' parameters");
        }

        $team
            ->setLeague($league)
            ->setStrip($data['strip'])
            ->setName($data['name']);

        return $this;
    }

    public function save(Team $team, User $user)
    {
        $team->setCreatedBy($user);

        $this->doctrine->getManager()->persist($team);
        $this->doctrine->getManager()->flush();
    }

    public function update(Team $team, User $user = null)
    {
        if ($user) {
            $team->setCreatedBy($user);
        }

        $this->doctrine->getManager()->merge($team);
        $this->doctrine->getManager()->flush();
    }
}
