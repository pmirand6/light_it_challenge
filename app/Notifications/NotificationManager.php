<?php
/**
 * Creator: Pablo Miranda
 * Date: 2023/07/30 20:31
 */

namespace App\Notifications;

use Illuminate\Support\Facades\Mail;
use ReflectionClass;
use ReflectionException;

abstract class NotificationManager
{
    protected bool $sendEmail;
    protected bool $sendSms;

    abstract public function sendNotification(array $params);

    /**
     * @throws ReflectionException
     */
    protected function emailNotification(string $recipient, string $emailClass, array $params): void
    {
        if ($this->sendEmail) {
            $className = "App\\Mail\\" . $emailClass;
            $reflection = new ReflectionClass($className);
            $instanceParams = $reflection->newInstanceArgs([$params]);
            Mail::to($recipient)->send($instanceParams);
        }

    }

    protected function smsNotification(string $phoneNumber, array $params)
    {
        if ($this->sendSms) {
            //
        }
        //TODO IMPLEMENT SMS Notification
    }
}
