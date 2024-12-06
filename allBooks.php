<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management - All Books</title>
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
            max-width: 1200px;
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

        /* Book Table Section */
        .book-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 20px;
        }

        .book-details {
            display: grid;
            grid-template-columns: repeat(6, 1fr); /* 6 columns for the details */
            gap: 20px;
            background: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .book-details:hover {
            transform: translateY(-5px);
            box-shadow: 0px 6px 16px rgba(0, 0, 0, 0.2);
        }

        .book-details div {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            line-height: 1.5;
            color: #555;
        }

        .book-details div span {
            display: block;
            font-size: 12px;
            font-weight: normal;
            color: #777;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .book-details {
                grid-template-columns: repeat(2, 1fr); /* Stack details into 2 columns */
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
    <header>
        <h1>Library Management - All Books</h1>
    </header>
    <div class="navbar">
        <a href="allBooks.php" class="checkedOut">Home</a>
        <a href="LibrarianReturn.php" class="returnCheck">Check Returned Books</a>
        <a href="librarianCheckedOut.php" class="checkedOut">Checked Out Books</a>
        <a class="Return" target="_blank" title="Add in books into the db" href="AddBooks.php">Add a Book</a>
    </div>
    <main>
        <h2>All Books in Total</h2>
        
        <!-- Book Details Section -->
        <div class="book-container">
            <?php
                $sql = "SELECT * FROM Books ORDER BY BookID ASC";
                $result = mysqli_query($conn, $sql);

                //TODO: Change LIB101 and Main Branch
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="book-details">';
                    echo '<div>Book ID<span>' . $row['BookID'] . '</span></div>';
                    echo '<div>ISBN<span>' . $row['ISBN'] . '</span></div>';
                    echo '<div>Name<span>' . $row['Name'] . '</span></div>';
                    echo '<div>Quantity<span>' . $row['Quantity'] . '</span></div>';
                    echo '<div>Library ID<span>' . 'LIB101' . '</span></div>';
                    echo '<div>Branch Name<span>' . 'Main Branch' . '</span></div>';
                    echo '</div>';
                }

            ?>
        </div>
    </main>
</body>
</html>
