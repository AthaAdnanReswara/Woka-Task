<?php

use App\Models\Notification;

function sendNotif($userId, $judul, $pesan)
{
    Notification::create([
        'user_id' => $userId,
        'title' => $judul,
        'message' => $pesan,
    ]);
}
