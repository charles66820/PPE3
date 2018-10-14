<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Produits
 *
 * @ORM\Table(name="produits", indexes={@ORM\Index(name="FK_Produits_IdCategorie", columns={"IdCategorie"}), @ORM\Index(name="idtaille", columns={"idtaille"})})
 * @ORM\Entity
 */
class Produits
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDProduit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idproduit;

    /**
     * @var string
     *
     * @ORM\Column(name="LibelleProduit", type="string", length=100, nullable=false)
     */
    private $libelleproduit;

    /**
     * @var float
     *
     * @ORM\Column(name="PrixUnitaireHT", type="float", precision=5, scale=2, nullable=false)
     */
    private $prixunitaireht;

    /**
     * @var string
     *
     * @ORM\Column(name="Reference", type="string", length=255, nullable=false)
     */
    private $reference;

    /**
     * @var int
     *
     * @ORM\Column(name="QuantiteProduit", type="integer", nullable=false)
     */
    private $quantiteproduit;

    /**
     * @var string
     *
     * @ORM\Column(name="DescriptionProduit", type="string", length=1000, nullable=false)
     */
    private $descriptionproduit;

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IdCategorie", referencedColumnName="IdCategorie")
     * })
     */
    private $idcategorie;

    /**
     * @var \Taille
     *
     * @ORM\ManyToOne(targetEntity="Taille")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idtaille", referencedColumnName="idtaille")
     * })
     */
    private $idtaille;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Client", mappedBy="idproduit")
     */
    private $idclient;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idclient = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdproduit(): ?int
    {
        return $this->idproduit;
    }

    public function getLibelleproduit(): ?string
    {
        return $this->libelleproduit;
    }

    public function setLibelleproduit(string $libelleproduit): self
    {
        $this->libelleproduit = $libelleproduit;

        return $this;
    }

    public function getPrixunitaireht(): ?float
    {
        return $this->prixunitaireht;
    }

    public function setPrixunitaireht(float $prixunitaireht): self
    {
        $this->prixunitaireht = $prixunitaireht;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getQuantiteproduit(): ?int
    {
        return $this->quantiteproduit;
    }

    public function setQuantiteproduit(int $quantiteproduit): self
    {
        $this->quantiteproduit = $quantiteproduit;

        return $this;
    }

    public function getDescriptionproduit(): ?string
    {
        return $this->descriptionproduit;
    }

    public function setDescriptionproduit(string $descriptionproduit): self
    {
        $this->descriptionproduit = $descriptionproduit;

        return $this;
    }

    public function getIdcategorie(): ?Categorie
    {
        return $this->idcategorie;
    }

    public function setIdcategorie(?Categorie $idcategorie): self
    {
        $this->idcategorie = $idcategorie;

        return $this;
    }

    public function getIdtaille(): ?Taille
    {
        return $this->idtaille;
    }

    public function setIdtaille(?Taille $idtaille): self
    {
        $this->idtaille = $idtaille;

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getIdclient(): Collection
    {
        return $this->idclient;
    }

    public function addIdclient(Client $idclient): self
    {
        if (!$this->idclient->contains($idclient)) {
            $this->idclient[] = $idclient;
            $idclient->addIdproduit($this);
        }

        return $this;
    }

    public function removeIdclient(Client $idclient): self
    {
        if ($this->idclient->contains($idclient)) {
            $this->idclient->removeElement($idclient);
            $idclient->removeIdproduit($this);
        }

        return $this;
    }

}
