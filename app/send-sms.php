<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../vendor/autoload.php';

$basic  = new \Nexmo\Client\Credentials\Basic('79f7820f', 'GQ4o0jVBtwvHPEko');
$client = new \Nexmo\Client($basic);

try {
    $message = $client->message()->send([
        'to' => '6282314034541',
        'from' => 'Kouvee Pet Shop',
        'text' => 'Layanan anda sudah selesai!'
    ]);
    $response = $message->getResponseData();

    if($response['messages'][0]['status'] == 0) {
        echo "SMS sudah terkirim!\n";
    } else {
        echo "SMS gagal terkirim dengan status: " . $response['messages'][0]['status'] . "\n";
    }
} catch (Exception $e) {
    echo "SMS tidak terkirim. Error: " . $e->getMessage() . "\n";
}