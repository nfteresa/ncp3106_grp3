<?php
    require_once "../config.php";

    $student_number = "";
    $input_student_number = "";
    $student_number_err = "";

    $event_id = urldecode($_GET["event_id"]);

    $sql = "SELECT * FROM event_info WHERE event_id = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param('i',$param_event_id);
        $param_event_id = $event_id;
        if ($result = $stmt->execute()) {
            $result = $stmt->get_result();
            $result = $result->fetch_array();
            $payment = $result["registration_fee"];
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $input_student_number = trim($_POST["student_number"]);
        if (empty($input_student_number)) {
            $student_number_err = "Please put in a student number";
        } else {
            $student_number = $input_student_number;
        }

        if (empty($student_number_err)) {   
            $sql = "INSERT INTO attendees (student_number, event_id, payment) VALUES (?, ?, ?)";

            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("isi", $param_student_number, $param_event_id, $param_payment);

                $param_payment = $payment;
                $param_event_id = $event_id;
                $param_student_number = $student_number;

                if ($stmt->execute()) {
                    header("location: registration.php?event_id=".urlencode($event_id)."&payment=".urlencode($payment));
                } else {
                    echo "something went wrong ):";
                }
            }
            $stmt->close();
        } else {
            echo $student_number_err;
        }
        $mysqli->close();
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
            <a href="index.php"><button class="btn btn-danger">Back</button></a>
            <form method="post">
                <div class="form-group">
                    <label>Student Number</label>
                    <input type="number" name="student_number" class="form-control <?php echo (!empty($student_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $student_number?>"/>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            <h5>payment</h5>
            <p><?php echo $payment;?></p>
        </div>
    </div>
</body>
