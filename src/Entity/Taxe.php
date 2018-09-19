<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Taxe
 *
 * @ORM\Table(name="taxe")
 * @ORM\Entity
 */
class Taxe
{
    /**
     * @var int
     *
     * @ORM\Column(name="idTaxe", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtaxe;

    /**
     * @var float
     *
     * @ORM\Column(name="tauxTaxe", type="float", precision=10, scale=0, nullable=false)
     */
    private $tauxtaxe;

    public function getIdtaxe(): ?int
    {
        return $this->idtaxe;
    }

    public function getTauxtaxe(): ?float
    {
        return $this->tauxtaxe;
    }

    public function setTauxtaxe(float $tauxtaxe): self
    {
        $this->tauxtaxe = $tauxtaxe;

        return $this;
    }


}
