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
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User", mappedBy="avatar")
     */
    private $user;

    /**
     * @ORM\Column(name="base64String", type="text")
     */
    private $base64String;

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
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Avatar
     */
    public function setUser(User $user = null)
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

    /**
     * Set base64String
     *
     * @param string $base64String
     *
     * @return Avatar
     */
    public function setBase64String($base64String)
    {
        $this->base64String = $base64String;

        return $this;
    }

    /**
     * Get base64String
     *
     * @return string
     */
    public function getBase64String()
    {
        return $this->base64String;
    }
}
