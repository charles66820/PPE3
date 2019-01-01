<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Command
 *
 * @ORM\Table(name="command", indexes={@ORM\Index(name="FK_command_idClient", columns={"id_client"}), @ORM\Index(name="FK_command_idAddressDelivery", columns={"id_address_delivery"})})
 * @ORM\Entity
 */
class Command
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_command", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $date = 'CURRENT_TIMESTAMP';

    /**
     * @var string|null
     *
     * @ORM\Column(name="total_HT", type="decimal", precision=15, scale=2, nullable=false)
     */
    private $totalHT;

    /**
     * @var string|null
     *
     * @ORM\Column(name="shipping", type="decimal", precision=15, scale=2, nullable=false)
     */
    private $shipping;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tax_on_command", type="decimal", precision=3, scale=2, nullable=false)
     */
    private $taxOnCommand;

    /**
     * @var \Address
     *
     * @ORM\ManyToOne(targetEntity="Address")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_address_delivery", referencedColumnName="id_address", onDelete="SET NULL")
     * })
     */
    private $addressDelivery;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id_client", onDelete="SET NULL")
     * })
     */
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTotalHT()
    {
        return $this->totalHT;
    }

    public function setTotalHT($totalHT): self
    {
        $this->totalHT = $totalHT;

        return $this;
    }

    public function getShipping()
    {
        return $this->shipping;
    }

    public function setShipping($shipping): self
    {
        $this->shipping = $shipping;

        return $this;
    }

    public function getTaxOnCommand()
    {
        return $this->taxOnCommand;
    }

    public function setTaxOnCommand($taxOnCommand): self
    {
        $this->taxOnCommand = $taxOnCommand;

        return $this;
    }

    public function getAddressDelivery(): ?Adresse
    {
        return $this->addressDelivery;
    }

    public function setAddressDelivery(?Adresse $addressDelivery): self
    {
        $this->addressDelivery = $addressDelivery;

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
