<?php
/**
 * @author Saqqal Abdelaziz <seqqal.abdelaziz@gmail.com>
 * @Linkedin https://www.linkedin.com/abdelaziz-saqqal
 */

namespace App\Notification;

use App\Interface\NotificationInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.notification')]
class EmailNotification implements NotificationInterface
{
    public function send(string $message): void
    {
        // Email notification logic
        // This is just an example
        echo "Sending email: $message";
    }
}