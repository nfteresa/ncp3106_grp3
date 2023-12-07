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
            header("location: registration.php?event_id=".$event_id_url);
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

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
        <a href="../Dashboard/dashboard.html"><button class="btn btn-danger">Back</button></a>
        <form method = "post">
            <script>
                $(document).ready(function() {
                    $('#events').DataTable( {   
                        dom: 'lp'
                    } );
                } );
            </script>
                <?php
                require_once '../config.php';

                $sql = "SELECT * FROM event_info";
                if ($result = $mysqli->query($sql)) {
                    if($result->num_rows > 0) {
                        echo '<table id=events class="table table-bordered table-striped table-hover">';
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
                            echo "<tr class='position-relative'>";
                            echo '<td><input class="stretched-link" type ="radio" name = "event_id" id = "'. $rows["event_id"].' "value = "'. $rows["event_id"].'"></input></td>';
                            echo "<td class='text-wrap'>" . $rows['event_name'] . "</td>";
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
