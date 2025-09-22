<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class TicketManager {
    public static function generate($event, $name) {
        $data = $event . '|' . $name . '|' . uniqid();

        $qrCode = new QrCode($data);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        return 'data:image/png;base64,' . base64_encode($result->getString());
    }
}
?>
