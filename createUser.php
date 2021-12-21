<!DOCTYPE html>
<?php 

    require_once('connectDB.php');

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['checkLog'])){
            $fname = $_POST['firstName'];
            $lname = $_POST['lastName'];
            $email = $_POST['email'];
            $bday = $_POST['birthday'];
            $username = $_POST['username'];
            $password1 = $_POST['password1'];
            $password2 = $_POST['password2'];
            if(!empty($fname) && !empty($lname) && !empty($email) && !empty($bday) && !empty($username) && !empty($password1) && !empty($password2)){
                if(filter_var($email, FILTER_VALIDATE_EMAIL) == true && $password1 == $password2){
                    $query = "SELECT * FROM Student WHERE Username ='$username'";
                    $data = mysqli_query($dbc, $query);
                    // Checking that there is no user in the database with the same username
                    if(mysqli_num_rows($data) == 0){
                        $query = "INSERT INTO Student (Firstname, Lastname, Email, Birthday, Username, UserPassword) VALUES ('$fname', '$lname', '$email', '$bday' , '$username', '$password1')";
                        if(mysqli_query($dbc, $query)){
                            echo "<h1 style='text-align: center; color: green;'>New record created successfully!</h1><br><a href='studentPage.php' style='margin: 0 auto; display:block; text-align: center; font-size: 20px;'>Click here to Log in</a><br><br>";
                        }else{
                            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        }
                    }
                    else{
                        $msg = "<p style='color:red;'>An account already exists with this username. Please select different username.</p>";
                        $username = "";
                    }
                }
            }else{
                $msg= "<p style='color:red;'>You must enter all of the sign-up data, including the desired password twice.</p>";
            }
        }
    }

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="styles1.css" />
</head>
<body>
    <div class="headerContainer">
        <img src="user-icon.jpeg" width="300px" height="250px">
    </div>
    <div class="userInfoContainer">
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <fieldset>
                <legend id="createHeader">Create new user</legend>
                <!-- <label for="fname">First name:</label> -->
		        <input class="loginInpt" type="text" name="firstName" placeholder="Firstname...">
                <!-- <label for="lname">Last name:</label> -->
                <input class="loginInpt" type="text" name="lastName" placeholder="Lastname..."> <br><br>
                <!-- <label for="email">Email:</label> -->
                <label for="birthday" class="birthdayText">Birthday</label><br>
                <input class="loginInpt" type="email"  name="email" placeholder="Emaill...">
                <input class="loginInpt" type="date"  name="birthday"> <br><br>
                <input class="loginInpt" type="text"  name="username" placeholder="Set username...">
                <input class="loginInpt" type="password"  name="password1" placeholder="Set password..."> <br><br>
                <input class="loginInpt" type="password"  name="password2" placeholder="Type password again..."> <br><br>
                <?php echo !empty($msg)?$msg:'';?>
                <input type="submit" name="checkLog" value="Sign up" class="signUpBtn">
            </fieldset>
        </form>        
    </div>


    
</body>
</html>