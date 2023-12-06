<?php
// Include config file
require_once "../config.php";

// Define variables and initialize with empty values
$first_name = "";
$last_name = "";
$middle_initial = "";
$student_number = "";
$program = "";
$current_year = "";
$ue_email = "";
$contact_number = "";
$first_name_err = "";
$last_name_err = "";
$middle_initial_err = "";
$student_number_err = "";
$program_err = "";
$current_year_err = "";
$ue_email_err = "";
$contact_number_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Validate name
    $input_first_name = trim($_POST["first_name"]);
    if (empty($input_first_name)) {
        $first_name_err = "Please enter a name.";
    } elseif (!filter_var($input_first_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $first_name_err = "Please enter a valid name.";
    } else {
        $first_name = $input_first_name;
    }

    $input_last_name = trim($_POST["last_name"]);
    if (empty($input_last_name)) {
        $last_name_err = "Please enter a last_name.";
    } elseif (!filter_var($input_last_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $last_name_err = "Please enter a valid last_name.";
    } else {
        $last_name = $input_last_name;
    }

    $input_middle_initial = trim($_POST["middle_initial"]);
    if (!filter_var($input_middle_initial, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))){
        $middle_initial_err = "Please enter a valid middle_initial.";
    } else {
        $middle_initial = $input_middle_initial;
    }   

    //Validate student number
    $input_student_number = trim($_POST["student_number"]);
    if (empty($input_student_number)) {
        $student_number_err = "Please enter the student_number amount.";
    } elseif (!ctype_digit($input_student_number)) {
        $student_number_err = "Please enter a positive integer value.";
    } else {
        $student_number = $input_student_number;
    }

    //Validate program
    $program = $_POST["program"];
    if (empty($program)) {
        $program_err = "Please enter your program.";
    } else {
        $program = $program;
    }

    // Validate current year
    $current_year = $_POST["current_year"];
    if (empty($current_year)){
        $current_year_err = "Please enter your current year.";
    } else {
        $current_year = $current_year;
    }


    // Validate ue email
    $input_ue_email = trim($_POST["ue_email"]);
    if (empty($input_ue_email)) {
        $ue_email_err = "Please enter an UE email.";
    } else {
        $ue_email = $input_ue_email;
    }

    // Validate contact number
    $input_contact_number = trim($_POST["contact_number"]);
    if (empty($input_contact_number)) {
        $contact_number_err = "Please enter your contact number. ";
    } elseif (!ctype_digit($input_contact_number)) {
        $contact_number_err = "Please enter a positive integer value.";
    } else {
        $contact_number = $input_contact_number;
    }

    // Check input errors before inserting in database
    if (empty($first_name_err) && empty($last_name_err) && empty($middle_initial_err) && empty($student_number_err) && empty($program_err) && empty($current_year_err) && empty($ue_email_err) && empty($contact_number_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO stud_info (first_name, last_name, middle_initial, student_number, program, current_year, ue_email, contact_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssssss", $param_first_name, $param_last_name, $param_middle_initial, $param_student_number, $param_program, $param_current_year, $param_ue_email, $param_contact_number);

            // Set parameters
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_middle_initial = $middle_initial;
            $param_student_number = $student_number;
            $param_program = $program;
            $param_current_year = $current_year;
            $param_ue_email = $ue_email;
            $param_contact_number = $contact_number;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
       // $stmt->close();
    }

    // Close connection
    $mysqli->close();
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
<style>
    @font-face {
        font-family: myFirstFont;
        src: url('../font/Montserrat-VariableFont_wght.ttf');
    }
  body {
    opacity: 1;
    background-color: #013365;
    background-image: url('../Student_Registration/img/bg2.png');
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
        <div class="col-md-6 no-gutters" style="width:100%; box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3); border-radius: 10px 0px 0px 10px; background: rgba(246, 246, 242, 1); height:500px;margin-top: 30px; font-family: myFirstFont; background-size:cover ; background-image:url('../Student_Registration/img/bg.png')">
        <a href="index.php"><img src="./img/back.png" style="position: absolute; top: 8px; left: 16px; width:50px; height: 50px;"></a>
        <div class="signup-form" style="float: left; background-size: cover; margin: auto; text-align: center; margin-top: 200px; ">
            <h2 style="margin-left: 50px;">Student Registration</h2>
            <p class="hint-text" style="margin-left: 50px; color: white;">Plan, Create, Celebrate: Events Made Easy.</p>
        </div>
        </div>
        <div class="col-md-6 no-gutters" style="width:100%;overflow: scroll; height:500px; margin-top: 30px; border-radius: 0px 10px 10px 0px; background: rgba(246, 246, 242, 1);">
            <div class="signup-form" style="float: left; justify-content: center; align-items: center; margin: auto; ">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group" style="margin-left: 60px;">
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label style="font-weight: bold;">First Name</label><br>
                                <input style="width: 100%; padding:5px; padding-left:5px; border-radius: 5px; border: 1px solid black" name="first_name" type="text" class="form-control <?php echo (!empty($first_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first_name; ?>">
                                <span class="invalid-feedback"><?php echo $start_time_err; ?></span>
                            </div>
                            <div class="col">
                                <label style="font-weight: bold;">M.I.</label><br>
                                <input style="width: 100%; padding:5px; padding-left:5px; border-radius: 5px; border: 1px solid black" name="middle_initial" type="text" class="form-control <?php echo (!empty($last_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last_name; ?>">
                                <span class="invalid-feedback"><?php echo $end_time_err; ?></span>
                            </div>
                            <div class="col">
                                <label style="font-weight: bold;">Last Name</label><br>
                                <input style="width: 100%; padding:5px; padding-left:5px; border-radius: 5px; border: 1px solid black" name="last_name" type="text" class="form-control <?php echo (!empty($last_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last_name; ?>">
                                <span class="invalid-feedback"><?php echo $end_time_err; ?></span>
                            </div>
                        </div>        	
                    </div>  
                    <div class="form-group">
                        <label style="font-weight: bold;">Student Number</label><br>
                        <input style="width: 100%; padding:5px; padding-left:5px; border-radius: 5px; border: 1px solid black" name="student_number" type="number" class="form-control <?php echo (!empty($student_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $student_number; ?>">
                        <span class="invalid-feedback"><?php echo $student_number_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label style="font-weight: bold;">Program</label>
                        <select name="program" style="width: 100%; padding:5px; padding-left:5px; border-radius: 5px; border: 1px solid black" name="program" class="form-control <?php echo (!empty($program_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $program; ?>">
                        <span class="invalid-feedback"><?php echo $program_err; ?></span>
                            <option value="">Select program</option>
                            <option value="CpE">Computer Engineering</option>
                            <option value="ECE">Electrical Engineering</option>
                            <option value="CE">Civil Engineering</option>
                            <option value="ME">Mechanical Engineering</option>
                            <option value="EE">Electronic Engineering</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="font-weight: bold;">Year Level</label>
                        <select name="current_year" style="width: 100%; padding:5px; padding-left:5px; border-radius: 5px; border: 1px solid black" name="current_year" class="form-control <?php echo (!empty($current_year_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $current_year; ?>">
                        <span class="invalid-feedback"><?php echo $current_year_err; ?></span>
                            <option value="">Current Year</option>
                            <option value="1st">1st</option>
                            <option value="2nd">2nd</option>
                            <option value="3rd">3rd</option>
                            <option value="4th">4th</option>                       
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="font-weight: bold;">Email</label><br>
                        <input style="width: 100%; padding:5px; padding-left:5px; border-radius: 5px; border: 1px solid black" name="ue_email" type="email" class="form-control <?php echo (!empty($ue_email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $ue_email; ?>">
                        <span class="invalid-feedback"><?php echo $ue_email_err; ?></span>
                    </div>
                    <div class="form-group">
                            <label style="font-weight: bold;">Contact Number</label>
                            <input type="number" name="contact_number"  style="width: 100%; padding:5px; padding-left:5px; border-radius: 5px; border: 1px solid black" name="contact_number" class="form-control" <?php echo (!empty($contact_number_err)) ? 'is-invalid' : ''; ?> value="<?php echo $contact_number; ?>">
                            <span class="invalid-feedback"><?php echo $contact_number_err; ?></span>  
                        </div>
                        
                    </div>
                    <div class="form-group" style="margin-left: 60px;">
                            <button type="submit" style="background-color: #CC1429; border: #CC1429 solid;" class="btn btn-success btn-lg btn-block">Register</button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>