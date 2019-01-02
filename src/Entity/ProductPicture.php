<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * ProductPicture
 * 
 * @ORM\Table(name="product_picture", uniqueConstraints={@ORM\UniqueConstraint(name="FK_productPicture_picture", columns={"picture_name"})}, indexes={@ORM\Index(name="FK_productPicture_idProduct", columns={"id_product"})})
 * @ORM\Entity
 * @Vich\Uploadable
 */
class ProductPicture
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_product_picture", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="picture_name", type="string", length=100, nullable=true)
     */
    private $pictureName;

    /**
     * @var \Product
     *
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="pictures")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_product", referencedColumnName="id_product", onDelete="CASCADE", nullable=false)
     * })
     */
    private $product;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPictureName()
    {
        return $this->pictureName;
    }

    public function setPictureName($pictureName): self
    {
        $this->pictureName = $pictureName;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    public function getImage()
    {
        return $this->pictureName;
    }

    public function setImage($pictureName): self
    {
        $this->pictureName = $pictureName;

        return $this;
    }
}
