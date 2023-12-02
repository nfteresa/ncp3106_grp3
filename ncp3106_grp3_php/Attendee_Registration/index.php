<?php
    require_once "../config.php";

    $event_id = "";
    $input_event_id = "";
    $event_id_err = "";
    $payment = "";
    $input_payment = "";
    $payment_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $input_event_id = trim($_POST["event_id"]);
        $event_id = $input_event_id;

        $sql = "SELECT registration_fee FROM event_info WHERE event_id=".$event_id;
        $payment = $mysqli->query($sql);
        $payment = $payment->fetch_array();
        $payment = $payment["registration_fee"];
        $mysqli->close();

        if (empty($event_id_err) && empty($payment_err)) {
            $payment_url = urlencode($payment);
            $event_id_url = urlencode($event_id);
            header("location: registration.php?event_id=".$event_id_url."&payment=".$payment_url);
        } else {
            echo "Fields are empty.";
        }
    } 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 1000px;
            margin: 0 auto;
        }     
      input::-webkit-outer-spin-button,
      input::-webkit-inner-spin-button {
        display: none;
      }
    </style>

</head>

<body>
    <div class="wrapper">
        <form method="post">
        <form method = "post">
                <?php
                require_once '../config.php';

                $sql = "SELECT * FROM event_info";
                if ($result = $mysqli->query($sql)) {
                    if($result->num_rows > 0) {
                        echo '<table class="table table-bordered table-striped">';
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>amongus</th>";
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
                            echo '<td><input type ="radio" name = "event_id" id = "'. $rows["event_id"].' "value = "'. $rows["event_id"].'"></input></td>';
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

                    } else {

                    }
                } else {

                }
                ?>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form> 
    </div>
</body>
