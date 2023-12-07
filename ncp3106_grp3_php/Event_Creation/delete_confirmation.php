<?php
    if (isset($_POST["ids"]) && !empty($_POST["ids"])) {
        // ask for access to the server
        require_once "../config.php";

        //sql statement
        //nigga
        $sql = "DELETE FROM event_info WHERE event_id = ?";

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
                $sql = "SELECT * FROM event_info WHERE event_id IN ('$ids')";
                if ($result = $mysqli->query($sql)){
                    if($result->num_rows > 0) {
                        echo '<table class="table table-bordered table-striped">';
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>#</th>";
                        echo "<th>event_name</th>";
                        echo "<th>event_description</th>";
                        echo "<th>date</th>";
                        echo "<th>start_time</th>";
                        echo "<th>end_time</th>";
                        echo "<th>registration_fee</th>";
                        echo "<th>venue</th>";
                        echo "<th>oic</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while ($rows = $result->fetch_array()) {
                            echo "<tr>";
                            echo "<td>" . $rows['event_id'] . "</td>";
                            echo "<td>" . $rows['event_name'] . "</td>";
                            echo "<td>" . $rows['event_description'] . "</td>";
                            echo "<td>" . $rows['date'] . "</td>";
                            echo "<td>" . $rows['start_time'] . "</td>";
                            echo "<td>" . $rows['end_time'] . "</td>";
                            echo "<td>" . $rows['registration_fee'] . "</td>";
                            echo "<td>" . $rows['venue'] . "</td>";
                            echo "<td>" . $rows['oic'] . "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        // Free result set
                        $result->free();
                    }
                }
            ?>
        </div>
    </wrapper>
</body>  
