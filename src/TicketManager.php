<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class TicketManager {
    public static function generate($event, $name) {
        $data = $event . '|' . $name . '|' . uniqid();

        $result = Builder::fromString($data)
            ->writer(new PngWriter())
            ->size(300)
            ->margin(10)
            ->build();

        return 'data:image/png;base64,' . base64_encode($result->getString());
    }
}
?>
