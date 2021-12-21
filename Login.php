<!DOCTYPE html>

<!-- PHP Code. This section of the file contains the DB connecting and data validation  -->
<?php 
    session_start();

    require_once('connectDB.php');


	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{   
        // Going inside this block if "Log in" button is clicked
        if(isset($_POST['checkCredentials'])){
            $username = $_POST['usernameLog'];
            $password = $_POST['passwordLog'];
            // Checking that submitted inputs are only letters, if so go inside block. preg_match() function enables utf-8 letters
            if( $username && $password){

                // Checking if user inputs are from student Table
                $query = "SELECT * FROM student WHERE Username = '$username' AND UserPassword = '$password'";
                $data = mysqli_query($dbc, $query);
                if(mysqli_num_rows($data) == 1){
                    $row = mysqli_fetch_array($data);
                    $_SESSION['studentID'] = $row['userID'];
                    $_SESSION['username'] = $username;
                    $_SESSION['firstName'] = $row['FirstName'];
                    $_SESSION['fullname'] = $row['LastName'] ." " .$_SESSION['firstName'];
                    header("Location: studentPage.php");
                    // if($row['Role'] == 'Student'){
                    //     exit();
                    // }
                    // if($row['Role'] == "Teacher"){
                    //     header("Location: teacherPage.php");
                    //     exit();
                    // }
                }

                //Checking if user inputs are from teacher Table
                $query = "SELECT * FROM teacher WHERE Username = '$username' AND UserPwd = '$password'";
                $data = mysqli_query($dbc, $query);
                if(mysqli_num_rows($data) == 1){
                    $row = mysqli_fetch_array($data);
                    $_SESSION['teacherfn'] = $row['FirstName'];
                    $_SESSION['username'] = $username;
                    header("Location: teacherPage.php");
                }

                else{
                    $msg = '<p style="color: red;">Sorry, the username/password you entered is not correct. Try again!</p><br>';
                }
            }
            else{
                $msg = '<p style="color: red;">Sorry, you must enter your username and password to log in. Try again!</p><br>';
        }
    }

    }
?>

<!-- HTML FORM. This section of the file defines the HTML form -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="styles1.css" />
    <script defer src="main.js"></script>
</head>
<body>
    <div class="logInContainer">
        <h2 class="welcomeText">Welcome, please log in to your account to continue</h2>
        <!-- In a self-processing form, the action URL points to this same file, i.e $_SERVER['PHP_SELF'] -->
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        Enter Username
        <br>
        <input class="loginInpt" type="text" name="usernameLog">
        <br><br>
        Enter Password
        <br>
        <input class="loginInpt" type="password" name="passwordLog">
        <br><br>
        <input  class="subBtn" type="submit" name="checkCredentials" value="Log in">
        </form>
        <br><br>
        <?php echo !empty($msg)?$msg:'';?>
        <p><a href="createUser.php">Click here to create account</p>
        <br><br>
    </div>
    
</body>
</html>