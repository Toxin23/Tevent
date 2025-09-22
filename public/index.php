<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/TicketManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event = $_POST['event'];
    $name = $_POST['name'];
    $qrData = $event . '|' . $name . '|' . uniqid();
    $qrImage = TicketManager::generate($event, $name);
    $stmt = $pdo->prepare("INSERT INTO tickets (event, name, qr) VALUES (?, ?, ?)");
    $stmt->execute([$event, $name, $qrData]);
    echo "<h3>Ticket for $name</h3><img src='$qrImage'>";
    echo "<p><a href='validate.php'>Validate a Ticket</a></p>";
    exit;
}
?>

<form method="POST">
    <input name="event" placeholder="Event Name" required>
    <input name="name" placeholder="Your Name" required>
    <button type="submit">Generate Ticket</button>
</form>
