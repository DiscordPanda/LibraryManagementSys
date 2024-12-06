<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookStack</title>
    <link rel="stylesheet" href="home.css">
</head>
<body class = "login-page">
    <div class="form-box">
        <?php
            define('DB_USER', 'nvu24');
            define('DB_PASS', 'nvu24');
            define('DB_NAME', 'nvu24');
            define('DB_HOST', 'localhost');
            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $selectedOption = $_POST['role'];
                
                switch ($selectedOption){
                    case 'Member':
                        header('Location: user.php');
                        exit;
                    case 'Librarian':
                        header('Location: librarianCheckedOut.php');
                        exit;
                    default:
                        echo "Please Select Type of User";
                }
            }
        ?>
        <form method = "POST">
            <div class = "login-title">Login as</div>
            <div class = "login-select">
                <select class = "selection" name="role" id="role">
                    <option value="" Hidden disabled selected>Sign In Options &#9660</option>
                    <option value="Member" name = "Member">Member</option>
                    <option value="Librarian" name = "Librarian" >Librarian</option>
                </select>
            </div>
            <div class="enter"><button type="submit" class="submit-button">Sign In</button></div>
        </form>
        
    </div>
    
</body>
</html>