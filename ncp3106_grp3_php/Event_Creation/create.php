<?php
// Include config file
require_once "../config.php";

// Define variables and initialize with empty values
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

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        $sql = "INSERT INTO event_info (event_name, event_description, event_type, date, start_time, end_time, registration_fee, venue, oic) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssssssss", $param_event_name, $param_event_description, $param_event_type, $param_date, $param_start_time, $param_end_time, $param_registration_fee, $param_venue, $param_oic);

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

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records created successfully. Redirect to landing page
                header("location: create.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $mysqli->close();
}
// END OF PHP PART
// START OF HTML PART
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
<style>
    @font-face {
        font-family: myFirstFont;
        src: url(Montserrat-VariableFont_wght.ttf);
    }
  body {
    opacity: 1;
    background-color: #013365;
    background-image: url(bg.png);
    background-size: cover;
  }
  .signup-form::-webkit-scrollbar{
    display: none;
  }
  .form-control {
    height: 40px;
    box-shadow: none;
    color: #969fa4;
  }
  .form-control:focus {
    border-color: #013365;
  }
  .form-control, .btn {        
    border-radius: 3px;
  }
  .signup-form {
    width: 450px;
    margin: 0 auto;
    font-size: 15px;
    -ms-overflow-style: none;
    scrollbar-width: none;
  }
  .signup-form h2 {
    color: white;
    font-weight: bold;
    margin: 0 0 15px;
    position: relative;
    text-align: center;
  }
  .signup-form h2:before {
    left: 0;
  }
  .signup-form h2:after {
    right: 0;
  }
  .signup-form .hint-text {
    color: #999;
    margin-bottom: 30px;
    text-align: center;
  }
  .signup-form form {
    margin-top: 30px;
    color: black;
    border-radius: 3px;
    margin-bottom: 15px;
    background: rgba(246, 246, 242, 1);
    padding: 30px;
    width: 100%; 
    height: 100%;
    line-height: 1.8; 
    display: block;
    
  }
  .signup-form .form-group {
    margin-bottom: 20px;
  }
  .signup-form input [type="checkbox"] {
    margin-top: 3px;
  }
  .signup-form .btn {        
    font-size: 16px;
    font-weight: bold;		
    min-width: 140px;
    outline: none !important;
  }
  .signup-form .row div:first-child {
    padding-right: 10px;
  }
  .signup-form .row div:last-child {
    padding-left: 10px;
  }    	
  .signup-form a {
    color: #fff;
    text-decoration: underline;
  }
  .signup-form a:hover {
    text-decoration: none;
  }
  .signup-form form a {
    color: #013365;
    text-decoration: none;
  }	
  .signup-form form a:hover {
    text-decoration: underline;
  }  
  .container {
    display: flex;
    align-items: center;
    justify-content: center;
    margin: auto;
    text-align: center;
  }
  ::-webkit-scrollbar{
    display: none;
  }
</style>
<body>
    <div class="container">
        <div class="col-md-6 no-gutters" style="width:100%; box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3); border-radius: 10px 0px 0px 10px; background: rgba(246, 246, 242, 1); height:500px;margin-top: 30px;background: #013365; font-family: myFirstFont; background-size:cover ; background-image:url(bg3.png)">
        <a href="index.php"><img src="back2.png" style="position: absolute; top: 8px; left: 16px; width:50px; height: 50px;"></a>
        <div class="signup-form" style="float: left; background-size: cover; margin: auto; text-align: center; margin-top: 200px; ">
            <h2 style="margin-left: 50px;">Register Event</h2>
            <p class="hint-text" style="margin-left: 50px; color: white;">Plan, Create, Celebrate: Events Made Easy.</p>
        </div>
        </div>
        <div class="col-md-6 no-gutters" style="width:100%;overflow: scroll; height:500px; margin-top: 30px; border-radius: 0px 10px 10px 0px; background: rgba(246, 246, 242, 1);">
            <div class="signup-form" style="float: left; justify-content: center; align-items: center; margin: auto; ">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group" style="margin-left: 60px;">
                    <div class="form-group">
                        <label style="font-weight: bold;">Event Name</label><br>
                        <input style="width: 100%; padding:5px; padding-left:5px; border-radius: 5px; border: 1px solid black" type="text" class="form-control <?php echo (!empty($event_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $event_name; ?>" name="event_name" required="required">
                        <span class="invalid-feedback"><?php echo $event_name_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label style="font-weight: bold;">Event Description</label><br>
                        <input style="width: 100%; padding:5px; padding-left:5px; border-radius: 5px; border: 1px solid black" type="text" class="form-control <?php echo (!empty($event_description_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $event_description; ?>" name="event_description" required="required">
                        <span class="invalid-feedback"><?php echo $event_description_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label style="font-weight: bold;">Event Type</label><br>
                        <input style="width: 100%; padding:5px; padding-left:5px; border-radius: 5px; border: 1px solid black" type="text" class="form-control <?php echo (!empty($event_type_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $event_type; ?>" name="event_type" required="required">
                        <span class="invalid-feedback"><?php echo $event_type_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label style="font-weight: bold;">Event Date</label><br>
                        <input style="width: 100%; padding:5px; padding-left:5px; border-radius: 5px; border: 1px solid black" type="date" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date; ?>" name="date" required="required">
                        <span class="invalid-feedback"><?php echo $date_err; ?></span>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label style="font-weight: bold;">Start Time</label><br>
                                <input style="width: 100%; padding:5px; padding-left:5px; border-radius: 5px; border: 1px solid black" type="time" class="form-control <?php echo (!empty($start_time_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $start_time; ?>" name="start_time" required="required">
                                <span class="invalid-feedback"><?php echo $start_time_err; ?></span>
                            </div>
                            <div class="col">
                                <label style="font-weight: bold;">End Time</label><br>
                                <input style="width: 100%; padding:5px; padding-left:5px; border-radius: 5px; border: 1px solid black" type="time" class="form-control <?php echo (!empty($end_time_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $end_time; ?>" name="end_time" required="required">
                                <span class="invalid-feedback"><?php echo $end_time_err; ?></span>
                            </div>
                        </div>        	
                    </div>  
                    </div>
                    <div class="form-group" style="margin-left: 60px;">
                    <label style="font-weight: bold;">Registration Fee</label><br>
                    <input style="width: 100%; padding:5px; padding-left:5px; border-radius: 5px; border: 1px solid black" type="number" class="form-control <?php echo (!empty($registration_fee_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $registration_fee; ?>" name="registration_fee" required="required">
                    <span class="invalid-feedback"><?php echo $registration_fee_err; ?></span>
                    </div>
                    <div class="form-group" style="margin-left: 60px;">
                    <label style="font-weight: bold;">Venue</label><br>
                    <input style="width: 100%; padding:5px; padding-left:5px; border-radius: 5px; border: 1px solid black" type="text" class="form-control <?php echo (!empty($venue_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $venue; ?>" name="venue" required="required">
                    <span class="invalid-feedback"><?php echo $venue_err; ?></span>
                    </div>
                    <div class="form-group" style="margin-left: 60px;">
                    <label style="font-weight: bold;">Officer in Charge</label><br>
                    <input style="width: 100%; padding:5px; padding-left:5px; border-radius: 5px; border: 1px solid black" type="text" class="form-control <?php echo (!empty($oic_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $oic; ?>"name="oic" required="required">
                    <span class="invalid-feedback"><?php echo $oic_err; ?></span>
                    </div>
                    <div class="form-group" style="margin-left: 60px;">
                            <button type="submit" style="background-color: #013365; border: #013365 solid;" class="btn btn-success btn-lg btn-block">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
