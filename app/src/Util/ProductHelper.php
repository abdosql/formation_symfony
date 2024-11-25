<?php
/**
 * @author Saqqal Abdelaziz <seqqal.abdelaziz@gmail.com>
 * @Linkedin https://www.linkedin.com/abdelaziz-saqqal
 */

namespace App\Util;

class ProductHelper
{
    private static float $taxRate = 0.20;

    public static function calculatePriceWithTax(float $price): float
    {
        return $price * (1 + self::$taxRate);
    }

    public static function formatPrice(float $price): string
    {
        return number_format($price, 2) . ' MAD';
    }

    public static function setTaxRate(float $rate): void
    {
        self::$taxRate = $rate;
    }
}