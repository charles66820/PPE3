<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Address
 *
 * @ORM\Table(name="address", indexes={@ORM\Index(name="FK_address_idClient", columns={"id_client"})})
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 */
class Address
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_address", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @Assert\Length(
     *      min = 10,
     *      max = 100,
     *      minMessage = "l'adresse doit faire plus de {{ limit }} caractères de long",
     *      maxMessage = "l'adresse ne doit pas faire plus de {{ limit }} caractères de long"
     * )
     * @Assert\NotBlank()
     * @ORM\Column(name="way", type="string", length=100, nullable=false)
     */
    private $way;

    /**
     * @var string|null
     * @Assert\Length(
     *      min = 10,
     *      max = 100,
     *      minMessage = "le complement adresse doit faire plus de {{ limit }} caractères de long",
     *      maxMessage = "le complement adresse ne doit pas faire plus de {{ limit }} caractères de long"
     * )
     * @ORM\Column(name="complement", type="string", length=100, nullable=true)
     */
    private $complement;

    /**
     * @var string
     * @Assert\Length(
     *      max = 10,
     *      maxMessage = "le code postal ne doit pas faire plus de {{ limit }} caractères de long"
     * )
     * @Assert\NotBlank()
     * @ORM\Column(name="zip_code", type="string", length=10, nullable=false)
     */
    private $zipCode;

    /**
     * @var string
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "la ville doit faire plus de {{ limit }} caractères de long",
     *      maxMessage = "la ville ne doit pas faire plus de {{ limit }} caractères de long"
     * )
     * @Assert\NotBlank()
     * @ORM\Column(name="city", type="string", length=50, nullable=false)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=50, nullable=false)
     */
    private $country = "France";

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="address")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id_client")
     * })
     */
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWay(): ?string
    {
        return $this->way;
    }

    public function setWay(string $way): self
    {
        $this->way = $way;

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

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

}
