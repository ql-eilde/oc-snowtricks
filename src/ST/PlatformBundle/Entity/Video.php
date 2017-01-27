<?php

namespace ST\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Video
 *
 * @ORM\Table(name="video")
 * @ORM\Entity(repositoryClass="ST\PlatformBundle\Repository\VideoRepository")
 */
class Video
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
     * @ORM\Column(name="embed_code", type="text")
     * @Assert\Regex(pattern="/^<iframe[^><,\\\(\)\[\]\{\}]+><\/iframe>$/", message="Votre code embed n'est pas valide")
     */
    private $embedCode;

    /**
     * @ORM\ManyToOne(targetEntity="ST\PlatformBundle\Entity\Trick", inversedBy="videos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trick;

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
     * Set embedCode
     *
     * @param string $embedCode
     *
     * @return Video
     */
    public function setEmbedCode($embedCode)
    {
        $this->embedCode = $embedCode;

        return $this;
    }

    /**
     * Get embedCode
     *
     * @return string
     */
    public function getEmbedCode()
    {
        return $this->embedCode;
    }

    /**
     * Set trick
     *
     * @param \ST\PlatformBundle\Entity\Trick $trick
     *
     * @return Video
     */
    public function setTrick(\ST\PlatformBundle\Entity\Trick $trick)
    {
        $this->trick = $trick;

        return $this;
    }

    /**
     * Get trick
     *
     * @return \ST\PlatformBundle\Entity\Trick
     */
    public function getTrick()
    {
        return $this->trick;
    }
}
