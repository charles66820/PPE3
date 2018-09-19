<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Photoproduit
 *
 * @ORM\Table(name="photoproduit", uniqueConstraints={@ORM\UniqueConstraint(name="Photo", columns={"Photo"})}, indexes={@ORM\Index(name="FK_PhotoProduit_IDProduit", columns={"IDProduit"})})
 * @ORM\Entity
 */
class Photoproduit
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDPhotoProduit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idphotoproduit;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Photo", type="string", length=100, nullable=true)
     */
    private $photo;

    /**
     * @var \Produits
     *
     * @ORM\ManyToOne(targetEntity="Produits")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDProduit", referencedColumnName="IDProduit")
     * })
     */
    private $idproduit;

    public function getIdphotoproduit(): ?int
    {
        return $this->idphotoproduit;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

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


}
