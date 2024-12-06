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
  
  form input {
      padding: 10px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 8px;
      width: 100%;
      box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
  }
  
  form input:focus {
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
    <title>BookStack - Return Book</title>
    <link rel="stylesheet" href="AddBook.css"> <!-- Reuse the AddBook.css -->
</head>
<body>
    <header>
        <h1>BookStack - Return Book</h1>
    </header>
    <div class="navbar">
        <a href="allBooks.php" class="checkedOut">Home</a>
        <a href="LibrarianReturn.php" class="returnCheck">Check Returned Books</a>
        <a href="librarianCheckedOut.php" class="checkedOut">Checked Out Books</a>
        <a class="Return" target="_blank" title="Add in books into the db" href="AddBooks.php">Add a Book</a>
    </div>
    <main>
        <h2>Return Book Acceptance </h2>
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
               $memberID = $_POST['member-id'];
               $bookName = $_POST['book-name'];
               $dateReturned = $_POST['date-returned'];
               $isbn = $_POST['isbn'];

            //    TODO: Rental or Access
               $del = "DELETE FROM Rental WHERE $isbn = ISBN AND $memberID = MemberID";
               if ($conn->query($del) === TRUE) {
                   echo "<script>alert('Returned book successfully!');</script>";
               } else {
                   $error = $conn->error;
                   echo "<script>alert('Error: $error');</script>";
               }

               echo "<script>window.location.href = 'https://codd.cs.gsu.edu/~nvu24/allBooks.php'; </script>";

               mysqli_close($conn);
           }
        ?>
        
        <form method="POST"> <!-- Form submission to backend -->
            <label for="member-id">Member ID</label>
            <input type="text" id="member-id" name="member_id" placeholder="Enter Member ID" required>

            <label for="book-name">Name of Book</label>
            <input type="text" id="book-name" name="book_name" placeholder="Enter Name of Book" required>

            <label for="date-returned">Date Returned</label>
            <input type="date" id="date-returned" name="date_returned" required>

            <label for="isbn">ISBN</label>
            <input type="text" id="isbn" name="isbn" placeholder="Enter ISBN" required>

            <button type="submit">Accept</button>
        </form>
    </main>
</body>
</html>
