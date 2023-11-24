<?php
    if(isset($_POST['ids']) && !empty($_POST['ids'])){
        //this contains all the values of the checkboxes that were ticked at form submission.
        $ids = $_POST["ids"];
        $url_ids = "";
        //package array into string
        while (count($ids)) {
            $temp = array_pop($ids);
            $url_ids = $url_ids . $temp . ",";
        }
        // send user to delete_confirmation.php with the ids url-encoded.
        header("location: delete_confirmation.php?ids=".urlencode($url_ids));
    } else {
        // error message here
        echo "Something went wrong. Please try again later.";
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
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

        table tr td:last-child {
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        function confirm() {
            var array = [];
            var checkboxes = document.querySelectorAll('input[type=checkbox]:checked');

            for (var i = 0; i < checkboxes.length; i++) {
                array.push(checkboxes[i].value);
            }

            return checkboxes;
        }
    </script>

</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <!-- the whole table as well as the button at the bottom is a form -->
            <a href="index.php"><button class="btn btn-danger">Back</button></a>
            <form method = "post">
                <?php
                require_once '../config.php';

                $sql = "SELECT * FROM event_info";
                if ($result = $mysqli->query($sql)) {
                    if($result->num_rows > 0) {
                        echo '<table class="table table-bordered table-striped">';
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>amongus</th>";
                        echo "<th>#</th>";
                        echo "<th>event_name</th>";
                        echo "<th>event_description</th>";
                        echo "<th>date</th>";
                        echo "<th>start_time</th>";
                        echo "<th>end_time</th>";
                        echo "<th>registration_fee</th>";
                        echo "<th>venue</th>";
                        echo "<th>oic</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while ($rows = $result->fetch_array()) {
                            echo "<tr>";
                            echo '<td><input type ="checkbox" name = "ids[]" id = "'. $rows["event_id"].' "value = "'. $rows["event_id"].'"></input></td>';
                            echo "<td>" . $rows['event_id'] . "</td>";
                            echo "<td>" . $rows['event_name'] . "</td>";
                            echo "<td>" . $rows['event_description'] . "</td>";
                            echo "<td>" . $rows['date'] . "</td>";
                            echo "<td>" . $rows['start_time'] . "</td>";
                            echo "<td>" . $rows['end_time'] . "</td>";
                            echo "<td>" . $rows['registration_fee'] . "</td>";
                            echo "<td>" . $rows['venue'] . "</td>";
                            echo "<td>" . $rows['oic'] . "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        // Free result set
                        $result->free();

                    } else {

                    }
                } else {

                }
                ?>
                <input type="submit" value="Delete"/>
            </form>
        </div>
    </div>
</body>

