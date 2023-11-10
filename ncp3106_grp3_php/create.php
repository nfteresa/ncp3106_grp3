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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
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
    if (empty($input_middle_initial)) {
        $middle_initial_err = "Please enter a middle_initial.";
    } elseif (!filter_var($input_middle_initial, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
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
    $input_program = trim($_POST["program"]);
    if (empty($input_program)) {
        $program_err = "Please enter an program.";
    } else {
        $program = $input_program;
    }

    // Validate address
    $input_address = trim($_POST["address"]);
    if (empty($input_address)) {
        $address_err = "Please enter an address.";
    } else {
        $address = $input_address;
    }

    // Validate current year
    $input_current_year = trim($_POST["current_year"]);
    if (empty($input_current_year)) {
        $current_year_err = "Please enter the current_year amount.";
    } elseif (!ctype_digit($input_current_year)) {
        $current_year_err = "Please enter a positive integer value.";
    } else {
        $current_year = $input_current_year;
    }

    // Validate ue email
    $input_ue_email = trim($_POST["ue_email"]);
    if (empty($input_ue_email)) {
        $ue_email_err = "Please enter an ue_email.";
    } else {
        $ue_email = $input_ue_email;
    }

    // Validate contact number
    $input_contact_number = trim($_POST["contact_number"]);
    if (empty($input_contact_number)) {
        $contact_number_err = "Please enter the contact_number amount.";
    } elseif (!ctype_digit($input_contact_number)) {
        $contact_number_err = "Please enter a positive integer value.";
    } else {
        $contact_number = $input_contact_number;
    }

    // Check input errors before inserting in database
    if (empty($first_name_err) && 
        empty($last_name_err) && 
        empty($middle_initial_err) && 
        empty($student_number_err) && 
        empty($program_err) &&
        empty($current_year_err) &&
        empty($ue_email_err) &&
        empty($contact_number_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO student_info (first_name, 
                                          last_name, 
                                          middle_initial, 
                                          student_number, 
                                          program, 
                                          current_year, 
                                          ue_email, 
                                          contact_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssssss", $param_first_name, 
                                          $param_last_name, 
                                          $param_middle_initial, 
                                          $param_student_number, 
                                          $param_program,
                                          $param_current_year, 
                                          $param_ue_email, 
                                          $param_contact_number);

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
        $stmt->close();
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
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary; ?>">
                            <span class="invalid-feedback"><?php echo $salary_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Job Role</label>
                            <input type="text" name="jobrole" class="form-control <?php echo (!empty($jobrole_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $jobrole; ?>">
                            <span class="invalid-feedback"><?php echo $jobrole_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Date Hired</label>
                            <input type="date" name="datehired" class="form-control <?php echo (!empty($datehired_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $datehired; ?>">
                            <span class="invalid-feedback"><?php echo $datehired_err; ?></span>
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
