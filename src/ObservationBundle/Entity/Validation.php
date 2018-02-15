<?php

namespace ObservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Validation
 *
 * @ORM\Table(name="validation")
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
     * @ORM\Column(name="delete", type="boolean")
     */
    private $delete = false;


    /**
     * ---------------------------------------
     * Constructor
     * ---------------------------------------
     */
    public function __construct()
    {
        $this->date = new \DateTime();
    }


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
     * @param boolean $delete
     *
     * @return Validation
     */
    public function setDelete($delete)
    {
        $this->delete = $delete;

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
}
