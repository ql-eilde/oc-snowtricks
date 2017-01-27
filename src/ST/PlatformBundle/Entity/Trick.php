<?php

namespace ST\PlatformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Trick
 *
 * @ORM\Table(name="trick")
 * @ORM\Entity(repositoryClass="ST\PlatformBundle\Repository\TrickRepository")
 * @UniqueEntity(fields="name", message="Ce trick existe déjà.")
 * @ORM\HasLifecycleCallbacks()
 */
class Trick
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="ST\PlatformBundle\Entity\TrickGroup", inversedBy="tricks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trickgroup;

    /**
     * @ORM\OneToMany(targetEntity="ST\PlatformBundle\Entity\Comment", mappedBy="trick")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="ST\PlatformBundle\Entity\Image", mappedBy="trick", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="ST\PlatformBundle\Entity\Video", mappedBy="trick", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $videos;

    /**
     * @ORM\ManyToOne(targetEntity="ST\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->comments = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->videos = new ArrayCollection();
    }


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
     * @return Trick
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
     * Set description
     *
     * @param string $description
     *
     * @return Trick
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Trick
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Trick
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Trick
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add comment
     *
     * @param \ST\PlatformBundle\Entity\Comment $comment
     *
     * @return Trick
     */
    public function addComment(\ST\PlatformBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        $comment->setTrick($this);

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \ST\PlatformBundle\Entity\Comment $comment
     */
    public function removeComment(\ST\PlatformBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateDate(){
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Set trickgroup
     *
     * @param \ST\PlatformBundle\Entity\TrickGroup $trickgroup
     *
     * @return Trick
     */
    public function setTrickgroup(\ST\PlatformBundle\Entity\TrickGroup $trickgroup)
    {
        $this->trickgroup = $trickgroup;

        return $this;
    }

    /**
     * Get trickgroup
     *
     * @return \ST\PlatformBundle\Entity\TrickGroup
     */
    public function getTrickgroup()
    {
        return $this->trickgroup;
    }

    /**
     * Add image
     *
     * @param \ST\PlatformBundle\Entity\Image $image
     *
     * @return Trick
     */
    public function addImage(\ST\PlatformBundle\Entity\Image $image)
    {
        $this->images[] = $image;

        $image->setTrick($this);

        $this->images->add($image);

        return $this;
    }

    /**
     * Remove image
     *
     * @param \ST\PlatformBundle\Entity\Image $image
     */
    public function removeImage(\ST\PlatformBundle\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add video
     *
     * @param \ST\PlatformBundle\Entity\Video $video
     *
     * @return Trick
     */
    public function addVideo(\ST\PlatformBundle\Entity\Video $video)
    {
        $this->videos[] = $video;
        $video->setTrick($this);
        $this->videos->add($video);

        return $this;
    }

    /**
     * Remove video
     *
     * @param \ST\PlatformBundle\Entity\Video $video
     */
    public function removeVideo(\ST\PlatformBundle\Entity\Video $video)
    {
        $this->videos->removeElement($video);
    }

    /**
     * Get videos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * Set user
     *
     * @param \ST\UserBundle\Entity\User $user
     *
     * @return Trick
     */
    public function setUser(\ST\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \ST\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
