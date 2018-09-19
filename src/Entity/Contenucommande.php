<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contenucommande
 *
 * @ORM\Table(name="contenucommande", indexes={@ORM\Index(name="FK_ContenuCommande_IDCommande", columns={"IDCommande"}), @ORM\Index(name="IDTauxTaxe", columns={"IDTauxTaxe"}), @ORM\Index(name="idproduit", columns={"idproduit"})})
 * @ORM\Entity
 */
class Contenucommande
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDContenuCommande", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcontenucommande;

    /**
     * @var string
     *
     * @ORM\Column(name="PrixUnitaireHT", type="decimal", precision=15, scale=3, nullable=false)
     */
    private $prixunitaireht;

    /**
     * @var int
     *
     * @ORM\Column(name="QuantiteContenu", type="integer", nullable=false)
     */
    private $quantitecontenu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Remise", type="decimal", precision=15, scale=3, nullable=true)
     */
    private $remise;

    /**
     * @var \Commande
     *
     * @ORM\ManyToOne(targetEntity="Commande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDCommande", referencedColumnName="IDCommande")
     * })
     */
    private $idcommande;

    /**
     * @var \Produits
     *
     * @ORM\ManyToOne(targetEntity="Produits")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idproduit", referencedColumnName="IDProduit")
     * })
     */
    private $idproduit;

    /**
     * @var \Taxe
     *
     * @ORM\ManyToOne(targetEntity="Taxe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDTauxTaxe", referencedColumnName="idTaxe")
     * })
     */
    private $idtauxtaxe;

    public function getIdcontenucommande(): ?int
    {
        return $this->idcontenucommande;
    }

    public function getPrixunitaireht()
    {
        return $this->prixunitaireht;
    }

    public function setPrixunitaireht($prixunitaireht): self
    {
        $this->prixunitaireht = $prixunitaireht;

        return $this;
    }

    public function getQuantitecontenu(): ?int
    {
        return $this->quantitecontenu;
    }

    public function setQuantitecontenu(int $quantitecontenu): self
    {
        $this->quantitecontenu = $quantitecontenu;

        return $this;
    }

    public function getRemise()
    {
        return $this->remise;
    }

    public function setRemise($remise): self
    {
        $this->remise = $remise;

        return $this;
    }

    public function getIdcommande(): ?Commande
    {
        return $this->idcommande;
    }

    public function setIdcommande(?Commande $idcommande): self
    {
        $this->idcommande = $idcommande;

        return $this;
    }

    public function getIdproduit(): ?Produits
    {
        return $this->idproduit;
    }

    public function setIdproduit(?Produits $idproduit): self
    {
        $this->idproduit = $idproduit;

        return $this;
    }

    public function getIdtauxtaxe(): ?Taxe
    {
        return $this->idtauxtaxe;
    }

    public function setIdtauxtaxe(?Taxe $idtauxtaxe): self
    {
        $this->idtauxtaxe = $idtauxtaxe;

        return $this;
    }


}
