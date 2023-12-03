<?php 
    if (empty($_GET["event_id"])) {
        echo "something went wrong";
    } else if (!is_numeric($_GET["event_id"])) {
        echo "ulol try mo";
    } else {
        $event_id = urldecode($_GET["event_id"]);
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Event list</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper {
            width: 900px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <?php
                require_once "../config.php";
                
                $event_sql = "SELECT * FROM event_info WHERE event_id = ? ";
                $attendee_sql = "SELECT * FROM attendees WHERE event_id = ? ";

                if ($stmt = $mysqli->prepare($event_sql)) {
                    $stmt->bind_param("i", $event_id);  
                    if ($stmt->execute()) {
                        $event_result = $stmt->get_result();
                    }
                }

                if ($stmt = $mysqli->prepare($attendee_sql)) {
                    $stmt->bind_param("i", $event_id);  
                    if ($stmt->execute()) {
                        $attendee_result = $stmt->get_result();
                    }
                }

                $student_sql = "SELECT * FROM student_info";
                $student_result = $mysqli->query($student_sql);

                $attendee_count = $attendee_result->num_rows;
                $student_number_array = "";
                $payment_total = 0;
                while ($attendee_rows = $attendee_result->fetch_array()) {
                    $student_number_array = $student_number_array . " " . $attendee_rows["student_number"];
                    $payment_total += $attendee_rows["payment"];
                }
                $student_number_array = explode(" ", $student_number_array);

                if (($event_result) && ($attendee_result)) {
                    $event_rows = $event_result->fetch_array();
                    echo "<label>Event Name</label>";
                    echo "<p>".$event_rows['event_name']."</p>";
                    echo "<label>Attendant Count</label>";
                    echo "<p>".$attendee_count."</p>";
                    echo "<label>Payment Total</label>";
                    echo "<p>".$payment_total."</p>";

                    if ($student_result) {
                        if($student_result->num_rows > 0) {
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
                            while ($student_rows = $student_result->fetch_array()) {
                                if (!in_array($student_rows['student_number'],$student_number_array)) {
                                    continue;
                                }
                                echo "<tr>";
                                echo "<td>" . $student_rows['id'] . "</td>";
                                echo "<td>" . $student_rows['first_name'] . "</td>";
                                echo "<td>" . $student_rows['last_name'] . "</td>";
                                echo "<td>" . $student_rows['middle_initial'] . "</td>";
                                echo "<td>" . $student_rows['student_number'] . "</td>";
                                echo "<td>" . $student_rows['program'] . "</td>";
                                echo "<td>" . $student_rows['current_year'] . "</td>";
                                echo "<td>" . $student_rows['ue_email'] . "</td>";
                                echo "<td>" . $student_rows['contact_number'] . "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                            // Free result set
                            $student_result->free();
    
                        } else {
    
                        }
                    } else {
    
                    }
                } else {

                }

            ?>
        </div>
    </div>
</body>