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
    }if(isset($_POST['subFeedback'])){
        if(!empty($_POST['feedback']) && (int)$_POST['feedback'] == false){
            require('connectDB.php');
            echo "check success";
            $sanitize = htmlspecialchars($_POST['feedback']);
            $query = "INSERT INTO feedbacks (feedback,feedbackDate) VALUES ('".$sanitize."','".$_SESSION['date']."')";
            $data = mysqli_query($dbc, $query);
            header("Location: success.php");
        }if(empty($_POST['feedback'])){
            $msg = '<p style="color: red;">Please check your input!</p><br>';
        }else{$msg = '<p style="color: red;">Please check your input!</p><br>';}
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
    <title>Document</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <div class="topnav" >
        <input class="logoutBtn" type="submit" name="logOut" value="Log out">
    </div><br><br>

    <div class="resultContainer">
        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="medal" class="svg-inline--fa fa-medal" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M223.7 130.8L149.1 7.77C147.1 2.949 141.9 0 136.3 0H16.03c-12.95 0-20.53 14.58-13.1 25.18l111.3 158.9C143.9 156.4 181.7 137.3 223.7 130.8zM256 160c-97.25 0-176 78.75-176 176S158.8 512 256 512s176-78.75 176-176S353.3 160 256 160zM348.5 317.3l-37.88 37l8.875 52.25c1.625 9.25-8.25 16.5-16.63 12l-46.88-24.62L209.1 418.5c-8.375 4.5-18.25-2.75-16.63-12l8.875-52.25l-37.88-37C156.6 310.6 160.5 299 169.9 297.6l52.38-7.625L245.7 242.5c2-4.25 6.125-6.375 10.25-6.375S264.2 238.3 266.2 242.5l23.5 47.5l52.38 7.625C351.6 299 355.4 310.6 348.5 317.3zM495.1 0H375.7c-5.621 0-10.83 2.949-13.72 7.77l-73.76 122.1c42 6.5 79.88 25.62 109.5 53.38l111.3-158.9C516.5 14.58 508.9 0 495.1 0z"></path></svg><br>
        <div class="circlePercentPass">
            <h1 class="percent"><?php echo round($_SESSION['percentage']);?>%</h1>
        </div><br><br>
        <h2>Congratulations <?php echo $_SESSION['firstName'];?>! <br> You passed the exam</h2><br>
        <div class="resultInner">
            <h3>You got <?php echo $_SESSION['points'];?> / 60 right</h3><br><br>
            <a href="studentPage.php" style="font-size: 20px;">Click here to get back to homepage</a><br><br>
            <h2>Please feel free to leave a feedback to teacher</h2><br>
            <p>The feedback will be submitted anonymously.<br>Please keep the feedback under 250 word.</p><br>
            <textarea class="feedbackBox" name="feedback" maxlength="250">
            </textarea><br><?php echo !empty($msg)?$msg:'';?><br>
            <input class="submitFeedback" type="submit" name="subFeedback" value="Submit">
        </div>
    </div>
</body>
</html>