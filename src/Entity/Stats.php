<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatsRepository")
 */
class Stats
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbOrders;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $TotalTTC;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $AVGOrderCost;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $NbClients;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $NbClientHaveOrder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getNbOrders(): ?int
    {
        return $this->nbOrders;
    }

    public function setNbOrders(?int $nbOrders): self
    {
        $this->nbOrders = $nbOrders;

        return $this;
    }

    public function getTotalTTC(): ?float
    {
        return $this->TotalTTC;
    }

    public function setTotalTTC(?float $TotalTTC): self
    {
        $this->TotalTTC = $TotalTTC;

        return $this;
    }

    public function getAVGOrderCost(): ?float
    {
        return $this->AVGOrderCost;
    }

    public function setAVGOrderCost(?float $AVGOrderCost): self
    {
        $this->AVGOrderCost = $AVGOrderCost;

        return $this;
    }

    public function getNbClients(): ?int
    {
        return $this->NbClients;
    }

    public function setNbClients(?int $NbClients): self
    {
        $this->NbClients = $NbClients;

        return $this;
    }

    public function getNbClientHaveOrder(): ?int
    {
        return $this->NbClientHaveOrder;
    }

    public function setNbClientHaveOrder(?int $NbClientHaveOrder): self
    {
        $this->NbClientHaveOrder = $NbClientHaveOrder;

        return $this;
    }
}
