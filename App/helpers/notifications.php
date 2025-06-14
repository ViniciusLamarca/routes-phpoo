<?php

function add_notification($message, $type = 'success')
{
    $_SESSION['notifications'][] = [
        'message' => $message,
        'type' => $type
    ];
}

function get_notifications()
{
    if (isset($_SESSION['notifications'])) {
        $notifications = $_SESSION['notifications'];
        unset($_SESSION['notifications']);
        return $notifications;
    }
    return [];
}
