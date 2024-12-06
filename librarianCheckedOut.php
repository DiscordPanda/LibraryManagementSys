<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management - Checked Out Books</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
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
            background-color: #cd6155; /* Same red as checkout.html */
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        main {
            padding: 30px;
            max-width: 900px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            animation: fadeIn 1s ease-in-out;
        }

        h2 {
            text-align: center;
            color: #cd6155; /* Same red as checkout.html */
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: bold;
        }

        /* Filter Section */
        .filter-section {
            margin-bottom: 30px;
            text-align: center;
        }

        .filter-section label {
            margin-right: 10px;
            font-weight: bold;
            font-size: 16px;
            color: #555;
        }

        .filter-section select {
            padding: 10px;
            font-size: 16px;
            border: 2px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .filter-section select:hover,
        .filter-section select:focus {
            border-color: #cd6155;
            outline: none;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.15);
        }

        /* Book Container and Details */
        .book-container {
            /* display: flex; */
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }

        .book-details {
            /* width: 100%; */
            flex: 1 1 45%;
            background: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .book-details:hover {
            transform: translateY(-5px);
            box-shadow: 0px 6px 16px rgba(0, 0, 0, 0.2);
        }

        .book-details div {
            margin-bottom: 12px;
            font-size: 16px;
            line-height: 1.5;
            color: #555;
        }

        .book-details div strong {
            color: #cd6155; /* Same red as checkout.html */
            font-weight: bold;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .book-details {
                flex: 1 1 100%;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>BookStack - Checked Out Books</h1>
    </header>
    <div class="navbar">
        <a href="allBooks.php" class="checkedOut">Home</a>
        <a href="LibrarianReturn.php" class="returnCheck">Check Returned Books</a>
        <a href="librarianCheckedOut.php" class="checkedOut">Checked Out Books</a>
        <a class="Return" target="_blank" title="Add in books into the db" href="AddBooks.php">Add a Book</a>
    </div>
    <?php
        define('DB_USER', 'nvu24');
        define('DB_PASS', 'nvu24');
        define('DB_NAME', 'nvu24');
        define('DB_HOST', 'localhost');

        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    ?>
    <main>
        <h2>BookStack's Checked Out Books</h2>
        
        <!-- Book Details Section -->
        <div class="book-container">
            <form method = "POST">
                <?php
                    $sql = "SELECT * FROM Rental r INNER JOIN Books b ON r.ISBN = b.ISBN";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="book-details">';
                            echo '<div><strong>Member ID:</strong> ' . $row['MemberID'] . '</div>';
                            echo '<div><strong>Book Name:</strong> ' . $row['Name'] . '</div>';
                            echo '<div><strong>Date Issued:</strong> ' . $row['RentalDate'] . '</div>';
                            echo '<div><strong>ISBN:</strong> ' . $row['ISBN'] . '</div>';
                        echo '</div>';
                    }
                ?>
            </form>
        </div>

        <?php
            mysqli_close($conn);
        ?>
    </main>
</body>
</html>
