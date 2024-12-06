<!DOCTYPE html>
<html lang="en">
<head>
    <style>
      /* General Styles */
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f5f5f5;
    color: #333;
}

header {
    background-color: #cd6155; /* Matches AllBooks.html */
    color: white;
    padding: 20px;
    text-align: center;
    font-size: 24px;
    font-weight: bold;
    letter-spacing: 1px;
    text-transform: uppercase;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
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

main {
    padding: 30px;
    max-width: 600px;
    margin: 40px auto;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    animation: fadeIn 1s ease-in-out;
}

h2 {
    text-align: center;
    color: #cd6155; /* Matches AllBooks.html */
    margin-bottom: 20px;
    font-size: 28px;
    font-weight: bold;
}

/* Add Book Form Styles */
form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

form label {
    font-weight: bold;
    margin-bottom: 5px;
    color: #555;
}

form input, select {
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 8px;
    width: 100%;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

form input:focus, select:focus {
    border-color: #cd6155;
    outline: none;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

form button {
    background-color: #cd6155;
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: #b74545;
}

/* Animation */
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book</title>
   
</head>
<body>
    <header>
        <h1>BookStack - Add New Book</h1>
    </header>
    <div class="navbar">
        <a href="allBooks.php" class="checkedOut">Home</a>
        <a href="LibrarianReturn.php" class="returnCheck">Check Returned Books</a>
        <a href="librarianCheckedOut.php" class="checkedOut">Checked Out Books</a>
        <a class="Return" target="_blank" title="Add in books into the db" href="AddBooks.php">Add a Book</a>
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
                $bookName = $_POST['bookName'];
                $genre = $_POST['genre'];
                $author = $_POST['author'];
                $quan = $_POST['quantity'];
                $price = $_POST['bookPrice'];
                $libID = $_POST['library-id'];

                $sql = "INSERT IGNORE INTO Author(Name) VALUES (?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $author);
                $stmt->execute();

                

                $sql = "INSERT INTO Books(ISBN, Genre, Name, Price, Quantity) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("issdi", $isbn, $genre, $bookName, $price, $quan);
                $stmt->execute();

                $sql = "INSERT INTO BookAuthor (ISBN, AuthorID)
                        SELECT 
                            (SELECT ISBN FROM Books WHERE ISBN = ?),
                            (SELECT AuthorID FROM Author WHERE Name = ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("is", $isbn, $author);
                $stmt->execute();

                $sql = "INSERT INTO Stores(ISBN, LibraryID) VALUES (?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("is", $isbn, $libID);
                $stmt->execute();

                echo "<script>window.location.href = 'https://codd.cs.gsu.edu/~nvu24/AddBooks.php'; </script>";
                
                mysqli_close($conn);
            }

        ?>
        <h2>Add Book</h2>
        <form method="POST" action = "https://codd.cs.gsu.edu/~nvu24/AddBooks.php">
            <label for="isbn">ISBN</label>
            <input type="text" id="isbn" name="isbn" required>

            <label for="bookName">Book's Name</label>
            <input type="text" id="bookName" name="bookName" required>

            <label for="genre">Genre</label>
            <input type="text" id="genre" name="genre" required>

            <label for="author">Author's Name</label>
            <input type="text" id="author" name="author" required>

            <label for="quantity">Quantity</label>
            <input type="number" id="quantity" name="quantity" required>

            <label for="bookPrice">Book's Price</label>
            <input type="text" id="bookPrice" name="bookPrice" required>

            <label for="library-id">Library ID</label>

            <select id="library-id" name="library-id">
                <option value="" disabled selected>Select a library</option>
                <?php
                    $sql = "SELECT DISTINCT LibraryID, BranchName FROM Library";
                    $result = mysqli_query($conn, $sql);

                    $libraries = [];
                    while ($row = mysqli_fetch_assoc($result)){
                        $libraries[] = $row;
                    }

                    foreach($libraries as $library){
                        echo '<option value=' . $library['LibraryID'] . '>' . $library['BranchName'] . '</option>';
                    }
                ?>
            </select>
            <button type="submit">Add Book</button>
        </form>
    </main>

    
</body>
</html>
