<?php

namespace ObservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Observation
 *
 * @ORM\Table(name="nao_obs_observation")
 * @ORM\Entity(repositoryClass="ObservationBundle\Repository\ObservationRepository")
 */
class Observation
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
     * @ORM\OneToOne(targetEntity="ObservationBundle\Entity\Taxon")
     */
    private $taxon;

    /**
     * @var bool
     *
     * @ORM\Column(name="noName", type="boolean")
     */
    private $noName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="day", type="date")
     */
    private $day;

    /**
     * @var string
     *
     * @ORM\Column(name="gpsCoord", type="string", length=255, nullable=true)
     */
    private $gpsCoord;

    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=255, nullable=true)
     */
    private $place;

    /**
     * @var string
     *
     * @ORM\Column(name="town", type="string", length=255, nullable=true)
     */
    private $town;

    /**
     * @var string
     *
     * @ORM\Column(name="county", type="string", length=255, nullable=true)
     */
    private $county;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=255, nullable=true)
     */
    private $region;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sendingDate", type="datetime")
     */
    private $sendingDate;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User")
     */
    private $author;

    /**
     * @var bool
     *
     * @ORM\Column(name="validated", type="boolean")
     */
    private $validated;

    /**
     * @var bool
     *
     * @ORM\Column(name="published", type="boolean")
     */
    private $published;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="validationDate", type="datetime", nullable=true)
     */
    private $validationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="validationComment", type="text", nullable=true)
     */
    private $validationComment;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User")
     */
    private $validationAuthor;

    /**
     * @var int
     *
     * @ORM\Column(name="likes", type="integer")
     */
    private $likes;

    /**
     * @var int
     *
     * @ORM\Column(name="reports", type="integer")
     */
    private $reports;

    /**
     * @ORM\OneToMany(targetEntity="ObservationBundle\Entity\Image", mappedBy="observation", cascade={"persist"})
     * 
     */
    private $images;

    /**
     * 
     */
    private $birdName;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sendingDate = new \DateTime();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->validated = false;
        $this->published = false;
        $this->likes = 0;
        $this->reports = 0;
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
     * Set noName
     *
     * @param boolean $noName
     *
     * @return Observation
     */
    public function setnoName($noName)
    {
        $this->noName = $noName;

        return $this;
    }

    /**
     * Get noName
     *
     * @return bool
     */
    public function getnoName()
    {
        return $this->noName;
    }

    /**
     * Set day
     *
     * @param \DateTime $day
     *
     * @return Observation
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return \DateTime
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set gpsCoord
     *
     * @param string $gpsCoord
     *
     * @return Observation
     */
    public function setGpsCoord($gpsCoord)
    {
        $this->gpsCoord = $gpsCoord;

        return $this;
    }

    /**
     * Get gpsCoord
     *
     * @return string
     */
    public function getGpsCoord()
    {
        return $this->gpsCoord;
    }

    /**
     * Set place
     *
     * @param string $place
     *
     * @return Observation
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set town
     *
     * @param string $town
     *
     * @return Observation
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get town
     *
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set county
     *
     * @param string $county
     *
     * @return Observation
     */
    public function setCounty($county)
    {
        $this->county = $county;

        return $this;
    }

    /**
     * Get county
     *
     * @return string
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * Set region
     *
     * @param string $region
     *
     * @return Observation
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set sendingDate
     *
     * @param \DateTime $sendingDate
     *
     * @return Observation
     */
    public function setSendingDate($sendingDate)
    {
        $this->sendingDate = $sendingDate;

        return $this;
    }

    /**
     * Get sendingDate
     *
     * @return \DateTime
     */
    public function getSendingDate()
    {
        return $this->sendingDate;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Observation
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
     * Set validated
     *
     * @param boolean $validated
     *
     * @return Observation
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * Get validated
     *
     * @return bool
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Observation
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return bool
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set validationDate
     *
     * @param \DateTime $validationDate
     *
     * @return Observation
     */
    public function setValidationDate($validationDate)
    {
        $this->validationDate = $validationDate;

        return $this;
    }

    /**
     * Get validationDate
     *
     * @return \DateTime
     */
    public function getValidationDate()
    {
        return $this->validationDate;
    }

    /**
     * Set validationComment
     *
     * @param string $validationComment
     *
     * @return Observation
     */
    public function setValidationComment($validationComment)
    {
        $this->validationComment = $validationComment;

        return $this;
    }

    /**
     * Get validationComment
     *
     * @return string
     */
    public function getValidationComment()
    {
        return $this->validationComment;
    }

    /**
     * Set likes
     *
     * @param integer $likes
     *
     * @return Observation
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * Get likes
     *
     * @return int
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * Set reports
     *
     * @param integer $reports
     *
     * @return Observation
     */
    public function setReports($reports)
    {
        $this->reports = $reports;

        return $this;
    }

    /**
     * Get reports
     *
     * @return int
     */
    public function getReports()
    {
        return $this->reports;
    }

    /**
     * Set taxon
     *
     * @param \ObservationBundle\Entity\Taxon $taxon
     *
     * @return Observation
     */
    public function setTaxon(\ObservationBundle\Entity\Taxon $taxon = null)
    {
        $this->taxon = $taxon;

        return $this;
    }

    /**
     * Get taxon
     *
     * @return \ObservationBundle\Entity\Taxon
     */
    public function getTaxon()
    {
        return $this->taxon;
    }

    /**
     * Set author
     *
     * @param \UserBundle\Entity\User $author
     *
     * @return Observation
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
     * Set validationAuthor
     *
     * @param \UserBundle\Entity\User $validationAuthor
     *
     * @return Observation
     */
    public function setValidationAuthor(\UserBundle\Entity\User $validationAuthor = null)
    {
        $this->validationAuthor = $validationAuthor;

        return $this;
    }

    /**
     * Get validationAuthor
     *
     * @return \UserBundle\Entity\User
     */
    public function getValidationAuthor()
    {
        return $this->validationAuthor;
    }

    /**
     * Add image
     *
     * @param \ObservationBundle\Entity\Image $image
     *
     * @return Observation
     */
    public function addImage(\ObservationBundle\Entity\Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \ObservationBundle\Entity\Image $image
     */
    public function removeImage(\ObservationBundle\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set birdName
     *
     * @param string $birdName
     *
     * @return Observation
     */
    public function setBirdName($birdName)
    {
        $this->birdName = $birdName;

        return $this;
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


}
