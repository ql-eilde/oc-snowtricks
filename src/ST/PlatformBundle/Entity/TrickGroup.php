<?php

namespace ST\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrickGroup
 *
 * @ORM\Table(name="trick_group")
 * @ORM\Entity(repositoryClass="ST\PlatformBundle\Repository\TrickGroupRepository")
 */
class TrickGroup
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="ST\PlatformBundle\Entity\Trick", mappedBy="trickgroup")
     */
    private $tricks;

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
     * Set name
     *
     * @param string $name
     *
     * @return TrickGroup
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
     * Constructor
     */
    public function __construct()
    {
        $this->tricks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add trick
     *
     * @param \ST\PlatformBundle\Entity\Trick $trick
     *
     * @return TrickGroup
     */
    public function addTrick(\ST\PlatformBundle\Entity\Trick $trick)
    {
        $this->tricks[] = $trick;

        return $this;
    }

    /**
     * Remove trick
     *
     * @param \ST\PlatformBundle\Entity\Trick $trick
     */
    public function removeTrick(\ST\PlatformBundle\Entity\Trick $trick)
    {
        $this->tricks->removeElement($trick);
    }

    /**
     * Get tricks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTricks()
    {
        return $this->tricks;
    }
}
