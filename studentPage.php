<!DOCTYPE html>
<?php
    session_start();

    if(!isset($_SESSION['username'])){
        header("Location: Login.php");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){   
        if(isset($_POST['logOut'])){
            echo "Logged out!";
            session_destroy();
            $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/Login.php';
            header('Location: ' . $home_url);
        }if(isset($_POST['takeExam'])){
            require('connectDB.php');
            $query = "SELECT * FROM exam WHERE studentID = '".$_SESSION['studentID']."'";
            $data = mysqli_query($dbc, $query);
            if(mysqli_num_rows($data) == 1){
                $row=mysqli_fetch_array($data);
                $_SESSION['examDate'] = $row['examDate'];
                $_SESSION['examResult'] = $row['examResult'];
                header('Location: examTaken.php');
            }else{
                header('Location: examStart.php' );
            }
        }
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles1.css" />
    <title>Document</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <div class="topnav" >
        <input class="logoutBtn" type="submit" name="logOut" value="Log out">
    </div>
    <div class="examInfo">
        <h1>Math exam for nurse students</h1>
        <h2>Welcome <?php echo $_SESSION['firstName'];?> </h2><br>
        <p>Please read carefully the following instructions before taking the exam.</p><br><br>
        <div class="examList">
            <ul>
                <li>You have 60min time to complete the exam</li><br>
                <li>The maximum amount of points is 60</li><br>
                <li>To pass this exam you need to get atleast 80% (48pts) of the questions correct</li><br>
                <li>If you exceed the time limit, exam will be submitted automatically</li><br>
            </ul><br><br>
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <input type="submit" name="takeExam" value="Take the exam" class="signUpBtn">
        </div>

    </div>
    
</body>
</html>