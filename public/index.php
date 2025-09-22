<!DOCTYPE html>
<html>
<head>
  <title>Night of Fun — Ticket Registration</title>
  <style>
    body {
      background: linear-gradient(135deg, #6e00ff, #ff00cc);
      font-family: 'Arial Black', sans-serif;
      color: white;
      text-align: center;
      padding: 50px;
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
    .poster {
      width: 200px;
      margin-bottom: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px #000;
    }
    #scanner {
      margin-top: 30px;
    }
    video {
      width: 300px;
      border: 3px solid white;
      border-radius: 10px;
      box-shadow: 0 0 10px #000;
    }
  </style>
</head>
<body>
  <img src="../assets/poster.jpg" alt="Night of Fun Poster" class="poster">
  <h1>🎉 Night of Fun</h1>
  <p>Register below to receive your themed ticket</p>

  <form action="ticket.php" method="POST">
    <input type="text" name="name" placeholder="Your Name" required><br>
    <input type="text" name="event" value="Night of Fun" readonly><br>
    <input type="email" name="email" placeholder="Your Email" required><br>
    <button type="submit">Generate Ticket</button>
  </form>

  <div id="scanner">
    <h2>🔍 Preview QR Scan</h2>
    <video id="preview" autoplay></video>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/instascan/1.0.0/instascan.min.js"></script>
  <script>
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
    scanner.addListener('scan', function (content) {
      alert('Scanned: ' + content);
    });
    Instascan.Camera.getCameras().then(function (cameras) {
      if (cameras.length > 0) {
        scanner.start(cameras[0]);
      } else {
        alert('No cameras found.');
      }
    }).catch(function (e) {
      console.error(e);
    });
