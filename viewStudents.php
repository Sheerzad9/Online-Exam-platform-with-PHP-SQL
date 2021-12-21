<?php 
    session_start();

    if(!isset($_SESSION['username'])){
        header("Location: Login.php");
    }else{
        echo "Teacher's page";
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){  
        // if user click on "log out" 
        if(isset($_POST['logOut'])){
            session_destroy();
            $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/Login.php';
            header('Location: ' . $home_url);
        }if(isset($_POST['removeStudent'])){
            include "connectDB.php";
            // Deleting from submittedExam table
            $query = "DELETE FROM exam WHERE studentID ='".$_POST['removeStudent']."'";
            mysqli_query($dbc, $query);
            // Deleting from student table
            $query = "DELETE FROM student WHERE userID ='".$_POST['removeStudent']."'";
            mysqli_query($dbc, $query);
        }if(isset($_POST['addUser'])){
                $fname = $_POST['firstName'];
                $lname = $_POST['lastName'];
                $email = $_POST['email'];
                $bday = $_POST['birthday'];
                $username = $_POST['username'];
                $password1 = $_POST['password1'];
                $password2 = $_POST['password2'];
                if(!empty($fname) && !empty($lname) && !empty($email) && !empty($bday) && !empty($username) && !empty($password1) && !empty($password2)){
                    if(filter_var($email, FILTER_VALIDATE_EMAIL) == true && $password1 == $password2){
                        require_once('connectDB.php');
                        $query = "SELECT * FROM student WHERE Username ='$username'";
                        $data = mysqli_query($dbc, $query);
                        // Checking that there is no user in the database with the same username
                        if(mysqli_num_rows($data) == 0){
                            $query = "INSERT INTO Student (Firstname, Lastname, Email, Birthday, Username, UserPassword) VALUES ('$fname', '$lname', '$email', '$bday' , '$username', '$password1')";
                            if(mysqli_query($dbc, $query)){
                                $msg=  "<p style='color: green;'>New record created successfully!</p>";
                            }else{
                                echo "<alert style='color: red;'>Error: " .$sql ."<br>" .mysqli_error($conn) ."</alert>";
                            }
                        }
                        else{
                            $msg= "<script>alert('An account already exists for this username. Please use a different address.´)</script>";
                            $username = "";
                        }
                    }
                }else{
                    echo "<script>alert('You must enter all of the sign-up data, including the desired password twice.')</script>";
                }
            
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
    <div class="modal">
        <div class="modal-content">
            <span class="close-modal-Btn">X</span><br><br><br><br>
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus" class="svg-inline--fa fa-user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3C0 496.5 15.52 512 34.66 512h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM616 200h-48v-48C568 138.8 557.3 128 544 128s-24 10.75-24 24v48h-48C458.8 200 448 210.8 448 224s10.75 24 24 24h48v48C520 309.3 530.8 320 544 320s24-10.75 24-24v-48h48C629.3 248 640 237.3 640 224S629.3 200 616 200z"></path></svg><br><br>
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
                <input type="submit" name="addUser" value="Add user" class="add-user-btn">
            </fieldset>
        </div>
    </div>
    </form>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <div class="topnav">
        <input class="logoutBtn" type="submit" name="logOut" value="Log out">
    </div>
    </form>
    <div class="sidenav">
        <a href="#">Students</a>
        <a href="viewSubmittedExams.php">Submitted Exams</a>
        <a href="viewStudentFeedbacks.php">Student Feedbacks</a>
    </div>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <div class="main-content">
        <h2>Student Details</h2><br><br>
        <button class="addStudentBtn">Add new student</button><br><br>
        <?php echo !empty($msg)?$msg:'';?>
        <table border="4px solid black" class="center">
            <tr>
                <th>Student.ID</th>
                <th>Surname</th>
                <th>Given name</th>
                <th>Email</th>
                <th>Exam status</th>
                <th>Remove student</th>
            </tr>
            <?php
                include "connectDB.php"; // Using database connection file here

                $query = mysqli_query($dbc,"select * from student"); // fetch data from database

                while($data = mysqli_fetch_array($query)){
            ?>
            <tr>
                <td><?php echo $data['userID']; ?></td>
                <td><?php echo $data['LastName']; ?></td>
                <td><?php echo $data['FirstName']; ?></td>
                <td><?php echo $data['Email']; ?></td>
                <td><?php echo $data['Exam']; ?></td>
                <td>
                    <input type="hidden" name="remove_id" value="<?php echo $data['userID'];?>">
                    <button type="submit" name="removeStudent" class="removeBtn" value="<?php echo $data['userID'];?>">Remove</button>
                </td>
            </tr>	
            <?php
                }
            ?>
        </table>
    </div>
    </form>
    <script>
        const addBtn = document.querySelector(".addStudentBtn");
        const modal1 = document.querySelector(".modal");
        const closemodal1 = document.querySelector(".close-modal-Btn");

        addBtn.addEventListener("click", function (e) {
            e.preventDefault();
            modal1.style.display = "block";
        });

        closemodal1.addEventListener("click", function (e) {
            e.preventDefault();
            modal1.style.display = "none";
        });
    </script>
</body>
</html>