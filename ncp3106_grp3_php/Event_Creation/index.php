<?php
    require_once "../config.php";

    $search = "";
    $input_search = "";
    $search_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once '../config.php';

        $input_search = trim($_POST["search"]);
        $search = $input_search;
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
            <a href="../Dashboard/dashboard.html"><button class="btn btn-danger">Back</button></a>
            <form method="post">
                <div class="form-group">
                    <label>Search</label>
                    <input type="text" name="search" class="form-control <?php echo (!empty($search_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $search?>"/>
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            <a href="create.php"><button class="btn btn-primary">Create</button></a>
            <a href="delete.php"><button class="btn btn-danger">Delete</button></a>
            <?php
            if (!empty($search)) {
                $sql = "SELECT * FROM event_info WHERE event_name LIKE ?";

                if ($stmt = $mysqli->prepare($sql)) {
                    $stmt->bind_param("s", $param_search);
                    $param_search = "%" . $search  . "%";
                    if ($stmt->execute()) {
                        $result = $stmt->get_result();
                    } else {
                        echo "search failed";
                    }
                }
                $stmt->close();
            } else {
                $sql = "SELECT * FROM event_info";
                if ($stmt = $mysqli->prepare($sql)) {
                    if ($stmt->execute()) {
                        $result = $stmt->get_result();
                    } else {
                        echo "search failed";
                    }
                }
                $stmt->close();
            }

            if (!empty($result)) {
                if ($result->num_rows > 0) {
                    echo "<div class='row row-cols-1 row-cols-md-3 g-4'>";
                    while ($rows = $result->fetch_array()) {
                        echo "<div class='col mt-3'>";
                        echo "<div class='card h-100'>";
                        echo "<div class='card-body position-relative'>";         
                        echo "<a class='stretched-link' href='view.php?event_id=".urlencode($rows['event_id'])."&flag=view'></a>";
                        echo "<h5 class='card-title'>".$rows['event_name']."</h5>";
                        echo "<p class='card-text'>".$rows['event_description']."</p>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
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
