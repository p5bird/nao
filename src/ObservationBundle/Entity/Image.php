<?php

namespace ObservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Image
 *
 * @ORM\Table(name="nao_obs_image")
 * @ORM\Entity(repositoryClass="ObservationBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class Image
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
     * @var int
     *
     * @ORM\Column(name="likes", type="integer")
     */
    private $likes = 0;

    /**
     * @ORM\OneToOne(targetEntity="ObservationBundle\Entity\Observation", mappedBy="image")
     * @ORM\JoinColumn(nullable=false)
     */
    private $observation;

    /**
     * @ORM\Column(name="imageName", type="string", length=255, nullable=true)
     * 
     * @var string
     */
    private $imageName;

    /**
     * @Vich\UploadableField(mapping="obs_image", fileNameProperty="imageName")
     * 
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @var \DateTime
     */
    private $updatedAt;


    /**
     * @var boolean
     *
     * @ORM\Column(name="")
     */


    /**
     * ---------------------------------------
     * EVENTS methods
     * ---------------------------------------
     */

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function changeUpdatedAt()
    {
        $this->setUpdatedAt(new \DateTime('now'));
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeImageFile()
    {
        // to be done with file system   
    }


    /**
     * ---------------------------------------
     * Other methods
     * ---------------------------------------
     */

    public function getName()
    {
        
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
     * Set likes
     *
     * @param integer $likes
     *
     * @return Image
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
     * Set observation
     *
     * @param \stdClass $observation
     *
     * @return Image
     */
    public function setObservation($observation)
    {
        $this->observation = $observation;

        return $this;
    }

    /**
     * Get observation
     *
     * @return \stdClass
     */
    public function getObservation()
    {
        return $this->observation;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

    public function getImageName()
    {
        return $this->imageName;
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

}
