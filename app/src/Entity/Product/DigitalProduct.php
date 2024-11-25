<?php

namespace App\Entity\Product;

use App\Repository\DigitalProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DigitalProductRepository::class)]
class DigitalProduct extends AbstractProduct
{
    #[ORM\Column]
    private string $downloadLink;

    #[ORM\Column]
    private int $downloadLimit;

    public function getDownloadLink(): string
    {
        return $this->downloadLink;
    }

    public function setDownloadLink(string $downloadLink): self
    {
        $this->downloadLink = $downloadLink;
        return $this;
    }

    public function getDownloadLimit(): int
    {
        return $this->downloadLimit;
    }

    public function setDownloadLimit(int $downloadLimit): self
    {
        $this->downloadLimit = $downloadLimit;
        return $this;
    }

    public function calculateDiscount(): float
    {
        return $this->stock > 100 ? $this->price * 0.20 : 0;
    }

    public function getType(): string
    {
        return 'digital';
    }
}
