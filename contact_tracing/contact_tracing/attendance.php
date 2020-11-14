<!DOCTYPE html>
<html lang="en">
<head>
    <?PHP 
        session_start();
        date_default_timezone_set("Asia/Manila");
        $currentAttID = isset($_SESSION["currentAttID"]) ? $_SESSION["currentAttID"] : "0";
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Tracing - Attendance</title>
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
<body class="attendance-body">
    <div class="loader"></div>
    <div class="logoIcon top-left" class="container-top">
        <p id="logoIcon"><?php echo date("Y"); ?></p>
    </div>
    <div class="top-right exit">
        <p id="back">exit</p>
    </div>
    <div class="body-attendance">
        <div class="event-detail">
            <?php
                include 'php/conn.php';
                $rs = mysqli_query($conn,"SELECT * FROM `event` WHERE id = ".$currentAttID."");
                while ($row = mysqli_fetch_assoc($rs)){
            ?>
            <div>
                <h1><?php echo $row["name"];?></h1>
                <p>event # <?php echo $row["id"];?></p>
            </div>
            <div>
                <h1><?php 
                    $eventDate = $row["event_date"];
                    echo date("m/d/y", strtotime($eventDate));
                ?></h1>
                <p><?php echo $row["location_barangay"];?> <?php echo $row["location_municipality"];?></p>
            </div>
                <?php } ?>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="search">
                        <form onsubmit="addParticipant(<?php echo $currentAttID ?>,'attendance')" autocomplete="off">
                        <input class="form-control" type="submit" value="Present" >
                        <input id="myInputParticipant" class="form-control" type="text" placeholder="Name" required>
                        <div class="autocomplete" >      
                        </div>    
                        
                        <p id="addGuestAttendance">+ New Guest</p>
                        </form>
                    </div>
                    <div class="other-event">

                
                        <h3>event today</h3>
                        <table class="table">
                            <?php
                                $rs = mysqli_query($conn,"SELECT * FROM `event` WHERE DATE(event_date) = CURDATE()");
                                while ($row = mysqli_fetch_assoc($rs)){
                            ?>
                            <tr onclick='showAttendance(<?php echo $row["id"];?>)'>
                                <td>#<?php echo $row["id"];?></td>
                                <td><?php echo $row["name"];?></td>
                                <td><?php echo $row["location_barangay"];?> - <?php echo $row["location_municipality"];?></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
                <div class="col-md-6 ">
                    <div class="participant">
                    <h2>participant</h2>
                        <table class="table">
                            <?php
                                $rs = mysqli_query($conn,"
                                SELECT event_attendance.id AS id,
                                guest.id AS GId,
                                guest.name_first AS fn,
                                guest.name_last AS ln,
                                guest.name_middle AS mn,
                                event.time AS et
                                FROM ((event_attendance
                                INNER JOIN event ON event_attendance.event_id = event.id)
                                INNER JOIN guest ON event_attendance.guest_id = guest.id)
                                where event_attendance.event_id = ".$currentAttID."
                                ");
                                while ($row = mysqli_fetch_assoc($rs)){
                            ?>
                            <tr>
                                <td onclick='guest(<?php echo $row["GId"];?>)'>ID: <?php echo $row["GId"];?></td>
                                <td onclick='guest(<?php echo $row["GId"];?>)'><?php echo $row["fn"];?> <?php echo $row["mn"];?> <?php echo $row["ln"];?></td>
                                <td onclick='guest(<?php echo $row["GId"];?>)'>7:19 </td>
                                <td onclick='deleteParticipant(<?php echo $row["GId"];?>,<?php echo $currentAttID?>)' class="deleteParticipant">Delete</td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="mySidenav" class="sidenav sidenav-left">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <form>
            <div class="container-form">
                <div class="title">
                    <h3>guest</h3>
                </div>
                <p>name</p>
                <input type="text" class="form-control" id="guestNameF" placeholder="First Name" required/>
                <input type="text" class="form-control" id="guestNameL" placeholder="Last Name" />
                <input type="text" class="form-control" id="guestNameM" placeholder="Middle Name" re1uired/>
                <p>Address</p>
                <input type="text" class="form-control" id="guestAdrS" placeholder="Street" required/>
                <input type="text" class="form-control" id="guestAdrB" placeholder="Barangay" required/>
                <input type="text" class="form-control" id="guestAdrM" placeholder="Municipality" required/>
                <input type="text" class="form-control" id="guestAdrP" placeholder="Province" required/>
                <p>Contact Number</p>
                <input type="tel" class="form-control" id="guestCNo" maxlength="11" minlength="11" placeholder="09** *** ****" required/>
                <p>Email Address</p>
                <input type="email" class="form-control" id="guestEmail" placeholder="@your.email" required/>
                <p>Birthday</p>
                <input type="date" class="form-control" id="guestBday" required/>
                <button class="btn btn-block" id="saveNewGuest">Save</button>
            </div>
        </form>
    </div>
    <script>
        var allGuest = [
            "+ Create New Guest"
            <?php
                $rs = mysqli_query($conn,"SELECT * FROM `guest`");
                while ($row = mysqli_fetch_assoc($rs)){
            ?>
            ,"<?php echo $row["name_first"];?> <?php echo $row["name_middle"];?> <?php echo $row["name_last"];?> - <?php echo $row["id"];?>"
            <?php }?>
        ];
        autocomplete(document.getElementById("myInputParticipant"), allGuest);
    </script>
</body>
</html>