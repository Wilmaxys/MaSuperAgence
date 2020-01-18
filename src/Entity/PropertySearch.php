<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch
{
    /**
     * @var int
     */
    private $maxPrice;
    /**
     * @var int
     * @Assert\Range(min=10,max=400)
     */
    private $minSurface;
    /**
     * @var ArrayCollection
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getMaxPrice()
    {
        return $this->maxPrice;
    }

    /**
     * @param mixed $maxPrice
     */
    public function setMaxPrice($maxPrice): void
    {
        $this->maxPrice = $maxPrice;
    }

    /**
     * @return mixed
     */
    public function getMinSurface()
    {
        return $this->minSurface;
    }

    /**
     * @param mixed $minSurface
     */
    public function setMinSurface($minSurface): void
    {
        $this->minSurface = $minSurface;
    }

    /**
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param ArrayCollection $tags
     */
    public function setTags($tags): void
    {
        $this->tags = $tags;
    }
}
