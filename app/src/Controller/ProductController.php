<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Product\DigitalProduct;
use App\Entity\Product\PhysicalProduct;
use App\Interface\NotificationInterface;
use App\Notification\EmailNotification;
use App\Notification\SMSNotification;
use App\Util\ProductHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    #[Route('/product/demo', name: 'product_demo')]
    public function demo(): Response
    {
        // Create a physical product
        $physicalProduct = new PhysicalProduct();
        $physicalProduct->setName('Gaming Laptop')
            ->setPrice(1499.99)
            ->setStock(15)
            ->setWeight(2.5)
            ->setShippingCost(29.99)
            ->setDescription('High-end gaming laptop');

        // Create a digital product
        $digitalProduct = new DigitalProduct();
        $digitalProduct->setName('Antivirus Software')
            ->setPrice(99.99)
            ->setStock(150)
            ->setDownloadLink('https://example.com/download')
            ->setDownloadLimit(3)
            ->setDescription('Premium antivirus software');

        // Save products
        $this->entityManager->persist($physicalProduct);
        $this->entityManager->persist($digitalProduct);
        $this->entityManager->flush();

        // Calculate discounts
        $physicalDiscount = $physicalProduct->calculateDiscount();
        $digitalDiscount = $digitalProduct->calculateDiscount();

        return $this->json([
            'physical_product' => [
                'id' => $physicalProduct->getId(),
                'name' => $physicalProduct->getName(),
                'type' => $physicalProduct->getType(),
                'price' => $physicalProduct->getPrice(),
                'discount' => $physicalDiscount,
                'final_price' => $physicalProduct->getPrice() - $physicalDiscount,
                'weight' => $physicalProduct->getWeight(),
                'shipping_cost' => $physicalProduct->getShippingCost(),
                'created_at' => $physicalProduct->getCreatedAt()->format('Y-m-d H:i:s'),
            ],
            'digital_product' => [
                'id' => $digitalProduct->getId(),
                'name' => $digitalProduct->getName(),
                'type' => $digitalProduct->getType(),
                'price' => $digitalProduct->getPrice(),
                'discount' => $digitalDiscount,
                'final_price' => $digitalProduct->getPrice() - $digitalDiscount,
                'download_limit' => $digitalProduct->getDownloadLimit(),
                'created_at' => $digitalProduct->getCreatedAt()->format('Y-m-d H:i:s'),
            ]
        ]);
    }
}