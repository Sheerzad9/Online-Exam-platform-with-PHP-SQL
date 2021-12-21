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
            $sanitize = htmlspecialchars($_POST['feedback']);
            $query = "INSERT INTO feedbacks (feedback,feedbackDate) VALUES ('".$sanitize."','".$_SESSION['date']."')";
            $data = mysqli_query($dbc, $query);
            header("Location: success.php");
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
    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" class="svg-inline--fa fa-xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path></svg>
        <div class="circlePercentFail">
            <h1 class="percent"><?php echo round($_SESSION['percentage']);?>%</h1>
        </div><br><br>
        <h2>Unfortunately you didn't pass the exam <?php echo $_SESSION['firstName'];?></h2><br>
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