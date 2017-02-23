<?php

namespace ST\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="ST\PlatformBundle\Repository\ImageRepository")
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks
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
     * @ORM\ManyToOne(targetEntity="ST\PlatformBundle\Entity\Trick", inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trick;

    /**
     * @Vich\UploadableField(mapping="trick_image", fileNameProperty="imageName")
     * @Assert\Image(
     *     minWidth = 300,
     *     minWidthMessage = "Votre image doit faire au moins 300px de largeur",
     *     minHeight = 300,
     *     minHeightMessage = "Votre image doit faire au moins 300px de hauteur",
     *     maxWidth = 2000,
     *     maxWidthMessage = "Votre image doit faire moins de 2000px de largeur",
     *     maxHeight = 2000,
     *     maxHeightMessage = "Votre image doit faire moins de 2000px de hauteur",
     *     maxSize = "2M",
     *     maxSizeMessage = "Votre image doit faire moins de 2Mo"
     * )
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

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
     * Set trick
     *
     * @param \ST\PlatformBundle\Entity\Trick $trick
     *
     * @return Image
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

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Image
     */
    public function setImageFile(File $image = null){
        $this->imageFile = $image;

        if($image){
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile(){
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return Image
     */
    public function setImageName($imageName){
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName(){
        return $this->imageName;
    }
}
