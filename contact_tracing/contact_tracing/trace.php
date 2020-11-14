<!DOCTYPE html>
<html lang="en">
<head>
    <?PHP 
        session_start();
        date_default_timezone_set("Asia/Manila");
        $currentTraceID = isset($_SESSION["currentTraceID"]) ? $_SESSION["currentTraceID"] : "0";
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Tracing - Trace Now</title>
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
            <li><a href="event.php">Events</a></li>
            <li class="active"><a href="trace.php">Trace Now!</a></li>
            </ul>
        </div>
    </nav>
    <div class="body-trace">
        <div class="title">
            <h3>now tracing ...</h3>
        </div>
        <div class="search">
            <form id="tracingLine" onsubmit="tracing()" autocomplete="off">
                <input  type="submit" value="Trace" >
                <div class="autocomplete" >
                <input id="myInputTrace"  type="text" placeholder="Name" required>
                </div>
            </form>
        </div>
        <div class="detail-trace">
            <?php
                include 'php/conn.php';
                $rs = mysqli_query($conn,"SELECT * FROM `event_attendance` WHERE guest_id = ".$currentTraceID.""); 
                
                if($currentTraceID != "0"){
            ?>
            <div class="ta">
                <h1><?php echo mysqli_num_rows($rs);?></h1>
                <p>attended events</p>
            </div>
            <?php
                }
                $rs = mysqli_query($conn,"SELECT * FROM `guest` WHERE id = ".$currentTraceID."");
                while ($row = mysqli_fetch_assoc($rs)){
            ?>
            <div class="imgLogo">
                <img src="./src/svg/logo.svg" alt="Logo Icon">
            </div>
            <div class="traced_detail">
                <div class="text">
                    <p><?php echo $row["name_first"];?> <?php echo $row["name_middle"];?> <?php echo $row["name_last"];?></p>
                    <p>id:<?php echo $row["id"];?></p>
                    <p><?php echo $row["contact_number"];?></p>
                    <p><?php echo $row["address_province"];?></p>
                </div>
            </div>
            <?php
                }
                $rs = mysqli_query($conn,"
                SELECT
                guest.id AS gid,
                guest.name_first As fn,
                guest.name_middle As mn,
                guest.name_last As ln,
                t2.date AS cd,
                event.id as eid,
                event.location_province AS lp,
                event.name as en
                FROM event_attendance t1 INNER JOIN event_attendance t2 ON t1.event_id = t2.event_id 
                INNER JOIN event ON t2.event_id = event.id
                INNER JOIN guest ON t2.guest_id = guest.id
                WHERE t1.guest_id = ".$currentTraceID." AND NOT T2.guest_id = ".$currentTraceID."
                GROUP BY t2.guest_id
                ");
                
                if($currentTraceID != "0"){
            ?>
            <div class="cp">
                <h1><?php echo mysqli_num_rows($rs);?></h1>
                <p>contact person</p>
            </div>
                <?php }?>
        </div>
        <div id="tracedLine" class="contact-person">
            <h3>Contacted Person</h3>
            <table class="table table-hover">
                <?php
                    while ($row = mysqli_fetch_assoc($rs)){
                ?>
                <tr>
                    <td><img src="./src/svg/logo.svg" alt="Logo Icon"></td>
                    <td class="td-guest" onclick='guest(<?php echo $row["gid"];?>)'>ID: <?php echo $row["gid"];?> - <?php echo $row["fn"];?> <?php echo $row["mn"];?> <?php echo $row["ln"];?></td>
                    <td><?php 
                        $eventDate = $row["cd"];
                        echo date("m/d/y", strtotime($eventDate));
                    ?></td>
                    <td class="td-event" onclick='gotoEvent(<?php echo $row["eid"];?>)'>#<?php echo $row["eid"];?> <?php echo $row["en"];?> - <?php echo $row["lp"];?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal">
        <div class="modal-content">
          <div class="modal-body">
           <span class="close">&times;</span>
           <p>Guest</p>
            <table>
                <tr>
                    <td>ID:01</td>
                    <td>Michael Merin</td>
                    <td>Bunsuran 1st</td>
                </tr>
            </table>
          </div>
        </div>
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
        autocomplete(document.getElementById("myInputTrace"), allGuest);
    </script>
</body>
</html>