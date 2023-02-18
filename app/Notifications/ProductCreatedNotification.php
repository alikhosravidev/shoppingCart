<?php

namespace App\Notifications;

use App\Contract\Listener;

class ProductCreatedNotification implements Listener
{
    public function handle($argument)
    {
        // echo 'Notification send!';
    }
}