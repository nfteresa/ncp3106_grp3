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

    // Validate address
    $input_address = trim($_POST["address"]);
    if (empty($input_address)) {
        $address_err = "Please enter an address.";
    } else {
        $address = $input_address;
    }

    // Validate salary
    $input_salary = trim($_POST["salary"]);
    if (empty($input_salary)) {
        $salary_err = "Please enter the salary amount.";
    } elseif (!ctype_digit($input_salary)) {
        $salary_err = "Please enter a positive integer value.";
    } else {
        $salary = $input_salary;
    }

    $input_datehired = trim($_POST["datehired"]);
    if (empty($input_datehired)) {
        $datehired_err = "Please enter an datehired.";
    } else {
        $datehired = $input_datehired;
    }

    // Validate job role
    $input_jobrole = trim($_POST["jobrole"]);
    if (empty($input_jobrole)) {
        $jobrole_err = "Please enter a jobrole.";
    } elseif (!filter_var($input_jobrole, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $jobrole_err = "Please enter a valid jobrole.";
    } else {
        $jobrole = $input_jobrole;
    }

    // Check input errors before inserting in database
    if (empty($name_err) && empty($address_err) && empty($salary_err) && empty($datehired_err) && empty($jobrole_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO employees (name, address, salary, datehired, jobrole) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssss", $param_name, $param_address, $param_salary, $param_datehired, $param_jobrole);

            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            $param_datehired = $datehired;
            $param_jobrole = $jobrole;

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