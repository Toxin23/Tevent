<?php
require_once '../vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

$name = $_POST['name'] ?? '';
$event = $_POST['event'] ?? 'Night of Fun';
$email = $_POST['email'] ?? '';
$id = uniqid();

$data = "$event|$name|$id";

// ✅ Compatible QR code instantiation
$qr = new QrCode($data);
$qr->setErrorCorrectionLevel(new ErrorCorrectionLevelHigh());

$writer = new PngWriter();
$result = $writer->write($qr);
$qrCodeUri = $result->getDataUri();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Your Night of Fun Ticket</title>
  <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
  <style>
    body {
      background: linear-gradient(135deg, #6e00ff, #ff00cc);
      font-family: 'Arial Black', sans-serif;
      color: white;
      text-align: center;
      padding: 50px;
    }
    #ticket {
      width: 400px;
      margin: auto;
      padding: 20px;
      border: 3px solid #ff00cc;
      background: #fff;
      color: #000;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.3);
    }
    #ticket img {
      width: 150px;
      margin-top: 15px;
    }
    button {
      margin-top: 20px;
      padding: 10px 20px;
      font-weight: bold;
      background: #ff00cc;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <h1>🎫 Your Ticket</h1>
  <div id="ticket">
    <h2>🎉 NIGHT OF FUN</h2>
    <p><strong>FABULOUS QUEENS WITH DENIM</strong></p>
    <p>📅 08 November</p>
    <p>🎤 Hosted by TEELUXE</p>
    <p>🎭 Performance by RUSH</p>
    <p>📍 453 Ramoruwe Street, Mapetla</p>
    <p>🎟️ Entry: R150</p>
    <p>🍽️ Includes meal + cider or gold pin</p>
    <p><strong>Name:</strong> <?= htmlspecialchars($name) ?></p>
    <p><strong>Ticket ID:</strong> <?= $id ?></p>
    <img src="<?= $qrCodeUri ?>" alt="QR Code">
  </div>
  <button onclick="downloadTicket()">Download Ticket</button>

  <script>
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
