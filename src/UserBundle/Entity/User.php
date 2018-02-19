<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 2/1/18
 * Time: 12:58 PM
 */

namespace UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use FOS\MessageBundle\Model\ParticipantInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="nao_user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User extends BaseUser implements ParticipantInterface {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le nom doit contenir au moins {{ limit }} lettres.",
     *      maxMessage = "Le nom ne peut pas contenir plus de {{ limit }} lettres."
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le prénom doit contenir au moins {{ limit }} lettres.",
     *      maxMessage = "Le prénom ne peut pas contenir plus de {{ limit }} lettres."
     * )
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", nullable=true)
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "La ville doit contenir au moins {{ limit }} lettres."
     * )
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="level", type="string", nullable=true)
     */
    private $level;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="datetime", nullable=true)
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="job", type="string", nullable=true)
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "La profession doit contenir au moins {{ limit }} lettres."
     * )
     */
    private $job;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", nullable=true)
     */
    private $facebook;

    /**
     * @var string
     *
     * @ORM\Column(name="pinterest", type="string", nullable=true)
     */
    private $pinterest;

    /**
     * @var string
     *
     * @ORM\Column(name="instagram", type="string", nullable=true)
     */
    private $instagram;

    /**
     * @var string
     *
     * @ORM\Column(name="bio", type="text", nullable=true)
     * @Assert\Length(
     *      max = 1000,
     *      maxMessage = "La biographie ne peut pas contenir plus de {{ limit }} lettres."
     * )
     */
    private $bio;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\Avatar", inversedBy="user", cascade={"all"}, orphanRemoval= true)
     * @ORM\JoinColumn(name="avatar_id", referencedColumnName="id")
     * @Assert\Valid
     */
    private $avatar;

    /**
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\Group")
     * @ORM\JoinTable(name="nao_user_groups",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_register", type="date")
     * @Assert\NotBlank()
     * @Assert\DateTime(
     *     format="d-m-Y",
     *     message="Incorrect date format. Expected format : '{{ format }}'."
     * )
     */
    private $dateRegister;

    /**
     * @var boolean
     *
     * @ORM\Column(name="receiveNewsletter", type="boolean")
     */
    private $receiveNewsletter = false;


    public function __construct()
    {
        parent::__construct();

        $this->groups = new ArrayCollection();
        $this->dateRegister = new \DateTime();
    }

    // GETTERS & SETTERS

    /**
     * @return mixed
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * @param mixed $bio
     */
    public function setBio($bio)
    {
        $this->bio = $bio;
    }

    public function setAvatar(Avatar $avatar = null)
    {
        $this->avatar = $avatar;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @param mixed $birthdate
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return mixed
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @param mixed $facebook
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    }

    /**
     * @return mixed
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @param mixed $job
     */
    public function setJob($job)
    {
        $this->job = $job;
    }

    /**
     * @return mixed
     */
    public function getInstagram()
    {
        return $this->instagram;
    }

    /**
     * @param mixed $instagram
     */
    public function setInstagram($instagram)
    {
        $this->instagram = $instagram;
    }

    /**
     * @return mixed
     */
    public function getPinterest()
    {
        return $this->pinterest;
    }

    /**
     * @param mixed $pinterest
     */
    public function setPinterest($pinterest)
    {
        $this->pinterest = $pinterest;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

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
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param mixed $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

    /**
     * @param \DateTime $dateRegister
     *
     * @return User
     */
    public function setDateRegister($dateRegister)
    {
        $this->dateRegister = $dateRegister;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateRegister()
    {
        return $this->dateRegister;
    }

    /**
     * @return bool
     */
    public function isReceiveNewsletter()
    {
        return $this->receiveNewsletter;
    }

    /**
     * @param bool $receiveNewsletter
     */
    public function setReceiveNewsletter($receiveNewsletter)
    {
        $this->receiveNewsletter = $receiveNewsletter;
    }
}
