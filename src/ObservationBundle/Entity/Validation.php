<?php

namespace ObservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Validation
 *
 * @ORM\Table(name="nao_obs_validation")
 * @ORM\Entity(repositoryClass="ObservationBundle\Repository\ValidationRepository")
 */
class Validation
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @var bool
     *
     * @ORM\Column(name="granted", type="boolean")
     */
    private $granted = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="rejected", type="boolean")
     */
    private $rejected = false;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     */
    private $author;

    /**
     * @var string
     */
    private $birdName;


    /**
     * ---------------------------------------
     * Constructor
     * ---------------------------------------
     */
    public function __construct()
    {
        //
    }


    /**
     * ---------------------------------------
     * EVENTS methods
     * ---------------------------------------
     */


    /**
     * ---------------------------------------
     * Other methods
     * ---------------------------------------
     */


    /**
     * ---------------------------------------
     * Getters / Setters
     * ---------------------------------------
     */

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Validation
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Validation
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
     * Set granted
     *
     * @param boolean $granted
     *
     * @return Validation
     */
    public function setGranted($granted)
    {
        $this->granted = $granted;

        return $this;
    }

    /**
     * Get granted
     *
     * @return bool
     */
    public function getGranted()
    {
        return $this->granted;
    }

    /**
     * Set delete
     *
     * @param boolean $rejected
     *
     * @return Validation
     */
    public function setDelete($rejected)
    {
        $this->delete = $rejected;

        return $this;
    }

    /**
     * Get delete
     *
     * @return bool
     */
    public function getDelete()
    {
        return $this->delete;
    }

    /**
     * Set author
     *
     * @param \UserBundle\Entity\User $author
     *
     * @return Validation
     */
    public function setAuthor(\UserBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \UserBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Get birdName
     *
     * @return string
     */
    public function getBirdName()
    {
        return $this->birdName;
    }

    /**
     * Set birdName
     *
     * @param string $birdName
     *
     * @return Validation
     */
    public function setBirdName($birdName)
    {
        $this->birdName = $birdName;

        return $this;
    }
}