<?php
    require_once "../config.php";

    $search = "";
    $input_search = "";
    $search_err = "";

    if (empty($_GET["search"])) {
    } else {
        $search = $_GET["search"];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once '../config.php';

        $input_search = trim($_POST["search"]);
        $search = $input_search;
    }

    if (empty($_GET["event_id"])) {
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
    <title>Register</title>
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
        .row {
            height:100vh;
        }
        .wrapper {
            width: 100%;
            margin: 0 auto;
        }     
        .col-md-6 {
            border-style: solid;
        }
        .bg-primary {
            background-color: #013365 !important;
        }
        .darkbeegee{
        }
        body {
            background-image: url(../Event_Creation/img/bg.png);
        }
      input::-webkit-outer-spin-button,
      input::-webkit-inner-spin-button {
        display: none;
      }
    </style>

</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="row">
                
                <div class="col-md-6 bg-light">
                
                    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]."?event_id=".$event_id."&search=".$search;?>">
                        <div class="input-group input-group">
                            <button class="btn btn-danger btn position-relative input-group-button"><a href="../Dashboard/dashboard.html" class="stretched-link"></a>Back</button>
                            <input type="text" style= "border-radius:3px" name="search" class="form-control <?php echo (!empty($search_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $search?>"/>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>

                        <script>
                            $(document).ready(function() {
                                $('#events').DataTable( {   
                                    dom: 'lp'
                                } );
                            } );
                        </script>
                        <?php
                            require_once '../config.php';

                            if (!empty($search)) {
                                $event_sql = "SELECT * FROM event_info WHERE event_name LIKE ? OR 
                                                                       event_type LIKE ? OR
                                                                       venue LIKE ? OR
                                                                       oic LIKE ?";
                
                                if ($stmt = $mysqli->prepare($event_sql)) {
                                    $stmt->bind_param("ssss", $param_search, $param_search, $param_search, $param_search);
                                    $param_search = "%" . $search  . "%";
                                    if ($stmt->execute()) {
                                        $event_result = $stmt->get_result();
                                    } else {
                                        echo "search failed";
                                    }
                                }
                                $stmt->close();
                            } else {
                                $event_sql = "SELECT * FROM event_info";
                                if ($stmt = $mysqli->prepare($event_sql)) {
                                    if ($stmt->execute()) {
                                        $event_result = $stmt->get_result();
                                    } else {
                                        echo "search failed";
                                    }
                                }
                                $stmt->close();
                            }

                            if ($event_result) {
                                if($event_result->num_rows > 0) {
                                    echo '<table id="events" class="table table-bordered table-striped table-hover">';
                                    echo "<thead>";
                                    echo "<tr>";
                                    echo "<th>#</th>";
                                    echo "<th>event_name</th>";
                                    echo "<th>date</th>";
                                    echo "<th>attendees</th>";
                                    echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    while ($rows = $event_result->fetch_array()) {
                                        $attendee_sql = "SELECT * FROM attendees WHERE event_id=".$rows['event_id'];
                                        $attendee_result = ($mysqli->query($attendee_sql))->num_rows;
                                        echo "<tr class='position-relative'>";
                                        echo "<td><a class='stretched-link' href='index.php?event_id=".urlencode($rows['event_id'])."&search=".$search."'>" . $rows['event_id'] . "</a></td>";
                                        echo "<td>" . $rows['event_name'] . "</td>";
                                        echo "<td>" . $rows['date'] . "</td>";
                                        echo "<td>" . $attendee_result   . "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";
                                    echo "</table>";
                                    // Free result set
                                    $event_result->free();

                                } else {

                                }
                            } else {

                            }
                            ?>
                    </form>
                </div>
                <div class="col-md-6 bg-primary darkbeegee text-light">

                <script>
                    $(document).ready(function() {
                        $('#report').DataTable( {
                            dom: 'Blfrtip',
                            buttons: [
                                'copy', 'csv', 'excel', 'pdf', 'print'
                            ]
                        } );
                    } );
                </script>

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
                        if (empty($event_rows['event_name'])) {$event_name = "null";} else {$event_name = $event_rows['event_name'];}
                        echo "<h5>Event Name</h5>";
                        echo "<p>".$event_name."</p>";
                        echo "<h5>Attendant Count</h5>";
                        echo "<p>".$attendee_count."</p>";
                        echo "<h5>Payment Total</h5>";
                        echo "<p>".$payment_total."</p>";

                        if ($student_result) {
                            if($student_result->num_rows > 0) {
                                echo '<table id="report" class="table table-bordered table-striped text-white">';
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>first_name</th>";
                                echo "<th>last_name</th>";
                                echo "<th>middle_initial</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while ($student_rows = $student_result->fetch_array()) {
                                    if (!in_array($student_rows['student_number'],$student_number_array)) {
                                        continue;
                                    }
                                    echo "<tr>";
                                    echo "<td>" . $student_rows['first_name'] . "</td>";
                                    echo "<td>" . $student_rows['last_name'] . "</td>";
                                    echo "<td>" . $student_rows['middle_initial'] . "</td>";
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
        </div>
    </div>
</body>
