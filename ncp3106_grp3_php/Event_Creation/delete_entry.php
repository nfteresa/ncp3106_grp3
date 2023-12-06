<?php
require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_GET["event_id"];
    $id_err = "";
    if (!is_numeric($id)) {
        $id_err = "Invalid ID.";
    }

    if(empty($id_err)) {
        $sql = "DELETE FROM event_info WHERE event_id = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("i", $param_id);
            (int) $param_id = $id;
            if ($stmt->execute()) {
                header("location: index.php?".$param_id);
            } else {
                header("location: error.php");
            }
        } else {
            echo "query preparation failed";
        }
    } else {
        echo $id_err;
    }
}
?>

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

            $event_id = $_GET['event_id'];
            $sql = "SELECT * FROM event_info WHERE event_id = ? ";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("i", $event_id);  
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                }
            }

            $rows = $result->fetch_array();
            echo '<a href="view.php?event_id='.$event_id.'&flag=view"><button class="btn btn-danger">Back</button></a>';
            echo "<h1>ARE YOU SURE YOU WANT TO DELETE THIS ENTRY?</h1>";
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
            echo "<form method='post'>";
            echo "<button type='submit' class='btn btn-danger'> DELETE </button>";
            ?>  
        </div>
    </div>
</body>