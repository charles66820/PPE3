<?php

namespace App\Entity;

use App\Services\TwigEntityService;
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
     * @Assert\Length(
     *      min = 2,
     *      max = 20,
     *      minMessage = "votre identifiant doit faire plus de {{ limit }} caractères de long",
     *      maxMessage = "votre identifiant ne doit pas faire plus de {{ limit }} caractères de long"
     * )
     * @Assert\Type("string")
     * @Assert\NotBlank()
     * @ORM\Column(name="login", type="string", length=20, nullable=false)
     */
    private $login;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min = 5,
     *     max = 100,
     *     minMessage = "Votre email doit faire plus de {{ limit }} caractères de long",
     *     maxMessage = "Votre email ne doit pas faire plus de {{ limit }} caractères de long"
     * )
     * @Assert\Email(
     *     message = "Cette adresse email ( {{ value }} ) n'est pas valide.",
     *     checkMX = true
     * )
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string
     * @Assert\Length(
     *     min=6,
     *     max=100,
     *     minMessage = "Votre mots de passe doit faire plus de {{ limit }} caractères de long",
     *     maxMessage = "Votre mots de passe ne doit pas faire plus de {{ limit }} caractères de long"
     * )
     * @Assert\Type("string")
     * @ORM\Column(name="password", type="string", length=250, nullable=false)
     */
    private $password;

    /**
     * @var string|null
     * @Assert\Length(
     *      max = 50,
     *      maxMessage = "Votre nom de famille ne doit pas faire plus de {{ limit }} caractères de long"
     * )
     * @Assert\Type("string")
     * @ORM\Column(name="last_name", type="string", length=50, nullable=true)
     */
    private $lastName;

    /**
     * @var string|null
     * @Assert\Length(
     *      max = 50,
     *      maxMessage = "Votre prénom ne doit pas faire plus de {{ limit }} caractères de long"
     * )
     * @Assert\Type("string")
     * @ORM\Column(name="first_name", type="string", length=50, nullable=true)
     */
    private $firstName;

    /**
     * @var string|null
     * @Assert\Length(
     *      min = 1,
     *      max = 13,
     *      minMessage = "Votre numéro de telephone doit faire plus de {{ limit }} caractères de long",
     *      maxMessage = "Votre numéro de telephone ne doit pas faire plus de {{ limit }} caractères de long"
     * )
     * @Assert\Type("string")
     * @ORM\Column(name="phone_number", type="string", length=13, nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(name="avatar_url", type="string", length=2000, nullable=true)
     */
    private $avatarUrl;

    /**
     * @Assert\File(
     *     maxSize = "2M",
     *     mimeTypes={ "image/jpeg", "image/png", "image/gif" })
     *     mimeTypesMessage = "L'image n'est pas valide, seuls les fichiers jpeg, png et gif son supporter"
     */
    private $avatarFile;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Command", mappedBy="client", fetch="EAGER")
     */
    private $commands;

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
     * @ORM\Column(type="string")
     */
    private $roles = '[]';

    /**
     * @var Address
     *
     * @ORM\ManyToOne(targetEntity="Address")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_default_address", referencedColumnName="id_address", nullable=true)
     * })
     */
    private $defaultAddress;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CartLine", mappedBy="client", fetch="EAGER")
     */
    private $cartLines;

    /**
     * @Assert\Length(
     *     min=6,
     *     max=100,
     *     minMessage = "Votre nouveau mots de passe doit faire plus de {{ limit }} caractères de long",
     *     maxMessage = "Votre nouveau mots de passe ne doit pas faire plus de {{ limit }} caractères de long"
     * )
     * @Assert\Type("string")
     */
    private $newPassword;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=6,
     *     max=100,
     *     minMessage = "Votre mots de passe doit faire plus de {{ limit }} caractères de long",
     *     maxMessage = "Votre mots de passe ne doit pas faire plus de {{ limit }} caractères de long"
     * )
     * @Assert\Type("string")
     */
    private $plainPassword;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Address", mappedBy="client", cascade={"remove"}, fetch="EAGER")
     */
    private $address;

    public function __construct()
    {
        $this->cartLines = new ArrayCollection();
        $this->address = new ArrayCollection();
        $this->commands = new ArrayCollection();
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

    public function getDefaultAddress(): ?Address
    {
        return $this->defaultAddress;
    }

    public function setDefaultAddress(?Address $defaultAddress): self
    {
        $this->defaultAddress = $defaultAddress;

        return $this;
    }

    /**
     * @return Collection|CartLine[]
     */
    public function getCartLines(): Collection
    {
        return $this->cartLines;
    }

    public function addCartLine(CartLine $cartLine): self
    {
        if (!$this->cartLines->contains($cartLine)) {
            $this->cartLines[] = $cartLine;
            $cartLine->setClient($this);
        }

        return $this;
    }

    public function removeCartLine(CartLine $cartLine): self
    {
        if ($this->cartLines->contains($cartLine)) {
            $this->cartLines->removeElement($cartLine);
            // set the owning side to null (unless already changed)
            if ($cartLine->getClient() === $this) {
                $cartLine->setClient(null);
            }
        }

        return $this;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $password): self
    {
        $this->newPassword = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

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
        $roles = (array)json_decode($this->roles);
        // guarantee every user at least has ROLE_USER
        if (!in_array('ROLE_USER', $roles)) $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = json_encode($roles);

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

    /**
     * @return Collection|Address[]
     */
    public function getAddress(): Collection
    {
        return $this->address;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->address->contains($address)) {
            $this->address[] = $address;
            $address->setClient($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->address->contains($address)) {
            $this->address->removeElement($address);
            // set the owning side to null (unless already changed)
            if ($address->getClient() === $this) {
                $address->setClient(null);
            }
        }

        return $this;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    public function setAvatarUrl(?string $avatarUrl): self
    {
        $this->avatarUrl = $avatarUrl;

        return $this;
    }

    public function getAvatarFile()
    {
        return $this->avatarFile;
    }

    public function setAvatarFile($avatarFile): self
    {
        $this->avatarFile = $avatarFile;

        return $this;
    }

    /**
     * @return Collection|Command[]
     */
    public function getCommands(): Collection
    {
        return $this->commands;
    }

    public function addCommand(Command $command): self
    {
        if (!$this->commands->contains($command)) {
            $this->commands[] = $command;
            $command->setClient($this);
        }

        return $this;
    }

    public function removeCommand(Command $command): self
    {
        if ($this->commands->contains($command)) {
            $this->commands->removeElement($command);
            // set the owning side to null (unless already changed)
            if ($command->getClient() === $this) {
                $command->setClient(null);
            }
        }

        return $this;
    }

    public function getTotalPriceHT()
    {
        $totalHT = 0;
        foreach ($this->cartLines as $cartLine){
            $totalHT += $cartLine->getProduct()->getUnitPriceHT() * $cartLine->getQuantity();
        }
        return $totalHT;
    }

    public function getTotalPrice()
    {
        return $this->getTotalPriceHT() * ((TwigEntityService::getTax()/100)+1);
    }

    public function alreadyOrdered(Product $product): bool
    {
        $productFind = false;
        foreach ($this->commands as $command) {
            foreach ($command->getCommandContents() as $commandContent) {
                if ($commandContent->getProduct() == $product) {
                    $productFind = true;
                    break;
                }
            }
        }
        return $productFind;
    }

    public function getOpinion(Product $product)
    {
        $opinion = null;
        foreach ($product->getOpinions() as $o) {
            if ($o->getClient() == $this) {
                $opinion = $o;
                break;
            }
        }
        return $opinion;
    }
}
