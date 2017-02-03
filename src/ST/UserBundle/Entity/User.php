<?php

namespace ST\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="ST\UserBundle\Repository\UserRepository")
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    private $first_name;

    /**
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    private $last_name;

    /**
     * @Vich\UploadableField(mapping="user_image", fileNameProperty="imageName", cascade={"remove"}, orphanRemoval=true)
     * @Assert\Image(
     *     minWidth = 100,
     *     minWidthMessage = "Votre image doit faire au moins 100px de largeur",
     *     minHeight = 100,
     *     minHeightMessage = "Votre image doit faire au moins 100px de hauteur",
     *     maxWidth = 500,
     *     maxWidthMessage = "Votre image doit faire moins de 500px de largeur",
     *     maxHeight = 500,
     *     maxHeightMessage = "Votre image doit faire moins de 500px de hauteur",
     *     maxSize = "1M",
     *     maxSizeMessage = "Votre image doit faire moins de 1Mo",
     * )
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return User
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
     * @return User
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
