<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommandContent
 *
 * @ORM\Table(name="command_content", indexes={@ORM\Index(name="FK_commandContent_idCommand", columns={"id_command"}), @ORM\Index(name="FK_commandContent_idTax", columns={"id_tax"}), @ORM\Index(name="FK_commandContent_idProduct", columns={"id_product"})})
 * @ORM\Entity
 */
class CommandContent
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_command_content", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="unit_price_HT", type="decimal", precision=15, scale=2, nullable=false)
     */
    private $unitPriceHT;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var string|null
     *
     * @ORM\Column(name="discount", type="decimal", precision=15, scale=2, nullable=true)
     */
    private $discount;

    /**
     * @var \Command
     *
     * @ORM\ManyToOne(targetEntity="Command")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_command", referencedColumnName="id_command", onDelete="CASCADE")
     * })
     */
    private $command;

    /**
     * @var \Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_product", referencedColumnName="id_product", onDelete="SET NULL")
     * })
     */
    private $product;

    /**
     * @var \Tax
     *
     * @ORM\ManyToOne(targetEntity="Tax")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tax", referencedColumnName="id_tax")
     * })
     */
    private $tax;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnitPriceHT()
    {
        return $this->unitPriceHT;
    }

    public function setUnitPriceHT($unitPriceHT): self
    {
        $this->unitPriceHT = $unitPriceHT;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getDiscount()
    {
        return $this->discount;
    }

    public function setDiscount($discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getCommand(): ?Command
    {
        return $this->command;
    }

    public function setCommand(?Command $command): self
    {
        $this->command = $command;

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

    public function getTax(): ?Tax
    {
        return $this->tax;
    }

    public function setTax(?Tax $tax): self
    {
        $this->tax = $tax;

        return $this;
    }
}
