<?php
require_once '../src/db.php';

$resultMessage = '';
$event = $name = $id = '';
$qrCodeUri = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = $_POST['ticket_data'] ?? '';
    $parts = explode('|', $input);

    if (count($parts) === 3) {
        [$event, $name, $id] = $parts;

        $stmt = $pdo->prepare("SELECT * FROM tickets WHERE id = ? AND event = ? AND name = ?");
        $stmt->execute([$id, $event, $name]);
        $ticket = $stmt->fetch();

        if ($ticket && !$ticket['validated']) {
            $update = $pdo->prepare("UPDATE tickets SET validated = 1 WHERE id = ?");
            $update->execute([$id]);

            // Generate QR code URI (assuming you use endroid/qr-code)
            require_once '../vendor/autoload.php';
            use Endroid\QrCode\QrCode;
            use Endroid\QrCode\Writer\PngWriter;

            $qr = new QrCode($input);
            $writer = new PngWriter();
            $result = $writer->write($qr);
            $qrCodeUri = $result->getDataUri();

            $resultMessage = "<span style='color:green;'>✅ Ticket is valid and now marked as used.</span>";
        } else {
            $resultMessage = "<span style='color:red;'>❌ Ticket not found or already used.</span>";
        }
    } else {
        $resultMessage = "<span style='color:red;'>❌ Invalid QR format.</span>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Validate Ticket</title>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f0f0f0; }
        #reader { width: 300px; margin-bottom: 20px; }
        .result { margin-top: 20px; font-size: 1.2em; }
        #ticket {
            width: 400px;
            padding: 20px;
            border: 3px solid #ff00cc;
            background: linear-gradient(135deg, #6e00ff, #ff00cc);
            color: white;
            font-family: 'Arial Black', sans-serif;
            text-align: center;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
            margin-top: 30px;
        }
        #ticket img { width: 150px; margin-top: 15px; }
        button { margin-top: 20px; padding: 10px 20px; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Validate Ticket</h2>

    <div id="reader"></div>

    <form method="POST">
        <input type="text" name="ticket_data" id="ticket_data" placeholder="Scanned QR will appear here" required style="width: 300px;">
        <br><br>
        <button type="submit">Validate Ticket</button>
    </form>

    <div class="result"><?= $resultMessage ?></div>

    <?php if ($qrCodeUri): ?>
    <div id="ticket">
        <h2>🎉 NIGHT OF FUN</h2>
        <p><strong>FABULOUS QUEENS WITH DENIM</strong></p>
        <p>📅 <strong>08 November</strong></p>
        <p>🎤 Hosted by <strong>TEELUXE</strong></p>
        <p>🎭 Performance by <strong>RUSH</strong></p>
        <p>📍 453 Ramoruwe Street, Mapetla</p>
        <p>🎟️ Entry: <strong>R150</strong></p>
        <p>🍽️ Includes meal + cider or gold pin</p>
        <p><strong>Ticket ID:</strong> <?= htmlspecialchars($id) ?></p>
        <img src="<?= $qrCodeUri ?>" alt="QR Code">
    </div>

    <button onclick="downloadTicket()">Download Ticket</button>
    <?php endif; ?>

    <script>
        const qrReader = new Html5Qrcode("reader");
        qrReader.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: 250 },
            (decodedText) => {
                document.getElementById("ticket_data").value = decodedText;
                qrReader.stop();
            },
            (errorMessage) => {
                // Ignore scan errors
            }
        );

        function downloadTicket() {
            html2canvas(document.getElementById("ticket")).then(canvas => {
                const link = document.createElement('a');
                link.download = 'NightOfFun_Ticket.png';
                link.href = canvas.toDataURL();
                link.click();
            });
        }
    </script>
</body>
</html>
