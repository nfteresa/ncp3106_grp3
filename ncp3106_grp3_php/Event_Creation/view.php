<?php 
    require_once "../config.php";
    $flag = $_GET["flag"];

    $event_name = "";
    $event_description = "";
    $event_type = "";
    $date = "";
    $start_time = "";
    $end_time = "";
    $registration_fee = "";
    $venue = "";
    $oic = "";
    $event_name_err = "";
    $event_description_err = "";
    $event_type_err = "";
    $date_err = "";
    $start_time_err = "";
    $end_time_err = "";
    $registration_fee_err = "";
    $venue_err = "";
    $oic_err = "";

    if (empty($_GET["event_id"])) {
        echo "something went wrong";
    } else if (!is_numeric($_GET["event_id"])) {
        echo "ulol try mo";
    } else {
        $event_id = urldecode($_GET["event_id"]);
    }

    if ($flag == "edit") {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                //Get ID from URL
                $event_id = trim($_POST["id"]);
            
                //Validate event name
                $input_event_name = trim($_POST["event_name"]);
                if (empty($input_event_name)) {
                    $event_name_err = "Please enter a name.";
                } else {
                    $event_name = $input_event_name;
                }
                //Validate event description
                $input_event_description = trim($_POST["event_description"]);
                if (empty($input_event_description)) {
                    $event_description_err = "Please enter a event_description.";
                } else {
                    $event_description = $input_event_description;
                }
                //Validate event type
                $input_event_type = trim($_POST["event_type"]);
                if (empty($input_event_type)) {
                    $event_type_err = "Please enter a event_type.";
                } else {
                    $event_type = $input_event_type;
                }
            
                //Validate event date
                $input_date = trim($_POST["date"]);
                if (empty($input_date)) {
                    $date_err = "Please enter a valid event date";
                } else {
                    $date = $input_date;
                }
            
                //Validate start_time.
                $input_start_time = trim($_POST["start_time"]);
                if (empty($input_start_time)) {
                    $start_time_err = "Please enter a start_time.";
                } else {
                    $start_time = $input_start_time;
                }
            
                // Validate end time.
                $input_end_time = trim($_POST["end_time"]);
                if (empty($input_end_time)) {
                    $end_time_err = "Please enter the end_time amount.";
                } else {
                    $end_time = $input_end_time;
                }
            
                // Validate registration fee.
                $input_registration_fee = trim($_POST["registration_fee"]);
                if (empty($input_registration_fee)) {
                    $registration_fee_err = "Please enter an registration_fee.";
                } else {
                    $registration_fee = $input_registration_fee;
                }
            
                // Validate venue.
                $input_venue = trim($_POST["venue"]);
                if (empty($input_venue)) {
                    $venue_err = "Please enter the venue amount.";
                } else {
                    $venue = $input_venue;
                }
            
                // Validate oic.
                $input_oic = trim($_POST["oic"]);
                if (empty($input_oic)) {
                    $oic_err = "Please enter an oic.";
                } else {
                    $oic = $input_oic;
                }
            
                // Check input errors before inserting in database
                if (empty($event_name_err) && empty($event_description_err) && empty($event_type_err) && empty($date_err) && empty($start_time_err) && empty($end_time_err) && empty($registration_fee_err) && empty($venue_err) && empty($oic_err)) {
                    // Prepare an insert statement
                    $sql = "UPDATE event_info SET event_name=?, event_description=?, event_type=?, date=?, start_time=?, end_time=?, registration_fee=?, venue=?, oic=? WHERE event_id=?";
            
                    if ($stmt = $mysqli->prepare($sql)) {
                        // Bind variables to the prepared statement as parameters
                        $stmt->bind_param("sssssssssi", $param_event_name, $param_event_description, $param_event_type, $param_date, $param_start_time, $param_end_time, $param_registration_fee, $param_venue, $param_oic, $param_event_id);
            
                        // Set parameters
                        $param_event_name = $event_name;
                        $param_event_description = $event_description;
                        $param_event_type = $event_type;
                        $param_date = $date;
                        $param_start_time = $start_time;
                        $param_end_time = $end_time;
                        $param_registration_fee = $registration_fee;
                        $param_venue = $venue;
                        $param_oic = $oic;
                        $param_event_id = $event_id;
            
                        // Attempt to execute the prepared statement
                        if ($stmt->execute()) {
                            // Records created successfully. Redirect to landing page
                            header("location: view.php?event_id=".$event_id."&flag=view");
                            exit();
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                            header("location: error.php?asdas");
                        }
                    }
                    // Close statement
                    $stmt->close();
                }
                // Close connection
                $mysqli->close();
            } else {
                // put server request error here
            }
        }
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
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">

                <?php 
                    require_once "../config.php";

                    $sql = "SELECT * FROM event_info WHERE event_id = ? ";
                    if ($stmt = $mysqli->prepare($sql)) {
                        $stmt->bind_param("i", $event_id);  
                        if ($stmt->execute()) {
                            $result = $stmt->get_result();
                        }
                    }

                    if ($result) {
                        if ($result->num_rows > 0) {
                            $rows = $result->fetch_array();
                            if ($flag == "edit") {
                                echo '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?event_id='.$event_id.'&flag=edit" method="post">';
                                
                                echo '<a href="view.php?event_id='.$event_id.'&flag=view" class="btn btn-secondary ml-2">Cancel</a>';
                                echo '<input type="submit" class="btn btn-primary" value="Submit">';
                                
                                echo '<div class="form-group">';
                                echo "<label>Event Name</label>";
                                $placeholder = $rows['event_name'];
                                $is_invalid = (!empty($event_name_err)) ? "is-invalid" : "";
                                echo '<input type="text" name="event_name" class="form-control'.$is_invalid.'" value="'.$placeholder.'">';
                                echo '</div>';

                                echo '<div class="form-group">';
                                echo "<label>Event Description</label>";
                                $placeholder = $rows['event_description'];
                                $is_invalid = (!empty($event_description_err)) ? "is-invalid" : "";
                                echo '<input type="text" name="event_description" class="form-control'.$is_invalid.'" value="'.$placeholder.'">';
                                echo '</div>';

                                echo '<div class="form-group">';
                                echo "<label>Event Type</label>";
                                $placeholder = $rows['event_type'];
                                $is_invalid = (!empty($event_type_err)) ? "is-invalid" : "";
                                echo '<input type="text" name="event_type" class="form-control'.$is_invalid.'" value="'.$placeholder.'">';
                                echo '</div>';

                                echo '<div class="form-group">';
                                echo "<label>Date</label>";
                                $placeholder = $rows['date'];
                                $is_invalid = (!empty($date_err)) ? "is-invalid" : "";
                                echo '<input type="date" name="date" class="form-control'.$is_invalid.'" value="'.$placeholder.'">';
                                echo '</div>';

                                echo '<div class="form-group">';
                                echo "<label>Start Time</label>";
                                $placeholder = $rows['start_time'];
                                $is_invalid = (!empty($start_time_err)) ? "is-invalid" : "";
                                echo '<input type="time" name="start_time" class="form-control'.$is_invalid.'" value="'.$placeholder.'">';
                                echo '</div>';

                                echo '<div class="form-group">';
                                echo "<label>End Time</label>";
                                $placeholder = $rows['end_time'];
                                $is_invalid = (!empty($end_time_err)) ? "is-invalid" : "";
                                echo '<input type="time" name="end_time" class="form-control'.$is_invalid.'" value="'.$placeholder.'">';
                                echo '</div>';

                                echo '<div class="form-group">';
                                echo "<label>Registration Fee</label>";
                                $placeholder = $rows['registration_fee'];
                                $is_invalid = (!empty($registration_fee_err)) ? "is-invalid" : "";
                                echo '<input type="text" name="registration_fee" class="form-control'.$is_invalid.'" value="'.$placeholder.'">';
                                echo '</div>';

                                echo '<div class="form-group">';
                                echo "<label>Venue</label>";
                                $placeholder = $rows['venue'];
                                $is_invalid = (!empty($venue_err)) ? "is-invalid" : "";
                                echo '<input type="text" name="venue" class="form-control'.$is_invalid.'" value="'.$placeholder.'">';
                                echo '</div>';

                                echo '<div class="form-group">';
                                echo "<label>Officer-In-Charge</label>";
                                $placeholder = $rows['oic'];
                                $is_invalid = (!empty($oic_err)) ? "is-invalid" : "";
                                echo '<input type="text" name="oic" class="form-control'.$is_invalid.'" value="'.$placeholder.'">';
                                echo '</div>';

                                echo '<input type="hidden" name="id" value="'.$event_id.'">';
                                echo '</form>';
                            } else {
                                echo '<a href="index.php"><button class="btn btn-danger">Back</button></a>';
                                echo '<a href="view.php?event_id='.$event_id.'&flag=edit" class="btn btn-secondary ml-2">Edit</a>';
                                echo "<label>Event Name</label>";
                                echo "<p>".$rows['event_name']."</p>";
                                echo "<label>Event Description</label>";
                                echo "<p>".$rows['event_description']."</p>";
                                echo "<label>Event Type</label>";
                                echo "<p>".$rows['event_type']."</p>";
                                echo "<label>Date</label>";
                                echo "<p>".$rows['date']."</p>";
                                echo "<label>Start Time</label>";
                                echo "<p>".$rows['start_time']."</p>";
                                echo "<label>End Time</label>";
                                echo "<p>".$rows['end_time']."</p>";
                                echo "<label>Registration Fee</label>";
                                echo "<p>".$rows['registration_fee']."</p>";
                                echo "<label>Venue</label>";
                                echo "<p>".$rows['venue']."</p>";
                                echo "<label>Officer-In-Charge</label>";
                                echo "<p>".$rows['oic']."</p>";
                            }
                            echo '<a href="delete_entry.php?event_id='.$event_id.'" class="btn btn-danger ml-2">Delete</a>';
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</body>

</html>
