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
            $event_name = $result["event_name"];
            $event_description = $result["event_description"];
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
<style>
  @font-face {
        font-family: myFirstFont;
        src: url("../font/Montserrat-VariableFont_wght.ttf");
  }
  body {
    background-image: url("./img/bg.png");
    background-size: cover;
    height: 100vh;
  }
  .container{
    display: flex;
    margin: auto;
    padding: 40px 0;
  }
  .left-box{
    width: 100%;
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3); 
    border-radius: 10px 0px 0px 10px; 
    height: 100%;
    background-size:cover ;
    background-image:url('./img/bg3.png');
    justify-content: center; 
    align-items: center; 
    max-height: 85vh;
    max-width: 85vw;
  }
  .left{
    text-align: center;
    padding: 200px 0;
  }
  .left h1,p{
    font-family: myFirstFont;
    color: white;
  }
  .left-box a{
    position: absolute; 
    top: 8px; 
    left: 16px; 
    width:50px; 
    height: 50px;
  }
  .left h1{
    font-weight:bold;
  }
  .right-box{
    width: 100%;
    height: 100%;
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3); 
    border-radius: 0px 10px 10px 0px; 
    background: rgba(246, 246, 242, 1);
    justify-content: center; 
    align-items: center; 
    margin: 0;
    max-height: 85vh;
    max-width: 85vw;
    overflow: scroll;
  }
  .right{
    padding: 50px;
    line-height: 1.8;
    margin: 0 auto;
    text-align: center;
    
  }
  .right label{
    font-weight: bold;
  }
  .right input, .right select, .right textarea{
    width: 100%; 
    padding:5px; 
    padding-left:5px; 
    border-radius: 5px; 
    border: 1px solid black
  }
  .right form{
    color: black;
    border-radius: 3px;
    margin-bottom: 15px;
    background: rgba(246, 246, 242, 1);
    width: 100%;
    line-height: 1.8; 
  }
  .right .btn{
    background-color: #013365; 
    border: #013365 solid;
    font-family: myFirstFont;
    font-weight: bold;
    outline: none !important;
  }
  .left img{
    
  }
  ::-webkit-scrollbar{
    display: none;
  }
</style>
</head>
<body>
    <div class="container h-100">
        <div class="container d-flex justify-content-center">
            <div class="col-md-6 px-0">
                <div class="left-box">
                    <a href="index.php"><img src="./img/back2.png" style="position: absolute; 
                        top: 8px; left: 16px; 
                        width:50px; 
                        height: 50px;"></a>
                    <div class="left">
                        <h1><?php echo $event_name ?></h1>
                        <p><?php echo $event_description ?></p>
                        <h1>payment</h1>
                        <p><?php echo $payment;?></p>
                    </div>
                </div>
                </div>
                <div class="col-md-6 px-0">
                <div class="right-box">
                    <div class="right d-flex justify-content-center align-items-center h-100">
                        <form method="post">
                            <div class="form-group">
                                <label>Student Number</label>
                                <input type="number" name="student_number" class="form-control <?php echo (!empty($student_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $student_number?>"/>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
