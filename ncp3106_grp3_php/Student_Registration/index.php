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
    </script>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <?php
            require_once 'C:\Users\Neilf\Downloads\xaamp\phpMyAdmin\htmlforms\crud\config.php';

            $sql = "SELECT * FROM stud_info";
            if ($result = $mysqli->query($sql)) {
                if($result->num_rows > 0) {
                    echo '<table class="table table-bordered table-striped">';
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>#</th>";
                        echo "<th>First Name</th>";
                        echo "<th>Last Name</th>";
                        echo "<th>Middle Initial</th>";
                        echo "<th>Student Number</th>";
                        echo "<th>Program</th>";
                        echo "<th>Current</th>";
                        echo "<th>Email</th>";
                        echo "<th>Contact Number</th>";
                        echo "<th>Actions </th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while ($rows = $result->fetch_array()) {
                            echo "<tr>";
                            echo "<td>" . $rows['stud_id'] . "</td>";
                            echo "<td>" . $rows['first_name'] . "</td>";
                            echo "<td>" . $rows['last_name'] . "</td>";
                            echo "<td>" . $rows['middle_initial'] . "</td>";
                            echo "<td>" . $rows['student_number'] . "</td>";
                            echo "<td>" . $rows['program'] . "</td>";
                            echo "<td>" . $rows['current_year'] . "</td>";
                            echo "<td>" . $rows['ue_email'] . "</td>";
                            echo "<td>" . $rows['contact_number'] . "</td>";
                            echo "<td>
                            <div class='btn-group'>
                                <a class='btn btn-secondary' href='/edit.php?id=" .$rows['stud_id']."' > EDIT <a>
                                <a class='btn btn-danger' href='/delete.php??id=" .$rows['stud_id']."'> DELETE <a>
                                </div>
                            </td>";    
                            echo "</tr>";
                       
                    }
                    echo "</tbody>";
                    echo "</table>";
                    // Free result set
                    $result->free();

                } else {
                    //error message here if $result doesnt have rows
                    echo "no rows found";
                }
            } else {
                // error message here if we didnt get a $result
                echo "no results found";
            }
            ?>
        </div>
    </div>
</body>
                
