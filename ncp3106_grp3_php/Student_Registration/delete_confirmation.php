<?php
    if (isset($_POST["ids"]) && !empty($_POST["ids"])) {
        // ask for access to the server
        require_once "../config.php";

        //sql statement
        $sql = "DELETE FROM stud_info WHERE stud_id = ?";

        //turn url variable to array
        $ids = explode(",", urldecode($_GET["ids"]));

        //iterate over array executing $sql for every array element.
        while (count($ids)) {
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("i", $param_ids);
    
                (int) $param_ids = array_pop($ids);
    
                if ($stmt->execute()) {
                    header("location: index.php");
                }  else {
                    echo "woops!";
                }  
            }
        }
        exit();
    } else {
        //error message here.
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }     
      input::-webkit-outer-spin-button,
      input::-webkit-inner-spin-button {
        display: none;
      }
    </style>

</head>

<body>
    <wrapper>
        <div type="container-fluid">
            ARE YOU SURE YOU WANT TO DELETE THESE?
            <form method="post">
                <input type = "hidden" name = "ids" value = '<?php echo trim($_GET["ids"]); ?>'/>
                <input type = "submit" class = "btn btn_danger" value = "Yes"/>  
            </form>
                <a href="delete.php"><button class = "btn btn_danger" >No</button></a>
            <?php
                require_once "../config.php";
                $ids = explode(",", urldecode($_GET["ids"]));
                $ids = implode("', '",$ids);
                $sql = "SELECT * FROM stud_info WHERE stud_id IN ('$ids')";
                if ($result = $mysqli->query($sql)){
                    if($result->num_rows > 0) {
                        echo '<table class="table table-bordered table-striped">';
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>#</th>";
                        echo "<th>first_name</th>";
                        echo "<th>last_name</th>";
                        echo "<th>middle_initial</th>";
                        echo "<th>student_number</th>";
                        echo "<th>program</th>";
                        echo "<th>current_year</th>";
                        echo "<th>ue_email</th>";
                        echo "<th>contact_number</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while ($rows = $result->fetch_array()) {
                            echo "<tr>";
                            echo "<td>" . $rows['stud_id'] . "</td>";
                            echo "<td>" . $rows['first_name'] . "</td>";
                            echo "<td>" . $rows['last_name'] . "</td>";
                            echo "<td>" . $rows['middle_initial'] . "</td>";
                            echo "<td>" . $rows['student_number'] . "</td>";
                            echo "<td>" . $rows['program'] . "</td>";
                            echo "<td>" . $rows['current_year'] . "</td>";
                            echo "<td>" . $rows['ue_email'] . "</td>";
                            echo "<td>" . $rows['contact_number'] . "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        $result->free();
                    }
                }
            ?>
        </div>
    </wrapper>
</body>  