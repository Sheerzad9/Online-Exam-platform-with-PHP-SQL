<?php
    function renderQuestions($category, $quizNum, $definition =""){
        require('connectDB.php');

        $query = "SELECT Question FROM examqa WHERE Category = '$category'";
        $data = mysqli_query($dbc, $query);
        while($row=mysqli_fetch_array($data)){
           echo "<label style='float: left;' name='question'>" .++$quizNum; echo ".&emsp;"; echo $row['Question']; echo"&emsp;=&emsp;</label>";
            echo "<input maxlength='10' style='float: left;' class='answerInput' type='text' name='answer";echo$quizNum; echo"'"; echo "placeholder='Answer here...'>"; echo $definition; echo"<br><br><br><br>";
        };
        return $quizNum;
    }


?>