<?php

namespace App\Entity\Product;

use App\Repository\PhysicalProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhysicalProductRepository::class)]
class PhysicalProduct extends AbstractProduct
{
    #[ORM\Column]
    private float $weight;

    #[ORM\Column]
    private float $shippingCost;

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;
        return $this;
    }

    public function getShippingCost(): float
    {
        return $this->shippingCost;
    }

    public function setShippingCost(float $shippingCost): self
    {
        $this->shippingCost = $shippingCost;
        return $this;
    }

    public function calculateDiscount(): float
    {
        return $this->stock > 10 ? $this->price * 0.10 : 0;
    }

    public function getType(): string
    {
        return 'physical';
    }
}
