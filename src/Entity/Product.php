<?php

namespace App\Entity;

use App\Services\TwigEntityService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table(name="product", indexes={
 *     @ORM\Index(name="FK_product_idCategory", columns={"id_category"})
 * })
 * @UniqueEntity("reference")
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_product", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="product_title", type="string", length=100, nullable=false)
     */
    private $title;

    /**
     * @var float
     *
     * @ORM\Column(name="unit_price_HT", type="float", precision=5, scale=2, nullable=false)
     */
    private $unitPriceHT;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=100, nullable=false, unique=true)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="barcode", type="string", length=100, nullable=true, unique=true)
     */
    private $barcode;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000, nullable=false)
     */
    private $description;

    /**
     * @var \Category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_category", referencedColumnName="id_category", onDelete="SET NULL", nullable=true)
     * })
     */
    private $category;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="ProductPicture", mappedBy="product", cascade={"persist"}, fetch="EAGER")
     */
    private $pictures;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Opinion", mappedBy="product", cascade={"remove"}, fetch="EAGER")
     */
    private $opinions;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="product", cascade={"remove"}, fetch="EAGER")
     */
    private $comments;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CartLine", mappedBy="product", cascade={"remove"})
     */
    private $cartLines;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->cartLines = new ArrayCollection();
        $this->opinions = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unitPriceHT * ((TwigEntityService::getTax()/100)+1);
    }

    public function getUnitPriceHT(): ?float
    {
        return $this->unitPriceHT;
    }

    public function setUnitPriceHT(float $unitPriceHT): self
    {
        $this->unitPriceHT = $unitPriceHT;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|ProductPicture[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(ProductPicture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setProduct($this);
        }

        return $this;
    }

    public function removePicture(ProductPicture $picture): self
    {
        if ($this->pictures->contains($picture)) {
            $this->pictures->removeElement($picture);
            // set the owning side to null (unless already changed)
            if ($picture->getProduct() === $this) {
                $picture->setProduct(null);
            }
        }

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
            $cartLine->setProduct($this);
        }

        return $this;
    }

    public function removeCartLine(CartLine $cartLine): self
    {
        if ($this->cartLines->contains($cartLine)) {
            $this->cartLines->removeElement($cartLine);
            // set the owning side to null (unless already changed)
            if ($cartLine->getProduct() === $this) {
                $cartLine->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Opinion[]
     */
    public function getOpinions(): Collection
    {
        return $this->opinions;
    }

    public function addOpinion(Opinion $opinion): self
    {
        if (!$this->opinions->contains($opinion)) {
            $this->opinions[] = $opinion;
            $opinion->setProduct($this);
        }

        return $this;
    }

    public function removeOpinion(Opinion $opinion): self
    {
        if ($this->opinions->contains($opinion)) {
            $this->opinions->removeElement($opinion);
            // set the owning side to null (unless already changed)
            if ($opinion->getProduct() === $this) {
                $opinion->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Opinion[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Opinion $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setProduct($this);
        }

        return $this;
    }

    public function removeComment(Opinion $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getProduct() === $this) {
                $comment->setProduct(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function GetAverageOpinion() : float
    {
        $sumOpinion = 0;
        foreach ($this->getOpinions() as $opinion) {
            $sumOpinion += $opinion->getScore();
        }

        if (count($this->getOpinions()) <= 0) {
            $averageOpinion = 0;
        } else {
            $averageOpinion = $sumOpinion / count($this->getOpinions());
        }
        return $averageOpinion;
    }

    public function GetStarsClass() : string
    {
        $moyenneStars = $this->GetAverageOpinion();
        return TwigEntityService::getStarsClass($moyenneStars);
    }

    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    public function setBarcode(?string $barcode): self
    {
        $this->barcode = $barcode;

        return $this;
    }
}
