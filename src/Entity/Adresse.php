<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Adresse
 *
 * @ORM\Table(name="adresse", indexes={@ORM\Index(name="FK_Adresse_IDClient", columns={"IDClient"})})
 * @ORM\Entity
 */
class Adresse
{
    /**
     * @Assert\Type("int")
     * @Assert\Length(
     *      min = 1,
     *      max = 11,
     *      minMessage = "Your id must be at least {{ limit }} characters long",
     *      maxMessage = "Your id cannot be longer than {{ limit }} characters"
     * )
     * @var int
     *
     * @ORM\Column(name="IDAdresse", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idadresse;

    /**
     * @Assert\Type("string")
     * @Assert\Length(
     *      min = 1,
     *      max = 100,
     *      minMessage = "Your address must be at least {{ limit }} characters long",
     *      maxMessage = "Your address cannot be longer than {{ limit }} characters"
     * )
     * @var string
     *
     * @ORM\Column(name="Voie", type="string", length=100, nullable=false)
     */
    private $voie;

    /**
     * @Assert\Type("string")
     * @Assert\Length(
     *      min = 1,
     *      max = 100,
     *      minMessage = "Your address complement must be at least {{ limit }} characters long",
     *      maxMessage = "Your address complement cannot be longer than {{ limit }} characters"
     * )
     * @var string|null
     *
     * @ORM\Column(name="Complement", type="string", length=100, nullable=true)
     */
    private $complement;

    /**
     * @Assert\Type("string")
     * @Assert\Length(
     *      min = 1,
     *      max = 10,
     *      minMessage = "Your zip code must be at least {{ limit }} characters long",
     *      maxMessage = "Your zip code cannot be longer than {{ limit }} characters"
     * )
     * @var string
     *
     * @ORM\Column(name="CodePostal", type="string", length=10, nullable=false)
     */
    private $codepostal;

    /**
     * @Assert\Type("string")
     * @Assert\Length(
     *      min = 1,
     *      max = 50,
     *      minMessage = "Your city must be at least {{ limit }} characters long",
     *      maxMessage = "Your city cannot be longer than {{ limit }} characters"
     * )
     * @var string
     *
     * @ORM\Column(name="Ville", type="string", length=50, nullable=false)
     */
    private $ville;

    /**
     * @Assert\Type("string")
     * @Assert\Length(
     *      min = 1,
     *      max = 50,
     *      minMessage = "Your country must be at least {{ limit }} characters long",
     *      maxMessage = "Your country cannot be longer than {{ limit }} characters"
     * )
     * @var string
     *
     * @ORM\Column(name="Pays", type="string", length=50, nullable=false)
     */
    private $pays;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDClient", referencedColumnName="IDClient")
     * })
     */
    private $idclient;

    public function getIdadresse(): ?int
    {
        return $this->idadresse;
    }

    public function getVoie(): ?string
    {
        return $this->voie;
    }

    public function setVoie(string $voie): self
    {
        $this->voie = $voie;

        return $this;
    }

    public function getComplement(): ?string
    {
        return $this->complement;
    }

    public function setComplement(?string $complement): self
    {
        $this->complement = $complement;

        return $this;
    }

    public function getCodepostal(): ?string
    {
        return $this->codepostal;
    }

    public function setCodepostal(string $codepostal): self
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

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
