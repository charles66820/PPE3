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
     *   @ORM\JoinColumn(name="id_command", referencedColumnName="id_command")
     * })
     */
    private $command;

    /**
     * @var \Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_product", referencedColumnName="id_product")
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
}
