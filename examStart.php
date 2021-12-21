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

    if(isset($_POST['submitExam'])){
        require('connectDB.php');
        $points = 0;
        $arr = array();
        $j = 0;
        // Pushing user inputs to array
        for($i = 1; $i <= 60; ++$i){
            $_POST['answer'.$i] = preg_replace('/\s+/', '', $_POST['answer'.$i]);
            $arr[$j++] = $_POST['answer'.$i]; 
        }
        $query = "SELECT * FROM examqa";
        $data = mysqli_query($dbc, $query);
        $j = 0;
        // Going thru DB "Answer" table and comparing it to user inputs array
        while($row=mysqli_fetch_array($data))
        {
            print "<pre>";
            print_r($row['Answer']);
            print"</pre>";
            // if correct, give +1 point 
            if($arr[$j] == $row['Answer']){
                $points++;
                $j++;
            }else{
                $j++;
            }
        };
        // Setting the points and percentage as session variable
        $_SESSION['points'] = $points;
        $_SESSION['percentage'] = ($points / 60) * 100;
        // if student passes exam, go inside this next block
        if($_SESSION['points'] >= 3){
            // Update student table
            $query = "UPDATE student SET Exam = 'Pass' WHERE Username ='".$_SESSION['username']."'";
            $data = mysqli_query($dbc, $query);
            // update exam table
            $query = "INSERT INTO exam (examResult, examPoints, examDate, studentID, studentName) VALUES ('Pass','".$_SESSION['points']."','".$_SESSION['date']."','".$_SESSION['studentID']."','".$_SESSION['fullname']."')";
            $data = mysqli_query($dbc, $query);
            $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/examPass.php';
            header('Location: ' . $home_url);
            // if student fails go inside next if block
        }if($_SESSION['points'] < 3){
            // Update student table
            $query = "UPDATE student SET Exam = 'Fail' WHERE Username ='".$_SESSION['username']."'";
            $data = mysqli_query($dbc, $query);
            // Update exam table
            $query = "INSERT INTO exam (examResult, examPoints, examDate, studentID, studentName) VALUES ('Fail','".$_SESSION['points']."','".$_SESSION['date']."','".$_SESSION['studentID']."','".$_SESSION['fullname']."')";
            $data = mysqli_query($dbc, $query);
            $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/examFail.php';
            header('Location: ' . $home_url);
        }
        print "<pre>";
        print_r($arr);
        print"</pre>";
        echo $arr[2];
        echo gettype($arr[2]);
        echo "<br><br>";
        echo $points;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles1.css" />
    <script defer src="main.js"></script>
</head>
<body style="background-color: white;">
    <div class="examContainer">
        <div class="examContent">
            <h3>Exam started <?php 
            date_default_timezone_set("Europe/Helsinki");
            $_SESSION['date'] = date("Y/m/d");
            echo $_SESSION['date'] ."<br>At " .date("h:i a");?></h3>
            <fieldset class="examField">
                <legend style="margin:0 auto;"id="createHeader">Basic Calculations</legend><br>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                    <?php
                        $quizNum = 0;
                        include_once("renderQuestions.php");
                        // $category = "Basic";
                        renderQuestions($category="Basic", $quizNum);
                    ?>
            </fieldset>
            <fieldset class="examField">
                <legend style="margin:0 auto;"id="createHeader">Units</legend><br>
                <label class="examHeader">Change to Milligrams</label><br><br><br>
                <?php
                renderQuestions($category="to_Mg", $quizNum=10, $definition="mg");   
                ?>
                <label class="examHeader">Change to Grams</label><br><br><br>
                <?php
                    $quizNum = 14;
                    $category = "to_g";
                    $definition = "g";
                    renderQuestions($category, $quizNum, $definition); 
                ?>
                <label class="examHeader">Change to Milliliters</label><br><br><br>
                <?php
                    $quizNum = 18;
                    $category = "to_Ml";
                    $definition = "ml";
                    renderQuestions($category, $quizNum, $definition); 
                ?>
                <label class="examHeader">Change to Liters</label><br><br><br>
                <?php
                    $quizNum = 22;
                    $category = "to_L";
                    $definition = "L";
                    renderQuestions($category, $quizNum, $definition); 
                ?>
                <label class="examHeader">Change to Micrometer</label><br><br><br>
                <?php
                   $quizNum = 26;
                   $category = "to_Mm";
                   $definition = "micrometer";
                   renderQuestions($category, $quizNum, $definition); 
                ?>
                </fieldset>
                <fieldset class="examField">
                    <legend style="margin:0 auto;"id="createHeader">Percentage</legend><br>
                    <label class="examHeader">What is</label><br><br><br>
                    <?php
                        renderQuestions($category="what_is", $quizNum=30); 
                    ?>
                    <label class="examHeader">Find the percentage</label><br><br><br>
                    <?php
                        renderQuestions($category="find_percent", $quizNum=37, $definition ="%"); 
                    ?>
                </fieldset>
                <fieldset class="examField">
                    <legend style="margin:0 auto;"id="createHeader">Expressions</legend><br>
                    <?php
                        renderQuestions($category="expressions", $quizNum=40); 
                    ?>
                    <label class="examHeader">Simplify</label><br><br><br>
                    <?php
                        renderQuestions($category="simplify", $quizNum=43); 
                    ?>
                    <label class="examHeader">Division & Multiplication</label><br><br><br>
                    <?php
                        renderQuestions($category="division", $quizNum=46); 
                    ?>
                </fieldset>
                <fieldset>
                <legend style="margin:0 auto;"id="createHeader">Roman Numbers</legend><br>
                    <?php
                        renderQuestions($category="roman_numbers", $quizNum=50); 
                    ?>
                </fieldset>
        </div>
        <div class="sidebar">
            <div class="sidebarContent">
                <h3 style="color:#FF0000" align="center">
                Your exam will automatically submitted in: <span id='timer'></span>
                </h3><br><br>
                    <input type="submit" name="submitExam" value="Submit exam" class="examSubmitBtn">
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>