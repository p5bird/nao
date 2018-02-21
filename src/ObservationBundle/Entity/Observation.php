<?php

namespace ObservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ObservationBundle\Validator\BirdNameExists;
use ObservationBundle\Validator\LatitudeOk;
use ObservationBundle\Validator\LongitudeOk;
use ObservationBundle\Validator\DateNoFuture;
use ObservationBundle\Entity\Taxon;
use ObservationBundle\Entity\Image;
use ObservationBundle\Entity\Validation;
use UserBundle\Entity\User;

/**
 * Observation
 *
 * @ORM\Table(name="nao_obs_observation")
 * @ORM\Entity(repositoryClass="ObservationBundle\Repository\ObservationRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 * @BirdNameExists()
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
     * @ORM\ManyToOne(targetEntity="ObservationBundle\Entity\Taxon")
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
     * @Assert\NotBlank()
     * @Assert\Date()
     * @DateNoFuture()
     */
    private $day;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string")
     * @Assert\NotBlank()
     * @LatitudeOk()
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string")
     * @Assert\NotBlank()
     * @LongitudeOk()
     */
    private $longitude;

    /**
     * @var string
     *
     */
    private $place;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sendingDate", type="datetime")
     */
    private $sendingDate;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     * @Assert\NotBlank()
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @var bool
     *
     * @ORM\Column(name="publish", type="boolean")
     */
    private $publish;

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
     * @ORM\OneToOne(targetEntity="ObservationBundle\Entity\Image", inversedBy="observation", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     * @Assert\Valid()
     */
    private $image;

    /**
     * @var string
     */
    private $birdName;

    /**
     * @ORM\OneToOne(targetEntity="ObservationBundle\Entity\Validation", cascade={"persist"})
     */
    private $validation;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="locAddress", type="string", nullable=true)
     */
    private $locAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="locLocality", type="string", nullable=true)
     */
    private $locLocality;

    /**
     * @var string
     *
     * @ORM\Column(name="locCounty", type="string", nullable=true)
     */
    private $locCounty;

    /**
     * @var string
     *
     * @ORM\Column(name="locRegion", type="string", nullable=true)
     */
    private $locRegion;

    /**
     * @var string
     *
     * @ORM\Column(name="locCountry", type="string", nullable=true)
     */
    private $locCountry;

    /**
     * @var string
     *
     * @ORM\Column(name="locPostalCode", type="string", nullable=true)
     */
    private $locPostalCode;


    /**
     * ---------------------------------------
     * Constructor
     */
    public function __construct()
    {
        $this->sendingDate = new \DateTime();
        $this->publish = false;
        $this->likes = 0;
        $this->reports = 0;
        $this->day = new \DateTime('now');
    }


    /**
     * ---------------------------------------
     * EVENTS methods
     * ---------------------------------------
     */

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function checkNoName()
    {
        if (empty($this->birdName))
        {
            $this->taxon = null;
        }

        if (!is_null($this->taxon))
        {
            $this->noName = false;
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function changeUpdatedAt()
    {
        $this->setUpdatedAt(new \DateTime('now'));
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function checkEntities()
    {
        //
    }

    /**
     * @ORM\PostLoad()
     */
    public function initBirdName()
    {
        if (!is_null($this->taxon))
        {
            $this->birdName = $this->taxon->getNameVern();
        }
    }


    /**
     * ---------------------------------------
     * Other methods
     * ---------------------------------------
     */

    /**
     * create url to display INPN bird card 
     * @return string url to INPN
     */
    public function getUrlInpn()
    {
        return $this->getTaxon()->getUrlInpn();
    }

    /**
     * create url to display wikipedia bird card 
     * @return string url to wikipedia
     */
    public function getUrlWiki()
    {
        return $this->getTaxon()->getUrlWiki();
    }

    /**
     * Has noName
     *
     * @return bool
     */
    public function hasNoName()
    {
        return $this->noName;
    }

    /**
     * Check if validation exists
     *
     * @return bool
     */
    public function hasValidation()
    {
        if (is_null($this->validation))
        {
            return false;
        }
        return true;
    }

    /**
     * Check if validation exists
     *
     * @return bool
     */
    public function isValidated()
    {
        if (!is_null($this->validation) and $this->validation->getGranted())
        {
            return true;
        }
        return false;
    }

    public function hasImage()
    {
        if (is_null($this->getImage()))
        {
            return false;
        }
        return true;
    }

    /**
     * 
     */
    public function removeValidation()
    {
        $this->setValidation(null);
    }

    /**
     * 
     */
    public function getLatAndLng()
    {
        return $this->getLatitude() . ',' . $this->getLongitude();
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
     * Set noName
     *
     * @param boolean $noName
     *
     * @return Observation
     */
    public function setNoName($noName)
    {
        $this->noName = $noName;

        return $this;
    }

    /**
     * Get noName
     *
     * @return bool
     */
    public function getNoName()
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
     * Set publish
     *
     * @param boolean $publish
     *
     * @return Observation
     */
    public function setPublish($publish)
    {
        $this->publish = $publish;

        return $this;
    }

    /**
     * Get publish
     *
     * @return bool
     */
    public function getPublish()
    {
        return $this->publish;
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
        if (is_null($this->taxon))
        {
            return new Taxon();
        }
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
        if (is_null($this->taxon) or $this->birdName != $this->taxon->getNameVern())
        {
            return $this->birdName;
        }
        return $this->taxon->getNameVern();
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Observation
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Observation
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set validation
     *
     * @param \ObservationBundle\Entity\Validation $validation
     *
     * @return Observation
     */
    public function setValidation(\ObservationBundle\Entity\Validation $validation = null)
    {
        $this->validation = $validation;

        return $this;
    }

    /**
     * Get validation
     *
     * @return \ObservationBundle\Entity\Validation
     */
    public function getValidation()
    {
        return $this->validation;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Observation
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set image
     *
     * @param \ObservationBundle\Entity\Image $image
     *
     * @return Observation
     */
    public function setImage(\ObservationBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \ObservationBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set locAddress
     *
     * @param string $locAddress
     *
     * @return Observation
     */
    public function setLocAddress($locAddress)
    {
        $this->locAddress = $locAddress;

        return $this;
    }

    /**
     * Get locAddress
     *
     * @return string
     */
    public function getLocAddress()
    {
        return $this->locAddress;
    }

    /**
     * Set locLocality
     *
     * @param string $locLocality
     *
     * @return Observation
     */
    public function setLocLocality($locLocality)
    {
        $this->locLocality = $locLocality;

        return $this;
    }

    /**
     * Get locLocality
     *
     * @return string
     */
    public function getLocLocality()
    {
        return $this->locLocality;
    }

    /**
     * Set locCounty
     *
     * @param string $locCounty
     *
     * @return Observation
     */
    public function setLocCounty($locCounty)
    {
        $this->locCounty = $locCounty;

        return $this;
    }

    /**
     * Get locCounty
     *
     * @return string
     */
    public function getLocCounty()
    {
        return $this->locCounty;
    }

    /**
     * Set locRegion
     *
     * @param string $locRegion
     *
     * @return Observation
     */
    public function setLocRegion($locRegion)
    {
        $this->locRegion = $locRegion;

        return $this;
    }

    /**
     * Get locRegion
     *
     * @return string
     */
    public function getLocRegion()
    {
        return $this->locRegion;
    }

    /**
     * Set locCountry
     *
     * @param string $locCountry
     *
     * @return Observation
     */
    public function setLocCountry($locCountry)
    {
        $this->locCountry = $locCountry;

        return $this;
    }

    /**
     * Get locCountry
     *
     * @return string
     */
    public function getLocCountry()
    {
        return $this->locCountry;
    }

    /**
     * Set locPostalCode
     *
     * @param string $locPostalCode
     *
     * @return Observation
     */
    public function setLocPostalCode($locPostalCode)
    {
        $this->locPostalCode = $locPostalCode;

        return $this;
    }

    /**
     * Get locPostalCode
     *
     * @return string
     */
    public function getLocPostalCode()
    {
        return $this->locPostalCode;
    }
}
