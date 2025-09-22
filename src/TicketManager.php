<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Endroid\QrCode\QrCode;

class TicketManager {
    public static function generate($event, $name) {
        $data = $event . '|' . $name . '|' . uniqid();
        $qr = new QrCode($data);
        return $qr->writeDataUri();
    }
}
?>
