<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    session_start();
    date_default_timezone_set("Asia/Manila");
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Tracing</title>
    <link rel="icon" href="./src/svg/logo.svg">
    
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/extra.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="./js/main.js"></script>
    <script src="./js/extra.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans:wght@900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="loader"></div>
    <div class="logoIcon top-right">
        <p id="logoIcon"><?php echo date("Y"); ?></p>
    </div>
    <div class="body-index">     
        <div class="heading">
            <h1><?php echo date("m"); ?>/<?php echo date("d"); ?></h1>
            <h2><?php echo date("Y"); ?> contact tracing</h2>
        </div>
        <div class="trace">
            <p id="trace">trace now!</p>
        </div>
        <div class="definition">
            <p>Contact tracing slows the spread of COVID-19.<br/>
                Contact tracing helps protect you, your family, and your community.</p>
        </div>
        <div class="buttons">
            <div>
                <button class="btn " id="guest">guests</button>
                <button class="btn " id="event">events</button>
            </div>
            <button class="btn btn-block" id="modal_trigger">attendance</button>
        </div>
    </div>
    <div id="myModal" class="modal">
        <div class="modal-content">
          <div class="modal-body">
           <span class="close">&times;</span>
                <p>Attendance for today's event</p>
                <?php
                    include 'php/conn.php';
                    $rs = mysqli_query($conn,"SELECT * FROM event WHERE DATE(event_date) = CURDATE()");
                    if (mysqli_num_rows($rs) > 0){
                ?>
                <table class="table table-hover">
                    <?php
                        while ($row = mysqli_fetch_assoc($rs)){
                    ?>     
                    <tr onclick='attendance(<?php echo $row["id"] ?>)' id="attendance">   
                        <td>ID: #<?php echo $row["id"];?></td>
                        <td><?php echo $row["name"];?></td>
                        <td><?php echo $row["location_barangay"];?> - <?php echo $row["location_municipality"];?></td>
                    </tr>
               
                <?php }?>
                </table>
                <?php } else {?>
                <div><p>No Event event today!</p></div>
                <?php } ?>
           
          </div>
        </div>
    </div>

</body>
</html>