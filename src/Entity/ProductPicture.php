<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductPicture
 *
 * @ORM\Table(name="product_picture", uniqueConstraints={@ORM\UniqueConstraint(name="FK_productPicture_picture", columns={"picture_name"})}, indexes={@ORM\Index(name="FK_productPicture_idProduct", columns={"id_product"})})
 * @ORM\Entity
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
     * @var string|null
     *
     * @ORM\Column(name="picture_name", type="string", length=100, nullable=true)
     */
    private $pictureName;

    /**
     * @var \Product
     *
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="pictures")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_product", referencedColumnName="id_product")
     * })
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPictureName(): ?string
    {
        return $this->pictureName;
    }

    public function setPictureName(?string $pictureName): self
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
}
