<?php
require_once '../src/db.php';

$resultMessage = '';

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
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        #reader { width: 300px; margin-bottom: 20px; }
        .result { margin-top: 20px; font-size: 1.2em; }
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
    </script>
</body>
</html>
