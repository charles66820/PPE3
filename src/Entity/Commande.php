<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="FK_Commande_IDClient", columns={"IDClient"}), @ORM\Index(name="IDAdresseFacturation", columns={"IDAdresseFacturation"}), @ORM\Index(name="IDAdresseLivraison", columns={"IDAdresseLivraison"}), @ORM\Index(name="DateCommande", columns={"DateCommande"}), @ORM\Index(name="DateCommande_2", columns={"DateCommande"})})
 * @ORM\Entity
 */
class Commande
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDCommande", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcommande;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCommande", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $datecommande = 'CURRENT_TIMESTAMP';

    /**
     * @var string|null
     *
     * @ORM\Column(name="TotalHT", type="decimal", precision=15, scale=3, nullable=true)
     */
    private $totalht;

    /**
     * @var string|null
     *
     * @ORM\Column(name="TotalTVA", type="decimal", precision=15, scale=3, nullable=true)
     */
    private $totaltva;

    /**
     * @var string|null
     *
     * @ORM\Column(name="FraisPortHT", type="decimal", precision=15, scale=3, nullable=true)
     */
    private $fraisportht;

    /**
     * @var \Adresse
     *
     * @ORM\ManyToOne(targetEntity="Adresse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDAdresseFacturation", referencedColumnName="IDAdresse")
     * })
     */
    private $idadressefacturation;

    /**
     * @var \Adresse
     *
     * @ORM\ManyToOne(targetEntity="Adresse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDAdresseLivraison", referencedColumnName="IDAdresse")
     * })
     */
    private $idadresselivraison;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDClient", referencedColumnName="IDClient")
     * })
     */
    private $idclient;

    public function getIdcommande(): ?int
    {
        return $this->idcommande;
    }

    public function getDatecommande(): ?\DateTimeInterface
    {
        return $this->datecommande;
    }

    public function setDatecommande(\DateTimeInterface $datecommande): self
    {
        $this->datecommande = $datecommande;

        return $this;
    }

    public function getTotalht()
    {
        return $this->totalht;
    }

    public function setTotalht($totalht): self
    {
        $this->totalht = $totalht;

        return $this;
    }

    public function getTotaltva()
    {
        return $this->totaltva;
    }

    public function setTotaltva($totaltva): self
    {
        $this->totaltva = $totaltva;

        return $this;
    }

    public function getFraisportht()
    {
        return $this->fraisportht;
    }

    public function setFraisportht($fraisportht): self
    {
        $this->fraisportht = $fraisportht;

        return $this;
    }

    public function getIdadressefacturation(): ?Adresse
    {
        return $this->idadressefacturation;
    }

    public function setIdadressefacturation(?Adresse $idadressefacturation): self
    {
        $this->idadressefacturation = $idadressefacturation;

        return $this;
    }

    public function getIdadresselivraison(): ?Adresse
    {
        return $this->idadresselivraison;
    }

    public function setIdadresselivraison(?Adresse $idadresselivraison): self
    {
        $this->idadresselivraison = $idadresselivraison;

        return $this;
    }

    public function getIdclient(): ?Client
    {
        return $this->idclient;
    }

    public function setIdclient(?Client $idclient): self
    {
        $this->idclient = $idclient;

        return $this;
    }


}
