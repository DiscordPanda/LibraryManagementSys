<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return</title>
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
        <h1>BookStack - Return</h1>
    </header>

    <div class="navbar"> 
        <!-- TODO: Link these Navigation items to another page -->
        <a class = "home" target="_self" title = "Go back to the homepage" href="user.php"> Home </a>
        <a class="checkout" target="_self" title="Proceed to the checkout page" href="checkout.php">Checkout</a>
        <a class="Return" target="_self" title="Proceed to the return page" href="return.php">Return</a>
        <a class="Event" target="_self" title="Proceed to the event form page" href="eventForm.php">Book an Event with us!</a>
    </div> 

    <main>
        <section class="form-container">
            <h2>Return Book</h2>

            

            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $isbn = $_POST['isbn'];
                    $memberId = $_POST['member-id'];
                    $libraryId = $_POST['library-id'];
                
                    $sql = "SELECT RentalID, RentalDate FROM Rental WHERE ISBN = ? AND MemberID = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ss", $isbn, $memberId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $rentalId = $row['RentalID'];
                        $rentalDate = $row['RentalDate'];
                
                        $insertSql = "INSERT INTO ReturnCheck (RentalID, ISBN, MemberID, LibraryID, RentalDate, ReturnDate)
                                    VALUES (?, ?, ?, ?, ?, CURDATE())";
                        $insertStmt = $conn->prepare($insertSql);
                        $insertStmt->bind_param("sssss", $rentalId, $isbn, $memberId, $libraryId, $rentalDate);
                
                        if ($insertStmt->execute()) {
                            echo "<script>alert('Sent book to Librarian successfully!');</script>";
                        } else {
                            $error = $insertStmt->error;
                            echo "<script>alert('Error: $error');</script>";
                        }
                    } else {
                        echo "<script>alert('Rental not found.');</script>";
                    }
                    echo "<script>window.location.href = 'https://codd.cs.gsu.edu/~nvu24/user.php'; </script>";
                
                    $stmt->close();
                    $insertStmt->close();
                    $conn->close();
                }
            ?>

            <form method="POST">
                <label for="isbn">Select Book (ISBN):</label>
                <select id="isbn" name="isbn">
                    <option value="" disabled selected>Select a book</option>
                    <?php
                        $sql = "SELECT DISTINCT ISBN FROM Rental EXCEPT SELECT ISBN FROM ReturnCheck";
                        $result = mysqli_query($conn, $sql);

                        $books = [];
                        while ($row = mysqli_fetch_assoc($result)){
                            $books[] = $row;
                        }

                        foreach($books as $book){
                            echo '<option value=' . $book['ISBN'] . '>' . $book['ISBN'] . '</option>';
                        }
                    ?>
                </select>

              
                <label for="member-id">Member ID:</label>
                <select id="member-id" name="member-id">
                    <option value="" disabled selected>Select a member</option>
                    <?php
                        $sql = "SELECT DISTINCT MemberID FROM Rental";
                        $result = mysqli_query($conn, $sql);

                        $members = [];
                        while ($row = mysqli_fetch_assoc($result)){
                            $members[] = $row;
                        }

                        foreach($members as $member){
                            echo '<option value=' . $member['MemberID'] . '>' . $member['MemberID'] . '</option>';
                        }
                    ?>
                </select>

                <label for="library-id">Library ID:</label>
                <select id="library-id" name="library-id">
                    <option value="" disabled selected>Select a library</option>
                    <?php
                        $sql = "SELECT DISTINCT BranchName FROM Rental INNER JOIN Library ON Rental.LibraryID = Library.LibraryID";
                        $result = mysqli_query($conn, $sql);

                        $libraries = [];
                        while ($row = mysqli_fetch_assoc($result)){
                            $libraries[] = $row;
                        }

                        foreach($libraries as $library){
                            echo '<option value=' . $library['BranchName'] . '>' . $library['BranchName'] . '</option>';
                        }
                    ?>
                </select>
                <button type="submit">Submit Return</button>
            </form>


        </section>
    </main>
</body>
</html>
