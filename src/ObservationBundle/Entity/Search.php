<?php

namespace ObservationBundle\Entity;

/**
 * Search
 *
 */
class Search
{

    /**
     * @var string
     *
     */
    private $birdName;

    /**
     * @var string
     *
     */
    private $birdFamily;

    /**
     * @var string
     *
     */
    private $birdOrder;

    /**
     * @var string
     *
     */
    private $obsAuthor;

    /**
     * @var Datetime
     *
     */
    private $obsDate;

    /**
     * @var bool
     *
     */
    private $obsWithImage = false;

    /**
     * @var string
     *
     */
    private $obsLocation;

    /**
     * 
     */
    private $birdSize;


    /**
     * 
     */
    public function hasTaxonFilter()
    {
        if (empty($this->birdName) and empty($this->birdFamily) and empty($this->birdOrder))
        {
            return false;
        }
        return true;
    }


    /**
     * 
     */
    public function hasObsFilter()
    {
        if (empty($this->obsAuthor) and empty($this->obsDate) and empty($this->obsLocation) and !$this->obsWithImage)
        {
            return false;
        }
        return true;
    }


    /**
     * 
     */
    public function hasActiveFilter()
    {
        if ($this->hasTaxonFilter() or $this->hasObsFilter())
        {
            return true;
        }
        return false;
    }

    /**
     * Set birdName
     *
     * @param string $birdName
     *
     * @return Search
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

    /**
     * Set birdFamily
     *
     * @param string $birdFamily
     *
     * @return Search
     */
    public function setBirdFamily($birdFamily)
    {
        if ($birdFamily == 'notValid')
        {
            $birdFamily = null;
        }

        $this->birdFamily = $birdFamily;

        return $this;
    }

    /**
     * Get birdFamily
     *
     * @return string
     */
    public function getBirdFamily()
    {
        return $this->birdFamily;
    }

    /**
     * Set birdOrder
     *
     * @param string $birdOrder
     *
     * @return Search
     */
    public function setBirdOrder($birdOrder)
    {
        if ($birdOrder == 'notValid')
        {
            $birdOrder = null;
        }

        $this->birdOrder = $birdOrder;

        return $this;
    }

    /**
     * Get birdOrder
     *
     * @return string
     */
    public function getBirdOrder()
    {
        return $this->birdOrder;
    }

    /**
     * Set obsAuthor
     *
     * @param string $obsAuthor
     *
     * @return Search
     */
    public function setObsAuthor($obsAuthor)
    {
        $this->obsAuthor = $obsAuthor;

        return $this;
    }

    /**
     * Get obsAuthor
     *
     * @return string
     */
    public function getObsAuthor()
    {
        return $this->obsAuthor;
    }

    /**
     * Set obsDate
     *
     * @param Datetime $obsDate
     *
     * @return Search
     */
    public function setObsDate($obsDate)
    {
        $this->obsDate = $obsDate;

        return $this;
    }

    /**
     * Get obsDate
     *
     * @return Datetime
     */
    public function getObsDate()
    {
        return $this->obsDate;
    }

    /**
     * Set obsWithImage
     *
     * @param boolean $obsWithImage
     *
     * @return Search
     */
    public function setObsWithImage($obsWithImage)
    {
        $this->obsWithImage = $obsWithImage;

        return $this;
    }

    /**
     * Get obsWithImage
     *
     * @return bool
     */
    public function getObsWithImage()
    {
        return $this->obsWithImage;
    }

    /**
     * Set obsLocation
     *
     * @param string $obsLocation
     *
     * @return Search
     */
    public function setObsLocation($obsLocation)
    {
        $this->obsLocation = $obsLocation;

        return $this;
    }

    /**
     * Get obsLocation
     *
     * @return string
     */
    public function getObsLocation()
    {
        return $this->obsLocation;
    }
}

