<?php

namespace App\Controller;

use App\Demo\MagicDemo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MagicDemoController extends AbstractController
{
    #[Route('/magic-demo', name: 'magic_demo')]
    public function demo(): Response
    {
        $output = [];

        // Create new instance
        $magic = new MagicDemo("Merhba!");
        $output[] = "1. Created new instance";

        // __set and __get
        $magic->name = "Ahmed";  // Calls __set
        $output[] = "2. Set name to: " . $magic->name;  // Calls __get

        // __isset and __unset
        $output[] = "3. Does name exist? " . (isset($magic->name) ? 'Yes' : 'No');  // Calls __isset
        unset($magic->name);  // Calls __unset
        $output[] = "4. After unset, does name exist? " . (isset($magic->name) ? 'Yes' : 'No');

        // __invoke
        $output[] = "5. Invoke result: " . $magic('test argument');

        // __toString
        $magic->age = 25;
        $magic->city = "Casablanca";
        $output[] = "6. ToString: " . $magic;

        // __debugInfo
        $magic->password = "123456";
        $output[] = "7. Debug info: " . print_r($magic, true);

        // __clone
        $cloned = clone $magic;
        $output[] = "8. Cloned object created";

        // __sleep and __wakeup
        $serialized = serialize($magic);
        $unserialized = unserialize($serialized);
        $output[] = "9. Serialization test completed";

        // __set_state
        $exported = var_export($magic, true);
        $output[] = "10. Export completed";

        return $this->json([
            'title' => 'Magic Methods Demo',
            'results' => $output
        ]);
    }
}
