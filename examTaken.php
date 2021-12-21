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
    <div style="text-align: center">
    <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="face-grin-beam-sweat" class="svg-inline--fa fa-face-grin-beam-sweat" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 400c51.95 0 115.3-32.88 123.3-80c1.695-9.875-7.629-18.5-17.68-15.25C335.7 313 297.2 317.8 256 317.8S176.4 313 150.4 304.8C140.6 301.6 131 310 132.7 320C140.7 367.1 204.1 400 256 400zM176 189.3c12.35 0 23.86 7.875 31.48 21.62l9.566 17C219.1 231.7 223.2 232.8 226.3 231.8c3.512-1.125 5.934-4.5 5.691-8.375C228.8 181.3 199.8 152 175.1 152c-23.73 0-52.54 29.25-55.81 71.38C119.8 227.1 122.1 230.6 125.7 231.8c3.512 1 7.459-.575 9.397-3.825l9.445-17C152.3 197.2 163.8 189.3 176 189.3zM391.1 223.4c-3.27-42.13-32.22-71.37-55.96-71.37c-23.86 0-52.64 29.25-55.91 71.37c-.2422 3.75 2.034 7.25 5.546 8.375c3.512 1 7.459-.575 9.397-3.825l9.494-17c7.629-13.75 19.13-21.62 31.48-21.62c12.23 0 23.81 7.875 31.56 21.62l9.446 17c2.18 3.625 6.103 4.7 9.252 3.825C389.9 230.6 392.4 227.3 391.1 223.4zM456 176c-2.857 0-5.557-.5547-8.346-.8125C458.2 200 464 227.4 464 256c0 114.7-93.31 208-208 208S48 370.7 48 256S141.3 48 256 48c41.9 0 80.88 12.56 113.6 33.96c1.953-12.64 7.857-27.72 17.9-45.33C348.1 13.53 304.1 .0002 256 .0002C114.6 .0002 0 114.6 0 256s114.6 255.1 256 255.1S512 397.4 512 256c0-31.53-5.975-61.6-16.4-89.49C483.6 172.4 470.3 176 456 176zM456 144C486.9 144 512 120.4 512 91.14c0-22.5-33.31-67.91-48.54-87.45c-3.732-4.922-11.2-4.922-14.93 0C433.2 23.23 400 68.64 400 91.14C400 120.4 425.1 144 456 144z"></path></svg><br><br>
    <h2>Hey <?php echo $_SESSION['firstName'];?>!.......</h2><br>
    <h3>It seems like you have already taken this exam in <?php echo $_SESSION['examDate'];?><br> Your result was: <?php echo $_SESSION['examResult'];?></h3><br><br>
    <a href="studentPage.php" style="font-size: 20px;">Click here to get back to homepage</a><br><br>
    </div>
    </form>
</body>
</html>