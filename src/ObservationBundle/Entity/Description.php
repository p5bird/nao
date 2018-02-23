<?php

namespace ObservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description
 *
 * @ORM\Table(name="nao_obs_description")
 * @ORM\Entity(repositoryClass="ObservationBundle\Repository\DescriptionRepository")
 */
class Description
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="environment", type="string", length=255, nullable=true)
     */
    private $environment;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=255, nullable=true)
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(name="wings", type="string", length=255, nullable=true)
     */
    private $wings;

    /**
     * @var string
     *
     * @ORM\Column(name="tail", type="string", length=255, nullable=true)
     */
    private $tail;

    /**
     * @var string
     *
     * @ORM\Column(name="paws", type="string", length=255, nullable=true)
     */
    private $paws;

    /**
     * @var string
     *
     * @ORM\Column(name="beak", type="string", length=255, nullable=true)
     */
    private $beak;

    /**
     * @var string
     *
     * @ORM\Column(name="plumageColor", type="string", length=255, nullable=true)
     */
    private $plumageColor;

    /**
     * @var string
     *
     * @ORM\Column(name="bareColor", type="string", length=255, nullable=true)
     */
    private $bareColor;

    /**
     * @var string
     *
     * @ORM\Column(name="pawsColor", type="string", length=255, nullable=true)
     */
    private $pawsColor;

    /**
     * @var string
     *
     * @ORM\Column(name="beakColor", type="string", length=255, nullable=true)
     */
    private $beakColor;

    /**
     * @var string
     *
     * @ORM\Column(name="escape", type="text", nullable=true)
     */
    private $escape;

    /**
     * @var string
     *
     * @ORM\Column(name="move", type="text", nullable=true)
     */
    private $move;

    /**
     * @var string
     *
     * @ORM\Column(name="land", type="text", nullable=true)
     */
    private $land;

    /**
     * @var string
     *
     * @ORM\Column(name="sounds", type="string", length=255, nullable=true)
     */
    private $sounds;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     * @Assert\NotBlank(message="vous devez entrer une description détaillée")
     */
    private $comment;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer", nullable=true)
     * @Assert\Range(min=1, minMessage="ce chiffre n'est pas valide")
     */
    private $number;

    /**
     * @var bool
     *
     * @ORM\Column(name="nest", type="boolean", nullable=true)
     */
    private $nest;

    /**
     * @var int
     *
     * @ORM\Column(name="eggs", type="integer", nullable=true)
     * @Assert\Range(min=0, minMessage="ce chiffre n'est pas valide")
     */
    private $eggs;

    /**
     * @var string
     *
     * @ORM\Column(name="qstep", type="string", length=255, nullable=true)
     */
    private $qstep;


    public function __construct() {
        $this->number = 1;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set environment
     *
     * @param string $environment
     *
     * @return Description
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;

        return $this;
    }

    /**
     * Get environment
     *
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * Set size
     *
     * @param string $size
     *
     * @return Description
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set wings
     *
     * @param string $wings
     *
     * @return Description
     */
    public function setWings($wings)
    {
        $this->wings = $wings;

        return $this;
    }

    /**
     * Get wings
     *
     * @return string
     */
    public function getWings()
    {
        return $this->wings;
    }

    /**
     * Set tail
     *
     * @param string $tail
     *
     * @return Description
     */
    public function setTail($tail)
    {
        $this->tail = $tail;

        return $this;
    }

    /**
     * Get tail
     *
     * @return string
     */
    public function getTail()
    {
        return $this->tail;
    }

    /**
     * Set paws
     *
     * @param string $paws
     *
     * @return Description
     */
    public function setPaws($paws)
    {
        $this->paws = $paws;

        return $this;
    }

    /**
     * Get paws
     *
     * @return string
     */
    public function getPaws()
    {
        return $this->paws;
    }

    /**
     * Set beak
     *
     * @param string $beak
     *
     * @return Description
     */
    public function setBeak($beak)
    {
        $this->beak = $beak;

        return $this;
    }

    /**
     * Get beak
     *
     * @return string
     */
    public function getBeak()
    {
        return $this->beak;
    }

    /**
     * Set plumageColor
     *
     * @param string $plumageColor
     *
     * @return Description
     */
    public function setPlumageColor($plumageColor)
    {
        $this->plumageColor = $plumageColor;

        return $this;
    }

    /**
     * Get plumageColor
     *
     * @return string
     */
    public function getPlumageColor()
    {
        return $this->plumageColor;
    }

    /**
     * Set bareColor
     *
     * @param string $bareColor
     *
     * @return Description
     */
    public function setBareColor($bareColor)
    {
        $this->bareColor = $bareColor;

        return $this;
    }

    /**
     * Get bareColor
     *
     * @return string
     */
    public function getBareColor()
    {
        return $this->bareColor;
    }

    /**
     * Set pawsColor
     *
     * @param string $pawsColor
     *
     * @return Description
     */
    public function setPawsColor($pawsColor)
    {
        $this->pawsColor = $pawsColor;

        return $this;
    }

    /**
     * Get pawsColor
     *
     * @return string
     */
    public function getPawsColor()
    {
        return $this->pawsColor;
    }

    /**
     * Set beakColor
     *
     * @param string $beakColor
     *
     * @return Description
     */
    public function setBeakColor($beakColor)
    {
        $this->beakColor = $beakColor;

        return $this;
    }

    /**
     * Get beakColor
     *
     * @return string
     */
    public function getBeakColor()
    {
        return $this->beakColor;
    }

    /**
     * Set escape
     *
     * @param string $escape
     *
     * @return Description
     */
    public function setEscape($escape)
    {
        $this->escape = $escape;

        return $this;
    }

    /**
     * Get escape
     *
     * @return string
     */
    public function getEscape()
    {
        return $this->escape;
    }

    /**
     * Set move
     *
     * @param string $move
     *
     * @return Description
     */
    public function setMove($move)
    {
        $this->move = $move;

        return $this;
    }

    /**
     * Get move
     *
     * @return string
     */
    public function getMove()
    {
        return $this->move;
    }

    /**
     * Set land
     *
     * @param string $land
     *
     * @return Description
     */
    public function setLand($land)
    {
        $this->land = $land;

        return $this;
    }

    /**
     * Get land
     *
     * @return string
     */
    public function getLand()
    {
        return $this->land;
    }

    /**
     * Set sounds
     *
     * @param string $sounds
     *
     * @return Description
     */
    public function setSounds($sounds)
    {
        $this->sounds = $sounds;

        return $this;
    }

    /**
     * Get sounds
     *
     * @return string
     */
    public function getSounds()
    {
        return $this->sounds;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Description
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set number
     *
     * @param string $number
     *
     * @return Description
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set nest
     *
     * @param boolean $nest
     *
     * @return Description
     */
    public function setNest($nest)
    {
        $this->nest = $nest;

        return $this;
    }

    /**
     * Get nest
     *
     * @return bool
     */
    public function getNest()
    {
        return $this->nest;
    }

    /**
     * Set eggs
     *
     * @param integer $eggs
     *
     * @return Description
     */
    public function setEggs($eggs)
    {
        $this->eggs = $eggs;

        return $this;
    }

    /**
     * Get eggs
     *
     * @return int
     */
    public function getEggs()
    {
        return $this->eggs;
    }

    /**
     * Set qstep
     *
     * @param string $qstep
     *
     * @return Description
     */
    public function setQstep($qstep)
    {
        $this->qstep = $qstep;

        return $this;
    }

    /**
     * Get qstep
     *
     * @return string
     */
    public function getQstep()
    {
        return $this->qstep;
    }
}
