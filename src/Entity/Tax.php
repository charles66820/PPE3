<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tax
 *
 * @ORM\Table(name="tax")
 * @ORM\Entity
 */
class Tax
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_tax", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="tax", type="float", precision=10, scale=2, nullable=false)
     */
    private $tax;
}
