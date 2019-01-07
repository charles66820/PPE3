<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 *
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_category", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * Assert\Length(
     *      min = 1,
     *      max = 250,
     *      minMessage = "le titre doit faire plus de {{ limit }} caractères de long",
     *      maxMessage = "le titre ne doit pas faire plus de {{ limit }} caractères de long"
     * )
     * @Assert\NotBlank()
     * @ORM\Column(name="title_category", type="text", length=250, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * Assert\Length(
     *      min = 1,
     *      max = 100,
     *      minMessage = "le nom doit faire plus de {{ limit }} caractères de long",
     *      maxMessage = "le nom ne doit pas faire plus de {{ limit }} caractères de long"
     * )
     * @Assert\NotBlank()
     * @ORM\Column(name="name_category", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var \Product
     *
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category", fetch="EAGER")
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }

}
