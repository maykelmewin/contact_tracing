<!DOCTYPE html>
<html lang="en">
<head>
    <?PHP 
        session_start();
        date_default_timezone_set("Asia/Manila");
        $currentEventID = isset($_SESSION["currentEventID"]) ? $_SESSION["currentEventID"] : "0";
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Tracing - Event</title>
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
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header logoIcon">
            <p id="logoIcon"><?php echo date("Y"); ?></p>
            </div>
            <ul class="nav navbar-nav navbar-right">
            <li><a href="guest.php">Guest</a></li>
            <li  class="active"><a href="event.php">Events</a></li>
            <li><a href="trace.php">Trace Now!</a></li>
            </ul>
        </div>
    </nav>
    <div class="body-event">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <?php
                        include 'php/conn.php';
                        $rs = mysqli_query($conn,"SELECT * FROM `event` WHERE id = ".$currentEventID."");
                        while ($row = mysqli_fetch_assoc($rs)){
                    ?>
                    <div id="tracingLine" class="show-detail">
                        <div class="event-number">
                            <p>#<?php echo $row["id"];?></p>
                        </div>
                        <div class="text">
                            <h2 id="dateEvent"><?php 
                                $eventDate = $row["event_date"];
                                echo date("m/d/y", strtotime($eventDate));
                            ?></h1>
                            <h1><?php echo $row["name"];?></h1>
                            <p><?php echo $row["location_street"];?> <?php echo $row["location_barangay"];?> <?php echo $row["location_municipality"];?> <?php echo $row["location_province"];?></p>
                        </div>
                    
                        <div class="buttons">
                            <?php 
                                $dateToday = date("Y-m-d");
                                if($dateToday == $row["event_date"]){
                            ?>
                           <p onclick="attendance(<?php echo $currentEventID ?>)">Attendance</p>
                            <?php } ?>
                            <p onclick="editEvent()">edit</p>
                            <p onclick="deleteEvent(<?php echo $currentEventID ?>)">delete</p>
                        </div>
                    </div>
                    <?php
                    }
                    $rs = mysqli_query($conn,"SELECT event_attendance.id AS id,
                    guest.id AS GId,
                    guest.name_first AS fn,
                    guest.name_last AS ln,
                    guest.name_middle AS mn,
                    guest.address_barangay AS ab,
                    guest.address_municipality AS am
                    FROM ((event_attendance
                    INNER JOIN event ON event_attendance.event_id = event.id)
                    INNER JOIN guest ON event_attendance.guest_id = guest.id)
                    where event_attendance.event_id = ".$currentEventID."
                    ");
                    ?>
                    <div id="tracedLine" class="participant-section">
                        <?php
                        if($currentEventID != "0"){ ?>
                        <h3><?php echo mysqli_num_rows($rs);?> participants</h3>
                        <form class="hideEditEvent" autocomplete="off">
                            <input onclick="addParticipantEdit(<?php echo $currentEventID ?>,'added-only');" type="submit" value="Add" >
                            <div class="autocomplete">
                            <input id="myInputParticipantEdit" type="text" placeholder="Name" required>
                            </div>
                        </form>
                        <?php }  ?>
                        <table class="table table-hover">
                            <?php
                                while ($row = mysqli_fetch_assoc($rs)){
                            ?>
                            <tr>
                                <td>#<?php echo $row["GId"];?></td>
                                <td><?php echo $row["fn"];?> <?php echo $row["mn"];?> <?php echo $row["ln"];?></td>
                                <td><?php echo $row["ab"];?> - <?php echo $row["am"];?></td>
                                <td><p class="hideEditEvent" onclick='deleteParticipant(<?php echo $row["GId"];?>,<?php echo $currentEventID;?>)' >Remove</p></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                   
                </div>
                <div class="col-md-6 right-event">
                    <div class="title"><h3>events</h3></div>
                    <div class="check-box">
                        
                    <input id="myInputEventsFilter" type="text" placeholder="Search..">
                    </div>
                    <div class="event-detail">
                        <button class="btn btn-block" id="openNav">+ add event</button>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>name</th>
                                    <th>date</th>
                                    <th>location</th>
                                </tr>
                            </thead>
                            <tbody id="myTable">
                                <?php 
                                    $rs = mysqli_query($conn,"SELECT * FROM `event`
                                    ORDER BY
                                        CASE WHEN `event_date` = CURRENT_DATE() 
                                        THEN `event_date` END desc,
                                        `event_date` ASC
                                    ");
                                    while ($row = mysqli_fetch_assoc($rs)){
                                ?>
                                <tr onclick='showEvent(<?php echo $row["id"];?>)'>
                                    <td><?php echo $row["id"];?></td>
                                    <td><?php echo $row["name"];?></td>
                                    <td><?php echo date("m/d/Y", strtotime($row["event_date"]));?></td>
                                    <td><?php echo $row["location_barangay"];?> - <?php echo $row["location_municipality"];?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="mySidenav" class="sidenav sidenav-right">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <form>
            <div class="container-form">
                <div class="title">
                    <h3>events</h3>
                </div>
                <p>name</p>
                <input type="text" class="form-control" id="eventName" placeholder="Event Name" required/>
                <p>location</p>
                <input type="text" class="form-control" id="eventLocationS" placeholder="Street" required/>
                <input type="text" class="form-control" id="eventLocationB" placeholder="Barangay" required/>
                <input type="text" class="form-control" id="eventLocationM" placeholder="Municipality" required/>
                <input type="text" class="form-control" id="eventLocationP" placeholder="Province" required/>
                <p>date</p>
                <input type="date" class="form-control" id="eventDate" required/>
                
                <button class="btn btn-block" id="saveNewEvent">save</button>
            </div>
        </form>
    </div>
    <div id="mySidenavEditEvent" class="sidenav sidenav-right">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNavsEditEvent()">&times;</a>
        <form>
            <?php
                $rs = mysqli_query($conn,"SELECT * FROM `event` WHERE id = $currentEventID");
                while ($row = mysqli_fetch_assoc($rs)){
            ?>
            
            <div class="container-form">
            <div class="title">
                <h3>Event</h3>
            </div>
                <p>name</p>
                <input type="text" class="form-control" id="EeventName" value="<?php echo $row["name"];?>" placeholder="Event Name" required/>
                <p>location</p>
                <input type="text" class="form-control" id="EeventLocationS" value="<?php echo $row["location_street"];?>" placeholder="Street" required/>
                <input type="text" class="form-control" id="EeventLocationB" value="<?php echo $row["location_barangay"];?>" placeholder="Barangay" required/>
                <input type="text" class="form-control" id="EeventLocationM" value="<?php echo $row["location_municipality"];?>" placeholder="Municipality" required/>
                <input type="text" class="form-control" id="EeventLocationP" value="<?php echo $row["location_province"];?>" placeholder="Province" />
                <p>date</p>
                <input type="date" class="form-control" id="EeventDate" value="<?php echo $row["event_date"];?>" required/>
                <button class="btn btn-block" onclick="saveEditEvent(<?php echo $currentEventID?>)">Save Edit</button>
            </div>  
            <?php }?>
        </form>
    </div>
    <div class="footer">
        <p>Contact Tracing 2020</p>
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
        autocomplete(document.getElementById("myInputParticipantEdit"), allGuest);
    </script>
</body>
</html>