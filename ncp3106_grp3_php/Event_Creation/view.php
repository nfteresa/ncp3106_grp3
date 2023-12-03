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
                    }
                ?>
            </div>
        </div>
    </div>
</body>

</html>