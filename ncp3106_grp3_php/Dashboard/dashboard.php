<?php
// Include config file
require_once 'config.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1em;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 2em;
        }

        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 1em;
            
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1em;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

    <header>
        <h1>Dashboard</h1>
    </header>

    <div class="container">
        <div class="form-group">

        <button type="button" onclick="location.href='./././create.php'" >STUDENT REGISTRATION
        

        <div class="form-group">

            <button type="button" onclick="location.href='./././create.php'"> ATTENDEE REGISTRATION
            <tr>
            
        <div class="form-group">
            <button type="button" onclick="location.href='./././index.php'" >EVENT CREATION
            <div class="form-group">

            <button type="button" onclick="location.href='./././event_list.php'" > REPORT GENERATION
        </div>


        </div>
    </div>

    <footer>
        <p>&copy; Aanhin mo ang kabayo kung wala namang damo</p>
    </footer>
    

</body>
</html>