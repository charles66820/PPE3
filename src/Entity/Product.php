<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product", indexes={
 *     @ORM\Index(name="FK_product_idCategory", columns={"id_category"})
 * })
 * @ORM\Entity
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
     * @ORM\Column(name="reference", type="string", length=255, nullable=false)
     */
    private $reference;

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
     *   @ORM\JoinColumn(name="id_category", referencedColumnName="id_category", nullable=true)
     * })
     */
    private $category;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="ProductPicture", mappedBy="product", cascade={"remove"}, fetch="EAGER")
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
    private $clientCartLines;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->clientCartLines = new ArrayCollection();
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

    public function getCategorie(): ?Category
    {
        return $this->categorie;
    }

    public function setCategorie(?Category $categorie): self
    {
        $this->categorie = $categorie;

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
    public function getClientCartLines(): Collection
    {
        return $this->clientCartLines;
    }

    public function addClientCartLine(CartLine $clientCartLine): self
    {
        if (!$this->clientCartLines->contains($clientCartLine)) {
            $this->clientCartLines[] = $clientCartLine;
            $clientCartLine->setProduct($this);
        }

        return $this;
    }

    public function removeClientCartLine(CartLine $clientCartLine): self
    {
        if ($this->clientCartLines->contains($clientCartLine)) {
            $this->clientCartLines->removeElement($clientCartLine);
            // set the owning side to null (unless already changed)
            if ($clientCartLine->getProduct() === $this) {
                $clientCartLine->setProduct(null);
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

        $result = 'stars0';
        switch ($moyenneStars) {
            case 0:
                $result = "stars0";
                break;
            case ($moyenneStars <= 0.5):
                $result = "stars0_5";
                break;
            case ($moyenneStars <= 1):
                $result = "stars1";
                break;
            case ($moyenneStars <= 1.5):
                $result = "stars1_5";
                break;
            case ($moyenneStars <= 2):
                $result = "stars2";
                break;
            case ($moyenneStars <= 2.5):
                $result = "stars2_5";
                break;
            case ($moyenneStars <= 3):
                $result = "stars3";
                break;
            case ($moyenneStars <= 3.5):
                $result = "stars3_5";
                break;
            case ($moyenneStars <= 4):
                $result = "stars4";
                break;
            case ($moyenneStars <= 4.5):
                $result = "stars4_5";
                break;

            default:
                $result = 'stars5';
                break;
        }
        return $result;
    }
}
