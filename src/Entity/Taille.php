<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Taille
 *
 * @ORM\Table(name="taille")
 * @ORM\Entity
 */
class Taille
{
    /**
     * @var int
     *
     * @ORM\Column(name="idtaille", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtaille;

    /**
     * @var string
     *
     * @ORM\Column(name="libelleTaille", type="string", length=100, nullable=false)
     */
    private $libelletaille;

    public function getIdtaille(): ?int
    {
        return $this->idtaille;
    }

    public function getLibelletaille(): ?string
    {
        return $this->libelletaille;
    }

    public function setLibelletaille(string $libelletaille): self
    {
        $this->libelletaille = $libelletaille;

        return $this;
    }


}
