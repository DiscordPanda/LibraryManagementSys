<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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

        select, input, button {
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
        <h1>Library Management - Checkout</h1>
    </header>

    <div class="navbar"> 
        <!-- TODO: Link these Navigation items to another page -->
        <a class = "home" target="_self" title = "Go back to the homepage" href="user.php"> Home </a>
        <a class="checkout" target="_self" title="Proceed to the checkout page" href="checkout.php">Checkout</a>
        <a class="Return" target="_self" title="Proceed to the return page" href="return.php">Return</a>
        <a class="Event" target="_self" title="Proceed to the event form page" href="eventForm.php">Book an Event with us!</a>
    </div> 

    <main>
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
                $isbn = $_POST['isbn'];
                $memberId = $_POST['member-id'];
                $libraryId = $_POST['library-id'];
                $issuedDate = date('Y-m-d');
            
                // Use prepared statement for the SELECT query
                $sql = "SELECT b.Quantity - COUNT(r.ISBN) AS AvailableQuantity 
                        FROM Books b 
                        LEFT JOIN Rental r ON b.ISBN = r.ISBN 
                        WHERE b.ISBN = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $isbn);
                $stmt->execute();
                $result = $stmt->get_result();
            
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if ($row['AvailableQuantity'] > 0) {
                        // Insert into Rental table using prepared statement
                        $insertSql = "INSERT INTO Rental (ISBN, MemberID, LibraryID, RentalDate) VALUES (?, ?, ?, ?)";
                        $insertStmt = $conn->prepare($insertSql);
                        $insertStmt->bind_param("ssss", $isbn, $memberId, $libraryId, $issuedDate);
                        $insertStmt->execute();
            
                        if ($insertStmt->execute()) {
                            echo "<script>alert('Book issued successfully!');</script>";
                        } else {
                            $error = $insertStmt->error;
                            echo "<script>alert('Error: $error');</script>";
                        }
                    } else {
                        echo "<script>alert('Sorry, that book is not available at the moment.'); window.location.href = 'https://codd.cs.gsu.edu/~nvu24/user.php'; </script>";
                    }
                    $stmt->close();
                } else {
                    echo "<script>alert('Book not found.');</script>";
                }
                $conn->close();
            }
        ?>
        <h2>Checkout Book</h2>
        <form method = "POST">
            <label for="isbn">Book ISBN:</label>
            <input type="text" id="isbn" name="isbn" placeholder="Enter book ISBN" required>

            <label for="member-id">Member ID:</label>
            <input type="text" id="member-id" name="member-id" placeholder="Enter member ID" required>

            <label for="library-id">Library ID:</label>
                <select id="library-id" name="library-id">
                    <option value="" disabled selected>Select a library</option>
                    <?php
                        $sql = "SELECT DISTINCT BranchName FROM Library";
                        $result = mysqli_query($conn, $sql);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="' . $row['LibraryID'] . '">' . $row['BranchName'] . '</option>';
                        }
                    ?>
                </select>
            <button type="submit">Checkout Book</button>
        </form>
        <script>
            const urlParams = new URLSearchParams(window.location.search);
            const isbn = urlParams.get('isbn');

            document.getElementById('isbn').value = isbn;
        </script>
    </main>

</body>
</html>
