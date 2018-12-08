<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Client
 *
 * @ORM\Table(name="client", indexes={@ORM\Index(name="FK_client_idDefaultAddress", columns={"id_default_address"})})
 * @ORM\Entity
 */
class Client implements UserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_client", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="login", type="string", length=20, nullable=false)
     */
    private $login;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=250)
     */
    private $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=250, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(max=250)
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="last_name", type="string", length=50, nullable=true)
     */
    private $lastName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="first_name", type="string", length=50, nullable=true)
     */
    private $firstName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone_number", type="string", length=13, nullable=true)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar_url", type="string", length=2000, nullable=false)
     */
    private $avatarUrl = "https://randomuser.me/api/portraits/women/11.jpg";

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $creationDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="confirmed", type="boolean", nullable=false)
     */
    private $confirmed = true;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=40, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var \Address
     *
     * @ORM\ManyToOne(targetEntity="Address")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_default_address", referencedColumnName="id_address")
     * })
     */
    private $defaultAdresse;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CartLine", mappedBy="client")
     */
    private $productCartLines;

    public function __construct()
    {
        $this->productCartLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    public function setAvatarUrl(string $avatarUrl): self
    {
        $this->avatarUrl = $avatarUrl;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getConfirmed(): ?bool
    {
        return $this->confirmed;
    }

    public function setConfirmed(bool $confirmed): self
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getDefaultAdresse(): ?Address
    {
        return $this->defaultAdresse;
    }

    public function setDefaultAdresse(?Address $defaultAdresse): self
    {
        $this->defaultAdresse = $defaultAdresse;

        return $this;
    }

    /**
     * @return Collection|CartLine[]
     */
    public function getProductCartLines(): Collection
    {
        return $this->productCartLines;
    }

    public function addProductCartLine(CartLine $productCartLine): self
    {
        if (!$this->productCartLines->contains($productCartLine)) {
            $this->productCartLines[] = $productCartLine;
            $productCartLine->setClient($this);
        }

        return $this;
    }

    public function removeProductCartLine(CartLine $productCartLine): self
    {
        if ($this->productCartLines->contains($productCartLine)) {
            $this->productCartLines->removeElement($productCartLine);
            // set the owning side to null (unless already changed)
            if ($productCartLine->getClient() === $this) {
                $productCartLine->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPlainPassword(): string
    {
        return (string) $this->plainPassword;
    }

    public function setPlainPassword(string $password): self
    {
        $this->plainPassword = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->login;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt() { }

    /**
     * @see UserInterface
     */
    public function eraseCredentials() { }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize(): string
    {
        return serialize([$this->id, $this->login, $this->password]);
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized): void
    {
        [$this->id, $this->login, $this->password] = unserialize($serialized, ['allowed_classes' => false]);
    }
}
