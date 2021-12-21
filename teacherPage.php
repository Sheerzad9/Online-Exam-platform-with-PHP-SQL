<!DOCTYPE html>
<?php 
    session_start();

    if(!isset($_SESSION['username'])){
        header("Location: Login.php");
    }else{
        echo "Teacher's page";
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){   
        if(isset($_POST['logOut'])){
            echo "Logged out!";
            session_destroy();

            $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/Login.php';
            header('Location: ' . $home_url);
        }
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles1.css" />
    <script defer src="main.js"></script>
    <title>Document</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <div class="topnav">
        <input class="logoutBtn" type="submit" name="logOut" value="Log out">
    </div>
    </form>
    <div class="sidenav">
        <a href="viewStudents.php">Students</a>
        <a href="viewSubmittedExams.php">Submitted Exams</a>
        <a href="viewStudentFeedbacks.php">Student Feedbacks</a>
    </div>
    <div style="text-align: center;">
    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chalkboard-user" class="svg-inline--fa fa-chalkboard-user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M592 0h-384C181.5 0 160 22.25 160 49.63V96c23.42 0 45.1 6.781 63.1 17.81V64h352v288h-64V304c0-8.838-7.164-16-16-16h-96c-8.836 0-16 7.162-16 16V352H287.3c22.07 16.48 39.54 38.5 50.76 64h253.9C618.5 416 640 393.8 640 366.4V49.63C640 22.25 618.5 0 592 0zM160 320c53.02 0 96-42.98 96-96c0-53.02-42.98-96-96-96C106.1 128 64 170.1 64 224C64 277 106.1 320 160 320zM192 352H128c-70.69 0-128 57.31-128 128c0 17.67 14.33 32 32 32h256c17.67 0 32-14.33 32-32C320 409.3 262.7 352 192 352z"></path></svg><br><br><br>
        <h1 style="font-style: italic;">Welcome back <?php echo $_SESSION['teacherfn'];?>!</h1>
    </div>
</body>
</html>