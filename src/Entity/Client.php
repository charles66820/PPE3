<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Client
 *
 * @ORM\Table(name="client", indexes={@ORM\Index(name="iddefaultadresse", columns={"iddefaultadresse"})})
 * @ORM\Entity
 */
class Client
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
     * @ORM\Column(name="IDClient", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idclient;

    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 20,
     *      minMessage = "Your pseudo must be at least {{ limit }} characters long",
     *      maxMessage = "Your pseudo cannot be longer than {{ limit }} characters"
     * )
     * @Assert\Type("string")
     * @Assert\NotBlank()
     * @var string
     *
     * @ORM\Column(name="Pseudo", type="string", length=20, nullable=false)
     */
    private $pseudo;

    /**
     * @Assert\Length(
     *      min = 5,
     *      max = 100,
     *      minMessage = "Your email must be at least {{ limit }} characters long",
     *      maxMessage = "Your email cannot be longer than {{ limit }} characters"
     * )
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @Assert\Length(
     *      min = 6,
     *      max = 50,
     *      minMessage = "Your password must be at least {{ limit }} characters long",
     *      maxMessage = "Your password cannot be longer than {{ limit }} characters"
     * )
     *
     * @var string
     *
     * @ORM\Column(name="MotDePasse", type="string", length=50, nullable=false)
     */
    private $motdepasse;

    /**
     * @Assert\Length(
     *      max = 50,
     *      maxMessage = "Your last name cannot be longer than {{ limit }} characters"
     * )
     * @Assert\Type("string")
     * @var string|null
     *
     * @ORM\Column(name="Nom", type="string", length=50, nullable=true)
     */
    private $nom;

    /**
     * @Assert\Length(
     *      max = 50,
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     * @Assert\Type("string")
     * @var string|null
     *
     * @ORM\Column(name="Prenom", type="string", length=50, nullable=true)
     */
    private $prenom;

    /**
     * @Assert\Length(
     *      min = 1,
     *      max = 20,
     *      minMessage = "Your gender must be at least {{ limit }} characters long",
     *      maxMessage = "Your gender cannot be longer than {{ limit }} characters"
     * )
     * @Assert\Type("string")
     * @var string|null
     *
     * @ORM\Column(name="Civilite", type="string", length=20, nullable=true)
     */
    private $civilite;

    /**
     * @Assert\Length(
     *      min = 1,
     *      max = 13,
     *      minMessage = "Your phone number must be at least {{ limit }} characters long",
     *      maxMessage = "Your phone number be longer than {{ limit }} characters"
     * )
     * @Assert\Type("string")
     * @var string|null
     *
     * @ORM\Column(name="Telephone", type="string", length=13, nullable=true)
     */
    private $telephone;

    /**
     * @Assert\Length(
     *      min = 5,
     *      max = 25,
     *      minMessage = "Your avatar url number must be at least {{ limit }} characters long",
     *      maxMessage = "Your avatar url be longer than {{ limit }} characters"
     * )
     * @Assert\Type("string")
     * @var string
     *
     * @ORM\Column(name="AvatarUrl", type="string", length=25, nullable=false)
     */
    private $avatarurl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreation", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $datecreation = 'CURRENT_TIMESTAMP';

    /**
     * @var bool
     *
     * @ORM\Column(name="Actif", type="boolean", nullable=false)
     */
    private $actif = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="Token", type="string", length=40, nullable=false)
     */
    private $token;

    /**
     * @var \Adresse
     *
     * @ORM\ManyToOne(targetEntity="Adresse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="iddefaultadresse", referencedColumnName="IDAdresse")
     * })
     */
    private $iddefaultadresse;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Produits", mappedBy="idclient")
     */
    private $idproduit;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idproduit = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdclient(): ?int
    {
        return $this->idclient;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMotdepasse(): ?string
    {
        return $this->motdepasse;
    }

    public function setMotdepasse(string $motdepasse): self
    {
        $this->motdepasse = $motdepasse;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(?string $civilite): self
    {
        $this->civilite = $civilite;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAvatarurl(): ?string
    {
        return $this->avatarurl;
    }

    public function setAvatarurl(string $avatarurl): self
    {
        $this->avatarurl = $avatarurl;

        return $this;
    }

    public function getDatecreation(): ?\DateTimeInterface
    {
        return $this->datecreation;
    }

    public function setDatecreation(\DateTimeInterface $datecreation): self
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getIddefaultadresse(): ?Adresse
    {
        return $this->iddefaultadresse;
    }

    public function setIddefaultadresse(?Adresse $iddefaultadresse): self
    {
        $this->iddefaultadresse = $iddefaultadresse;

        return $this;
    }

    /**
     * @return Collection|Produits[]
     */
    public function getIdproduit(): Collection
    {
        return $this->idproduit;
    }

    public function addIdproduit(Produits $idproduit): self
    {
        if (!$this->idproduit->contains($idproduit)) {
            $this->idproduit[] = $idproduit;
            $idproduit->addIdclient($this);
        }

        return $this;
    }

    public function removeIdproduit(Produits $idproduit): self
    {
        if ($this->idproduit->contains($idproduit)) {
            $this->idproduit->removeElement($idproduit);
            $idproduit->removeIdclient($this);
        }

        return $this;
    }

}
