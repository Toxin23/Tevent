<?php
require_once '../config/db.php';

$input = $_POST['ticket_id'] ?? '';
$resultMessage = '';
$ticket = null;

if ($input) {
    $stmt = $pdo->prepare("SELECT * FROM tickets WHERE id = ?");
    $stmt->execute([$input]);
    $ticket = $stmt->fetch();

    if ($ticket) {
        if ($ticket['validated']) {
            $resultMessage = "⚠️ Ticket already validated.";
        } else {
            $stmt = $pdo->prepare("UPDATE tickets SET validated = 1 WHERE id = ?");
            $stmt->execute([$input]);
            $resultMessage = "✅ Ticket validated successfully!";
        }
    } else {
        $resultMessage = "❌ Ticket not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Validate Ticket</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/instascan/1.0.0/instascan.min.js"></script>
  <style>
    body {
      background: linear-gradient(135deg, #6e00ff, #ff00cc);
      font-family: 'Arial Black', sans-serif;
      color: white;
      text-align: center;
      padding: 40px;
    }
    input, button {
      padding: 10px;
      margin: 10px;
      border-radius: 5px;
      border: none;
      width: 300px;
      font-size: 1em;
    }
    button {
      background: #ff00cc;
      color: white;
      font-weight: bold;
      cursor: pointer;
    }
    video {
      width: 
