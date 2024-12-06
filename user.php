<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link rel="stylesheet" href="styles.css">
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
            <h1>Library Management System</h1>
    </header>
    <div class="navbar"> 
        <!-- TODO: Link these Navigation items to another page -->
        <a class = "home" target="_self" title = "Go back to the homepage" href="user.php"> Home </a>
        <a class="checkout" target="_self" title="Proceed to the checkout page" href="checkout.php">Checkout</a>
        <a class="Return" target="_self" title="Proceed to the return page" href="return.php">Return</a>
        <a class="Event" target="_self" title="Proceed to the event form page" href="eventForm.php">Book an Event with us!</a>
    </div> 
    <div class="main-container">
    <!--Side Bar (Left Side)-->
        <div class="left-sidebar">
            <div class="search-filter">
                <form method = "POST">
                    <input type="text" placeholder="Search for books..." class="search-input" name = "searchQuery" id = "search_query">
                    <button class="search-btn">Search</button>
                    <button class="filter-btn">Filter</button>
                </form>
                <!-- TODO: Search Functionality. This code is commented out
                <?php
                    $searchQuery = $_POST['searchQuery'];
                    $sql = "SELECT * FROM Books WHERE 'Name' LIKE '%".$searchQuery."%'";
                    $result = mysqli_query($conn, $sql);

                    if(mysqli_num_rows($result) > 0){
                        $books = [];
                        while ($row = mysqli_fetch_assoc($result)){
                            $books[] = $row;
                        }

                        foreach($books as $book){
                            echo '<div class="book">';
                            echo '<div class="book-info">';
                            echo '<h3>' . $book['Name'] . '</h3>';
                            echo '<p>Author: ' . $book['Author'] . '</p>';
                            echo '<p>Genre: ' . $book['Genre'] . '</p>';
                            echo '</div>';
                            echo '<a href="checkout.php?isbn=' . urlencode($book['ISBN']) . '&author=' . urlencode($book['Author']) . '&genre=' . urlencode($book['Genre']) . '"><button>Borrow</button></a>';
                            echo '</div>';
                        }
                    }
                    else{
                        echo "No results found.";
                    }
                ?> -->
            </div>
            
            <div class="books-container">
                
                <?php # PHP to list out the books and its information to the user
                    if (isset($_POST['searchQuery'])) {
                        $searchQuery = '%' . $_POST['searchQuery'] . '%';
                        $sql = "SELECT b.ISBN as ISBN, b.Name as Name, a.Name as Author, b.Genre as Genre
                                FROM Books b
                                INNER JOIN BookAuthor ba ON b.ISBN = ba.ISBN
                                INNER JOIN Author a ON ba.AuthorID = a.AuthorID
                                WHERE b.Name LIKE ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $searchQuery);  // Bind user input to placeholder
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if(mysqli_num_rows($result) > 0){
                            $books = [];
                            while ($row = mysqli_fetch_assoc($result)){
                                $books[] = $row;
                            }

                            foreach($books as $book){
                                echo '<div class="book">';
                                echo '<div class="book-info">';
                                echo '<h3>' . $book['Name'] . '</h3>';
                                echo '<p>Author: ' . $book['Author'] . '</p>';
                                echo '<p>Genre: ' . $book['Genre'] . '</p>';
                                echo '</div>';
                                echo '<a href="checkout.php?isbn=' . urlencode($book['ISBN']) . '&author=' . urlencode($book['Author']) . '&genre=' . urlencode($book['Genre']) . '"><button>Borrow</button></a>';
                                echo '</div>';
                            }
                        }
                        // else{
                        //     echo "No results found.";
                        // }
                    }
                    else{
                        $sql = "SELECT b.ISBN as ISBN, b.Name as 'Name', a.Name as Author, b.Genre as Genre FROM Books b INNER JOIN BookAuthor ba ON b.ISBN = ba.ISBN INNER JOIN Author a ON ba.AuthorID = a.AuthorID";
                        $result = mysqli_query($conn, $sql);
                        
                        $books = [];
                        while ($row = mysqli_fetch_assoc($result)){
                            $books[] = $row;
                        }

                        foreach($books as $book){
                            echo '<div class="book">';
                            echo '<div class="book-info">';
                            echo '<h3>' . $book['Name'] . '</h3>';
                            echo '<p>Author: ' . $book['Author'] . '</p>';
                            echo '<p>Genre: ' . $book['Genre'] . '</p>';
                            echo '</div>';
                            echo '<a href="checkout.php?isbn=' . urlencode($book['ISBN']) . '&author=' . urlencode($book['Author']) . '&genre=' . urlencode($book['Genre']) . '"><button>Borrow</button></a>';
                            echo '</div>';
                        }
                    }
                ?>
            </div>
        </div>
        


        <!-- Right Sidebar -->
        <div class="right-sidebar">
            <!-- Book of the Month -->
            <div class="bookofthemonth-container">
                <h2>Book of the Month</h2>
                <div class="bookofthemonth">
                    <h3>Inspiring Book</h3>
                    <p>Author: Famous Author</p>
                    <p>Genre: Motivational</p>
                    <p>Publication Year: 2023</p>
                </div>
            </div>
            <!-- Events -->
            <div class="event-container">
                <h2>Events</h2>
                <?php # PHP to list all the events on the db
                    $sql = "SELECT eventName,eventDate, eventTime, eventDescription FROM event";
                    $res = mysqli_query($conn, $sql);

                    $events = [];
                    while ($row = mysqli_fetch_assoc($res)){
                        $events[] = $row;
                    }

                    foreach ($events as $event){
                        echo '<a class="events"> <b style="font-size: 25px;">' . $event['eventName'] . '</b><br><br><b>Event Date: </b>' .$event['eventDate'] . '<br><b>Event Time: </b>' .$event['eventTime'] . '<br><b>Event Description: </b>' .$event['eventDescription'] .'</a>';
                    }

                    mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>
    <script src="popup.js"></script>
</body>
</html>
