<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .navbar {
            width: 100%;
            background-color:#ada09f ;
            overflow: hidden;
        }

        .navbar a {
            float: left;
            display: block;
            color: black;
            padding: 14px 16px;
            text-align: center;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        header {
            background-color: #cd6155;
            color: white;
            padding: 15px;
            text-align: center;
        }

        main {
            padding: 20px;
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input, button {
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #cd6155;
            color: white;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <header>
        <h1>Library Management - Event Form</h1>
    </header>
    <div class="navbar"> 
        <!-- TODO: Link these Navigation items to another page -->
        <a class = "home" target="_self" title = "Go back to the homepage" href="user.php"> Home </a>
        <a class="checkout" target="_self" title="Proceed to the checkout page" href="checkout.php">Checkout</a>
        <a class="Return" target="_self" title="Proceed to the return page" href="return.php">Return</a>
        <a class="Event" target="_self" title="Proceed to the event form page" href="eventForm.php">Book an Event with us!</a>
    </div> 

    <main>
        <h2>Add Event</h2>
        <?php
           define('DB_USER', 'nvu24');
           define('DB_PASS', 'nvu24');
           define('DB_NAME', 'nvu24');
           define('DB_HOST', 'localhost');

           $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
           if (!$conn) {
               die("Connection failed: " . mysqli_connect_error());
           }

           if ($_SERVER["REQUEST_METHOD"] == "POST") {
               $Ename = $_POST['eventName'];
               $Edate = $_POST['eventDate'];
               $ETime = $_POST['eventTime'];
               $EDes = $_POST['eventDescription'];

               $insert = "INSERT INTO event (eventName, eventDate, eventTime, eventDescription) VALUES ('$Ename', '$Edate', '$ETime', '$EDes')";
               if ($conn->query($insert) === TRUE) {
                   echo "<script>alert('Event added successfully!');</script>";
               } else {
                   $error = $conn->error;
                   echo "<script>alert('Error: $error');</script>";
               }

               mysqli_close($conn);
           }
        ?>
        <form method="POST">
            <label for="eventName">Event Name:</label>
            <input type="text" id="eventName" name="eventName" required>

            <label for="eventDate">Date of Event:</label>
            <input type="date" id="eventDate" name="eventDate" required>

            <label for="eventTime">Time of Event:</label>
            <input type="time" id="eventTime" name="eventTime" required>

            <label for="eventDescription">Description of Event:</label>
            <input type="text" id="eventDescription" name="eventDescription" required>

            <button type="submit">Submit</button>
        </form>
    </main>
</body>
</html>
