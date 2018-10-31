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
     * @ORM\Column(name="total_HT", type="decimal", precision=15, scale=2, nullable=true)
     */
    private $totalHT;

    /**
     * @var string|null
     *
     * @ORM\Column(name="shipping", type="decimal", precision=15, scale=2, nullable=true)
     */
    private $shipping;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tax_on_command", type="decimal", precision=3, scale=2, nullable=true)
     */
    private $taxOnCommand;

    /**
     * @var \Adresse
     *
     * @ORM\ManyToOne(targetEntity="Adresse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_address_delivery", referencedColumnName="id_address")
     * })
     */
    private $addressDelivery;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id_client")
     * })
     */
    private $client;
}
