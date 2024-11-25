<?php

namespace App\Controller;

use App\Entity\Product;
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
        #[TaggedIterator('app.notification')]
        private readonly iterable $notifications
    )
    {
    }

    #[Route('/product/demo', name: 'product_demo')]
    public function demo(): Response
    {
        // Create a new product (Encapsulation example)
        $product = new Product();
        $product->setName('Laptop')
            ->setPrice(999.99)
            ->setStock(10);

        // Save product
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        // Use static methods (Static Methods & Properties example)
        $priceWithTax = ProductHelper::calculatePriceWithTax($product->getPrice());
        $formattedPrice = ProductHelper::formatPrice($priceWithTax);

        $message = "New product {$product->getName()} added!";

        foreach ($this->notifications as $notification) {
            $notification->send($message);
        }

        return $this->json([
            'product' => [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'priceWithTax' => $priceWithTax,
                'formattedPrice' => $formattedPrice,
                'stock' => $product->getStock(),
                'createdAt' => $product->getCreatedAt()->format('Y-m-d H:i:s'),
                'updatedAt' => $product->getUpdatedAt()->format('Y-m-d H:i:s'),
            ]
        ]);
    }
}