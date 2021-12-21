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
    </div>
    </form>
    <div class="successContent" style="text-align: center;">
        <div class="success-icon">
        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="circle-check" class="svg-inline--fa fa-circle-check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M335 175L224 286.1L176.1 239c-9.375-9.375-24.56-9.375-33.94 0s-9.375 24.56 0 33.94l64 64C211.7 341.7 217.8 344 224 344s12.28-2.344 16.97-7.031l128-128c9.375-9.375 9.375-24.56 0-33.94S344.4 165.7 335 175zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464z"></path></svg><br><br>
        </div>
        <div>
            <h2>Your feedback has been sent successfully!</h2><br><br>
            <a href="studentPage.php" style="font-size: 20px;">Click here to get back to homepage</a><br><br>
        </div>
    </div>
</body>
</html>