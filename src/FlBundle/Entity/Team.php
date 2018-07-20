<?php

namespace FlBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Team
 *
 * @ORM\Table(name="team", indexes={@ORM\Index(name="fk_team_created_by", columns={"created_by"}), @ORM\Index(name="fk_team_league_id", columns={"league_id"})})
 * @ORM\Entity(repositoryClass="FlBundle\Repository\TeamRepository")
 */
class Team
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="strip", type="string", length=255, nullable=true)
     */
    private $strip = null;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by", referencedColumnName="user_id")
     * })
     * @Serializer\Exclude()
     */
    private $createdBy;

    /**
     * @var \League
     *
     * @ORM\ManyToOne(targetEntity="League")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="league_id", referencedColumnName="id")
     * })
     */
    private $league;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getStrip()
    {
        return $this->strip;
    }

    /**
     * @param $strip
     * @return $this
     */
    public function setStrip($strip)
    {
        $this->strip = $strip;
        return $this;
    }

    /**
     * @return \User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param User $createdBy
     * @return $this
     */
    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return \League
     */
    public function getLeague()
    {
        return $this->league;
    }

    /**
     * @param League $league
     * @return $this
     */
    public function setLeague(League $league)
    {
        $this->league = $league;
        return $this;
    }
}
