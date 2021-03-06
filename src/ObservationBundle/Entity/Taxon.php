<?php

namespace ObservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Taxon
 *
 * @ORM\Table(name="nao_obs_taxon")
 * @ORM\Entity(repositoryClass="ObservationBundle\Repository\TaxonRepository")
 */
class Taxon {
    const URL_INPN = "https://inpn.mnhn.fr/espece/cd_nom/";
    const URL_WIKI = "https://fr.wikipedia.org/wiki/";

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
     * @ORM\Column(name="REGNE", type="string", length=255)
     */
    private $reign;

    /**
     * @var string
     *
     * @ORM\Column(name="PHYLUM", type="string", length=255)
     */
    private $phylum;

    /**
     * @var string
     *
     * @ORM\Column(name="CLASSE", type="string", length=255)
     */
    private $class;

    /**
     * @var string
     *
     * @ORM\Column(name="ORDRE", type="string", length=255)
     */
    private $order;

    /**
     * @var string
     *
     * @ORM\Column(name="FAMILLE", type="string", length=255)
     */
    private $family;

    /**
     * @var int
     *
     * @ORM\Column(name="CD_REF", type="integer")
     */
    private $cdRef;

    /**
     * @var string
     *
     * @ORM\Column(name="LB_NOM", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="LB_AUTEUR", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="NOM_VALIDE", type="string", length=255)
     */
    private $nameValid;

    /**
     * @var string
     *
     * @ORM\Column(name="NOM_VERN", type="string", length=255)
     */
    private $nameVern;

    /**
     * @var string
     *
     * @ORM\Column(name="NOM_VERN_ENG", type="string", length=255)
     */
    private $nameVernEN;

    /**
     * @var string
     *
     * @ORM\Column(name="CD_NOM", type="string", length=255)
     */
    private $cdNom;


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
        return self::URL_INPN . $this->getCdNom();
    }

    /**
     * create url to display wikipedia bird card 
     * @return string url to wikipedia
     */
    public function getUrlWiki()
    {
        return self::URL_WIKI . $this->getName();
    }


    /**
     * ---------------------------------------
     * Getters / Setters
     * ---------------------------------------
     */

    /**
     * Set phylum
     *
     * @param string $phylum
     *
     * @return Taxon
     */
    public function setPhylum($phylum)
    {
        $this->phylum = $phylum;

        return $this;
    }

    /**
     * Get phylum
     *
     * @return string
     */
    public function getPhylum()
    {
        return $this->phylum;
    }

    /**
     * Set family
     *
     * @param string $family
     *
     * @return Taxon
     */
    public function setFamily($family)
    {
        $this->family = $family;

        return $this;
    }

    /**
     * Get family
     *
     * @return string
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Taxon
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Taxon
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set nameValid
     *
     * @param string $nameValid
     *
     * @return Taxon
     */
    public function setNameValid($nameValid)
    {
        $this->nameValid = $nameValid;

        return $this;
    }

    /**
     * Get nameValid
     *
     * @return string
     */
    public function getNameValid()
    {
        return $this->nameValid;
    }

    /**
     * Set reign
     *
     * @param string $reign
     *
     * @return Taxon
     */
    public function setReign($reign)
    {
        $this->reign = $reign;

        return $this;
    }

    /**
     * Get reign
     *
     * @return string
     */
    public function getReign()
    {
        return $this->reign;
    }

    /**
     * Set class
     *
     * @param string $class
     *
     * @return Taxon
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set order
     *
     * @param string $order
     *
     * @return Taxon
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return string
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set nameVern
     *
     * @param string $nameVern
     *
     * @return Taxon
     */
    public function setNameVern($nameVern)
    {
        $this->nameVern = $nameVern;

        return $this;
    }

    /**
     * Get nameVern
     *
     * @return string
     */
    public function getNameVern()
    {
        return $this->nameVern;
    }

    /**
     * Set nameVernEN
     *
     * @param string $nameVernEN
     *
     * @return Taxon
     */
    public function setNameVernEN($nameVernEN)
    {
        $this->nameVernEN = $nameVernEN;

        return $this;
    }

    /**
     * Get nameVernEN
     *
     * @return string
     */
    public function getNameVernEN()
    {
        return $this->nameVernEN;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cdNom
     *
     * @param string $cdNom
     *
     * @return Taxon
     */
    public function setCdNom($cdNom)
    {
        $this->cdNom = $cdNom;

        return $this;
    }

    /**
     * Get cdNom
     *
     * @return string
     */
    public function getCdNom()
    {
        return $this->cdNom;
    }

    /**
     * Set cdRef
     *
     * @param integer $cdRef
     *
     * @return Taxon
     */
    public function setCdRef($cdRef)
    {
        $this->cdRef = $cdRef;

        return $this;
    }

    /**
     * Get cdRef
     *
     * @return integer
     */
    public function getCdRef()
    {
        return $this->cdRef;
    }
}
