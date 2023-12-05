<?php
// Include config file
require_once "config.php";

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
if (isset($_POST['id']) && !empty($_POST['id'])) {
    //Get ID from URL
    $id = trim($_POST["stud_id"]);

    //Validate first name
    $input_first_name = trim($_POST["first_name"]);
    if (empty($input_first_name)) {
        $first_name_err = "Please enter a name.";
    } else {
        $first_name = $input_first_name;
    }
    //Validate last name
    $input_last_name = trim($_POST["last_name"]);
    if (empty($input_last_name)) {
        $last_name_err = "Please enter a last name.";
    } else {
        $last_name = $input_last_name;
    }
    //Validate middle initial
    $input_middle_initial = trim($_POST["middle_initial"]);
    if (empty($input_middle_initial)) {
        $middle_initial_err = "Please enter a middle initial.";
    } else {
        $middle_initial = $input_middle_initial;
    }

    //Validate student number
    $input_student_number = trim($_POST["student_number"]);
    if (empty($input_student_number)) {
        $student_number_err = "Please enter a valid event student number";
    } else {
        $student_number= $input_student_number;
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
        $ue_email_err = "Please enter an ue email.";
    } else {
        $ue_email = $input_ue_email;
    }

    // Validate contact number
    $input_contact_number = trim($_POST["contact_number"]);
    if (empty($input_venue)) {
        $contact_number_err = "Please enter the contact_number.";
    } else {
        $contact_number = $input_contact_number;
    }

    

    // Check input errors before inserting in database
    if (empty($first_name_err) && empty($last_name_err) && empty($middle_initial_err) && empty($student_number_err) && empty($program_err) && empty($current_year_err) && empty($ue_email_err) && empty($contact_number_err)) {
        // Prepare an insert statement
        $sql = "UPDATE stud_info SET first_name=?, last_name=?, middle_initial=?, student_number=?, program =?, current_year=?, ue_email=?, contact_number=? WHERE stud_id=?";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssssssi", $param_first_name, $param_last_name, $param_middle_initial, $param_student_number, $param_program, $param_current_year, $param_ue_email, $param_contact_number, $param_stud_id);

            // Set parameters
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_middle_initial = $middle_initial;
            $param_student_number = $student_number;
            $param_program = $program;
            $param_current_year = $current_year;
            $param_ue_email = $ue_email;
            $param_contact_number = $contact_number;
            $param_stud_id = $stud_id;

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
} else {
    // put error here
}
// END OF PHP PART
// START OF HTML PART
?>

<!DOCTYPE html>
<html lang="en">

<?php
                    //throw user to error page if id isnt in url
            empty($_GET["id"]) ? header("location: error.php") : "";
        ?>


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
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Registration </h2>
                    <p>Fill the form</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                        <?php
                            // i put this in every text field
                            // it gets the value of the element to edit
                            // every text field makes a database query
                                $id = $_GET['id'];
                                $sql = "SELECT * FROM stud_info WHERE stud_id = $id";
                                $result = $mysqli->query($sql);
                                $result = $result->fetch_array();
                                $placeholder = $result['first_name'];
                                $is_invalid = (!empty($first_name_err)) ? "is-invalid" : "";
                                echo '<input type="text" name="first_name" class="form-control'.$is_invalid.'" value="'.$placeholder.'">';
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <?php
                                $id = $_GET['id'];
                                $sql = "SELECT * FROM stud_info WHERE stud_id = $id";
                                $result = $mysqli->query($sql);
                                $result = $result->fetch_array();
                                $placeholder = $result['last_name'];
                                $is_invalid = (!empty($last_name_err)) ? "is-invalid" : "";
                                echo '<input type="text" name="last_name" class="form-control'.$is_invalid.'" value="'.$placeholder.'">';
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Middle Initial (Optional)</label>
                            <?php
                                $id = $_GET['id'];
                                $sql = "SELECT * FROM stud_info WHERE stud_id = $id";
                                $result = $mysqli->query($sql);
                                $result = $result->fetch_array();
                                $placeholder = $result['middle_initial'];
                                echo '<input type="text" name="middle_initial" class="form-control" value="'.$placeholder.'">';
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Student Number</label>
                            <?php
                                $id = $_GET['id'];
                                $sql = "SELECT * FROM stud_info WHERE stud_id = $id";
                                $result = $mysqli->query($sql);
                                $result = $result->fetch_array();
                                $placeholder = $result['student_number'];
                                $is_invalid = (!empty($student_number_err)) ? "is-invalid" : "";
                                echo '<input type="number" name="student_number" class="form-control'.$is_invalid.'" value="'.$placeholder.'">';
                            ?>
                            <span class="invalid-feedback"><?php echo $student_number_err; ?> </span>
                        </div>
                        <div class="form-group">
                            <label>Program</label>
                            <?php
                                $id = $_GET['id'];
                                $sql = "SELECT * FROM stud_info WHERE stud_id = $id";
                                $result = $mysqli->query($sql);
                                $result = $result->fetch_array();
                                $placeholder = $result['program'];
                                $is_invalid = (!empty($program_err)) ? "is-invalid" : "";
                                echo '<select type ="text" name = "program" class="form-control'.$is_invalid.'" value"'.$placeholder.'"
                                <option value="">Select program</option>
                                <option value="CpE">Computer Engineering</option>
                                <option value="ECE">Electrical Engineering</option>
                                <option value="CE">Civil Engineering</option>
                                <option value="ME">Mechanical Engineering</option>
                                <option value="EE">Electronic Engineering</option>
                                    </select>';
                            ?>
                            <span class="invalid-feedback"><?php echo $program_err; ?></span>
                            

                                    

                            </div>
                            <div class="form-group">
                            <label>Current Year</label>
                            <?php
                                $id = $_GET['id'];
                                $sql = "SELECT * FROM stud_info WHERE stud_id = $id";
                                $result = $mysqli->query($sql);
                                $result = $result->fetch_array();
                                $placeholder = $result['current_year'];
                                $is_invalid = (!empty($current_year_err)) ? "is-invalid" : "";
                                echo '<select type ="text" name="current_year" class="form-control'.$is_invalid.'" value"'.$placeholder.'"
                                <option value="">Current Year</option>
                                <option value="1st">1st</option>
                                <option value="2nd">2nd</option>
                                <option value="3rd">3rd</option>
                                <option value="4th">4th</option>
                                
                                    </select>';
                            ?>
                        
                                    

                            </div>
                        
                        <div class="form-group">
                            <label>Email</label>
                            <?php
                                $id = $_GET['id'];
                                $sql = "SELECT * FROM stud_info WHERE stud_id = $id";
                                $result = $mysqli->query($sql);
                                $result = $result->fetch_array();
                                $placeholder = $result['ue_email'];
                                $is_invalid = (!empty($ue_email_err)) ? "is-invalid" : "";
                                echo '<input type="email" name="ue_email" class="form-control'.$is_invalid.'" value="'.$placeholder.'">';
                            ?>
                            <span class="invalid-feedback"><?php echo $ue_email_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Contact Number</label>
                            <?php
                                $id = $_GET['id'];
                                $sql = "SELECT * FROM stud_info WHERE stud_id = $id";
                                $result = $mysqli->query($sql);
                                $result = $result->fetch_array();
                                $placeholder = $result['contact_number'];
                                $is_invalid = (!empty($contact_number_err)) ? "is-invalid" : "";
                                echo '<input type="number" name="contact_number" class="form-control'.$is_invalid.'" value="'.$placeholder.'">';
                            ?>
                            <span class="invalid-feedback"><?php echo $contact_number_err; ?></span>
                            
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"])?>">
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</body>

</html>
