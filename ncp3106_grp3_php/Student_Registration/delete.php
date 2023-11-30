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

                $sql = "SELECT * FROM stud_info";
                if ($result = $mysqli->query($sql)) {
                    if($result->num_rows > 0) {
                        echo '<table class="table table-bordered table-striped">';
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>amongus</th>";
                        echo "<th>#</th>";
                        echo "<th>first_name</th>";
                        echo "<th>last_name</th>";
                        echo "<th>middle_initial</th>";
                        echo "<th>student_number</th>";
                        echo "<th>program</th>";
                        echo "<th>current_year</th>";
                        echo "<th>ue_email</th>";
                        echo "<th>contact_number</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while ($rows = $result->fetch_array()) {
                            echo "<tr>";
                            echo '<td><input type ="checkbox" name = "ids[]" id = "'. $rows["stud_id"].' "value = "'. $rows["stud_id"].'"></input></td>';
                            echo "<td>" . $rows['stud_id'] . "</td>";
                            echo "<td>" . $rows['first_name'] . "</td>";
                            echo "<td>" . $rows['last_name'] . "</td>";
                            echo "<td>" . $rows['middle_initial'] . "</td>";
                            echo "<td>" . $rows['student_number'] . "</td>";
                            echo "<td>" . $rows['program'] . "</td>";
                            echo "<td>" . $rows['current_year'] . "</td>";
                            echo "<td>" . $rows['ue_email'] . "</td>";
                            echo "<td>" . $rows['contact_number'] . "</td>";
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
