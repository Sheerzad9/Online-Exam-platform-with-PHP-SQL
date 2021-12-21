<?php 
    session_start();

    if(!isset($_SESSION['username'])){
        header("Location: Login.php");
    }else{
        echo "Teacher's page";
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){   
        if(isset($_POST['logOut'])){
            session_destroy();
            $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/Login.php';
            header('Location: ' . $home_url);
        }if(isset($_POST['reset'])){
            // echo "<p style='margin-left: 25%;'>Inside button</p>";
            include "connectDB.php";
            // Deleting from submittedExam table
            $query = "UPDATE student SET Exam ='Not yet graded' WHERE userID ='".$_POST['reset']."'";
            mysqli_query($dbc, $query);
            // Deleting from student table
            $query = "DELETE FROM exam WHERE studentID ='".$_POST['reset']."'";
            mysqli_query($dbc, $query);
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
    <div class="sidenav">
        <a href="viewStudents.php">Students</a>
        <a href="#">Submitted Exams</a>
        <a href="viewStudentFeedbacks.php">Student Feedbacks</a>
    </div>
    <div class="main-content">
        <h2>Submitted Exams</h2><br>
        Notice! by resetting submitted exam, it will dissapear from this list.<br>Giving students another chance to take the exam.<br><br>
        <table border="4px solid black" class="center">
            <tr>
                <th>Student ID</th>
                <th>Student fullname</th>
                <th>Exam points</th>
                <th>Exam status</th>
                <th>Exam date</th>
                <th>Reset exam</th>
            </tr>
            <?php
                include "connectDB.php"; // Using database connection file here

                $query = mysqli_query($dbc,"select * from exam"); // fetch data from database

                while($data = mysqli_fetch_array($query)){
            ?>
            <tr>
                <td><?php echo $data['studentID']; ?></td>
                <td><?php echo $data['studentName']; ?></td>
                <td><?php echo $data['examPoints']; ?></td>
                <td><?php echo $data['examResult']; ?></td>
                <td><?php echo $data['examDate']; ?></td>
                <td>
                    <button type="submit" name="reset" class="resetBtn" value="<?php echo $data['studentID'];?>">Reset</button>
                </td>
            </tr>	
            <?php
                }
            ?>
        </table>
    </div>
    </form>
    
</body>
</html>