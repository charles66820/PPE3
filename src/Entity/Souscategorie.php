<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Souscategorie
 *
 * @ORM\Table(name="souscategorie", indexes={@ORM\Index(name="idsouscategorie", columns={"idcat"})})
 * @ORM\Entity
 */
class Souscategorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="IdCategorie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcategorie;

    /**
     * @var string
     *
     * @ORM\Column(name="LibelleCategorie", type="string", length=100, nullable=false)
     */
    private $libellecategorie;

    /**
     * @var string
     *
     * @ORM\Column(name="nomsouscat", type="text", length=65535, nullable=false)
     */
    private $nomsouscat;

    /**
     * @var \Souscategorie
     *
     * @ORM\ManyToOne(targetEntity="Souscategorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcat", referencedColumnName="IdCategorie")
     * })
     */
    private $idcat;

    public function getIdcategorie(): ?int
    {
        return $this->idcategorie;
    }

    public function getLibellecategorie(): ?string
    {
        return $this->libellecategorie;
    }

    public function setLibellecategorie(string $libellecategorie): self
    {
        $this->libellecategorie = $libellecategorie;

        return $this;
    }

    public function getNomsouscat(): ?string
    {
        return $this->nomsouscat;
    }

    public function setNomsouscat(string $nomsouscat): self
    {
        $this->nomsouscat = $nomsouscat;

        return $this;
    }

    public function getIdcat(): ?self
    {
        return $this->idcat;
    }

    public function setIdcat(?self $idcat): self
    {
        $this->idcat = $idcat;

        return $this;
    }


}
