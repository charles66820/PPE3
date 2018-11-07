<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CartLine
 * @ORM\Table(name="CartLine", indexes={@ORM\Index(name="FK_cartLine_idProduct", columns={"id_product"}), @ORM\Index(name="FK_cartLine_idClient", columns={"id_client"})})
 * @ORM\Entity
 */
class CartLine
{
    //default id : @ORM\GeneratedValue(strategy="IDENTITY")
    /**
     * @var int
     *
     * @ORM\Column(name="tax", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var \Product
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_product", referencedColumnName="id_product")
     * })
     */
    private $product;

    /**
     * @var \Client
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id_client")
     * })
     */
    private $client;

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
