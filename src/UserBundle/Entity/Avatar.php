<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 2/2/18
 * Time: 5:29 PM
 */

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;



/**
 * @ORM\Table(name="nao_avatar")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */

class Avatar {
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="extension", type="string", length=255)
     */
    private $extension;

    /**
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @Assert\File(
     *     maxSize="3M",
     *     mimeTypes={ "image/png", "image/jpg", "image/jpeg", },
     *     mimeTypesMessage="Les formats d'image autorisés sont .jpg, .jpeg, .png"
     *     )
     */
    private $file;

    private $tempFilename;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User", mappedBy="avatar")
     */
    private $user;


    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
        // If there's not file, do nothing
        if (null === $this->file) {
            return;
        }

        // Set alt to file name
        $this->alt = $this->file->getClientOriginalName();

        // Set file extension
        $this->extension = $this->file->guessClientExtension();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload() {
        // If there's no file, do nothing
        if (null === $this->file) {
            return;
        }

        // If tempFilename is null
        if (null != $this->tempFilename) {

            $extension = explode('.', $this->alt);

            $oldFile = $this->getUploadRootDir().'/'.$this->id.'.' . $extension;

            // Remove previous file
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }

        }
        // Move the file to the chosen directory
        $this->file->move(
            $this->getUploadRootDir(),
            $this->id.'.'.$this->extension
        );
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload() {
        // Temporary save the file name
        $this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->extension;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload() {
        if (file_exists($this->tempFilename)) {
            unlink($this->tempFilename);
        }
    }

    public function getUploadDir() {
        return 'uploads/avatar';
    }

    protected function getUploadRootDir() {
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    public function getWebPath() {
        return $this->getUploadDir().'/'.$this->getId().'.'.$this->getextension();
    }

    // GETTERS & SETTERS

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param mixed $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * @return mixed
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @param mixed $alt
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getTempFilename()
    {
        return $this->tempFilename;
    }

    /**
     * @param mixed $tempFilename
     */
    public function setTempFilename($tempFilename)
    {
        $this->tempFilename = $tempFilename;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Avatar
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
