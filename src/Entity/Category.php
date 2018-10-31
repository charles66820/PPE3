<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity
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
    private $id_category;

    /**
     * @var string
     *
     * @ORM\Column(name="title_category", type="string", length=100, nullable=false)
     */
    private $categoryTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="name_category", type="text", length=65535, nullable=false)
     */
    private $categoryName;

    public function getIdCategory(): ?int
    {
        return $this->id_category;
    }

    public function getCategoryTitle(): ?string
    {
        return $this->categoryTitle;
    }

    public function setCategoryTitle(string $categoryTitle): self
    {
        $this->categoryTitle = $categoryTitle;

        return $this;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function setCategoryName(string $categoryName): self
    {
        $this->categoryName = $categoryName;

        return $this;
    }

}
