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
<!DOCTYPE html>
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
        <a href="#">Student Feedbacks</a>
    </div>
    <div class="main-content">
        <h2>Anonymous student feedbacks</h2><br><br>
        <table style="margin-left: 12%; margin-right: 5%;" border="4px solid black" class="center">
            <tr>
                <th>Feedback</td>
                <th>Date</td>
            </tr>
            <?php
                include "connectDB.php"; // Using database connection file here

                $query = mysqli_query($dbc,"select * from feedbacks"); // fetch data from database

                while($data = mysqli_fetch_array($query)){
            ?>
            <tr>
                <td><?php echo $data['feedback']; ?></td>
                <td><?php echo $data['feedbackDate']; ?></td>
            </tr>	
            <?php
                }
            ?>
    </div>
    
</body>
</html>