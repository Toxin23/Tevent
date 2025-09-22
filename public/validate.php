<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qr = $_POST['qr'];
    $stmt = $pdo->prepare("SELECT * FROM tickets WHERE qr = ?");
    $stmt->execute([$qr]);
    $ticket = $stmt->fetch();

    if ($ticket) {
        if ($ticket['validated']) {
            echo "<h3>Ticket already used</h3>";
        } else {
            $pdo->prepare("UPDATE tickets SET validated = 1 WHERE id = ?")->execute([$ticket['id']]);
            echo "<h3>Ticket validated for {$ticket['name']}</h3>";
        }
    } else {
        echo "<h3>Invalid ticket</h3>";
    }
    exit;
}
?>

<form method="POST">
    <input name="qr" placeholder="Paste QR data" required>
    <button type="submit">Validate Ticket</button>
</form>
