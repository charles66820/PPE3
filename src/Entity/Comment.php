<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Comment
 *
 * @ORM\Table(name="comment", indexes={@ORM\Index(name="FK_comment_idClient", columns={"id_client"}), @ORM\Index(name="FK_comment_idProduct", columns={"id_product"})})
 * @ORM\Entity
 */
class Comment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_comment", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $date = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     * @Assert\Length(
     *      min = 4,
     *      max = 100,
     *      minMessage = "le titre doit faire plus de {{ limit }} caractères de long",
     *      maxMessage = "le titre ne doit pas faire plus de {{ limit }} caractères de long"
     * )
     * @Assert\NotBlank()
     * @ORM\Column(name="title", type="string", length=1000, nullable=false)
     */
    private $title;

    /**
     * @var string|null
     * @Assert\Length(
     *      max = 1000,
     *      maxMessage = "le commantaire ne doit pas faire plus de {{ limit }} caractères de long"
     * )
     * @ORM\Column(name="content", type="string", length=100, nullable=true)
     */
    private $content;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="comments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id_client", nullable=false)
     * })
     */
    private $client;

    /**
     * @var \Product
     *
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="comments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_product", referencedColumnName="id_product", nullable=false)
     * })
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
