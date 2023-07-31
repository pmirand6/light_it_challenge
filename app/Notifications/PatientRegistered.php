<?php
/**
 * Creator: Pablo Miranda
 * Date: 2023/07/30 20:31
 */

namespace App\Notifications;

use ReflectionException;

class PatientRegistered extends NotificationManager
{

    public function __construct()
    {
        $this->sendEmail = true;
        $this->sendSms = false;
    }

    /**
     * @throws ReflectionException
     */
    public function sendNotification(array $params): void
    {
        $this->emailNotification($params['email'], 'PatientRegisteredMail', $params);
        $this->smsNotification($params['phone_number'], $params);
    }
}
