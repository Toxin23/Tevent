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
  </style>
</head>
<body>
  <img src="poster.jpg" alt="Night of Fun Poster" class="poster">
  <h1>🎉 Night of Fun</h1>
  <p>Register below to receive your themed ticket</p>
  <form action="ticket.php" method="POST">
    <input type="text" name="name" placeholder="Your Name" required><br>
    <input type="text" name="event" value="Night of Fun" readonly><br>
    <input type="email" name="email" placeholder="Your Email" required><br>
    <button type="submit">Generate Ticket</button>
  </form>
</body>
</html>
