<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity
 */
class Categorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="idcat", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcat;

    /**
     * @var string
     *
     * @ORM\Column(name="lblcat", type="string", length=100, nullable=false)
     */
    private $lblcat;

    public function getIdcat(): ?int
    {
        return $this->idcat;
    }

    public function getLblcat(): ?string
    {
        return $this->lblcat;
    }

    public function setLblcat(string $lblcat): self
    {
        $this->lblcat = $lblcat;

        return $this;
    }


}
