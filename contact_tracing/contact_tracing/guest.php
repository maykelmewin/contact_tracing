<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        session_start();
        date_default_timezone_set("Asia/Manila");
	    $currentID = isset($_SESSION["currentID"]) ? $_SESSION["currentID"] : "0";
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Tracing - Guest</title>
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
            <li class="active"><a href="guest.php">Guest</a></li>
            <li><a href="event.php">Events</a></li>
            <li><a href="trace.php">Trace Now!</a></li>
            </ul>
        </div>
    </nav>
    <div class="body-guest">
        <?php
            include 'php/conn.php';
            $rs = mysqli_query($conn,"SELECT * FROM guest WHERE id = ".$currentID."");
            while ($row = mysqli_fetch_assoc($rs)){
        ?>
        <div class="detail">
            
            <div class="iconImg">
                <img src="./src/svg/logo.svg" alt="Logo Icon">
            </div>
            <div class="text">
                <h1><?php echo $row["name_first"];?> <?php echo $row["name_middle"];?> <?php echo $row["name_last"];?></h1>
                <h3><?php
                    //date in mm/dd/yyyy format; or it can be in other formats as well
                    $birthDate = $row["birthday"];
                    //explode the date to get month, day and year
                    $birthDate = explode("-", $birthDate);
                    //get age from date or birthdate
                    $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
                        ? ((date("Y") - $birthDate[0]) - 1)
                        : (date("Y") - $birthDate[0]));
                    echo $age;
                ?> years old</h3>
                <p><?php echo $row["contact_number"];?></p>
                <p><?php echo $row["address_street"];?> <?php echo $row["address_barangay"];?> <?php echo $row["address_municipality"];?> <?php echo $row["address_province"];?></p>
            </div>
            <div class="guestId">
                <h2>#<?php echo $row["id"];?></h2>
            </div>
           
        <div class="editDelete" id="editDelete">
            <p id="tracingLine" onclick="trace(<?php echo $currentID; ?>)">trace</p>
            <p onclick="editGuest()">edit</p>
            <p onclick="deleteGuest(<?php echo $currentID; ?>)">delete</p>
        </div>
        </div>
        <?php } ?>
        <div class="guest-show">
            <div class="title">
                <h3 id="tracedLine">guest</h3>
            </div>
            <div class="filter">
                <input type="text" placeholder="Search" id="myInputGuest"/>
            </div>
            <div class="blocks">
                <div id="searchDiv">
                    <div id="addGuest" class="p-2 add">
                        <p>+</p>
                    </div>
                    <?php
                        $rs = mysqli_query($conn,"SELECT * FROM guest");
                        while ($row = mysqli_fetch_assoc($rs)){
                    ?>
                    <div class="guest-block" onclick='showGuest(<?php echo $row["id"];?>)'>
                        <p><?php echo $row["id"];?> - <?php echo $row["name_last"];?>, <?php echo $row["name_first"];?> <?php echo $row["name_middle"];?></p>
                    </div>
                    <?php } ?>
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
    
    <div id="mySidenavEditGuest" class="sidenav sidenav-left">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNavs()">&times;</a>
        <form>
            <?php
                $rs = mysqli_query($conn,"SELECT * FROM guest WHERE id = $currentID");
                while ($row = mysqli_fetch_assoc($rs)){
            ?>
            <div class="container-form">
                <div class="title">
                    <h3>guest</h3>
                </div>
                <p>name</p>
                <input type="text" class="form-control" id="EguestNameF" value="<?php echo $row["name_first"];?>" placeholder="First Name" required/>
                <input type="text" class="form-control" id="EguestNameL" value="<?php echo $row["name_last"];?>" placeholder="Last Name" />
                <input type="text" class="form-control" id="EguestNameM" value="<?php echo $row["name_middle"];?>" placeholder="Middle Name" re1uired/>
                <p>Address</p>
                <input type="text" class="form-control" id="EguestAdrS" value="<?php echo $row["address_street"];?>" placeholder="Street" required/>
                <input type="text" class="form-control"  id="EguestAdrB" value="<?php echo $row["address_barangay"];?>" placeholder="Barangay" required/>
                <input type="text" class="form-control" id="EguestAdrM" value="<?php echo $row["address_municipality"];?>" placeholder="Municipality" required/>
                <input type="text" class="form-control" id="EguestAdrP" value="<?php echo $row["address_province"];?>" placeholder="Province" required/>
                <p>Contact Number</p>
                <input type="tel" class="form-control" id="EguestCNo" value="<?php echo $row["contact_number"];?>" maxlength="11" minlength="11" placeholder="09** *** ****" required/>
                <p>Email Address</p>
                <input type="email" class="form-control" id="EguestEmail" value="<?php echo $row["email"];?>" placeholder="@your.email" required/>
                <p>Birthday</p>
                <input type="date" class="form-control" id="EguestBday" value="<?php echo $row["birthday"];?>" required/>
                <button class="btn btn-block" onclick="saveEditGuest(<?php echo $currentID ?>)">Save Edit</button>
            </div>
            <?php }?>
            
        </form>
    </div>


    <div class="footer">
        <p>Contact Tracing 2020</p>
    </div>
    <script>

    </script>
</body>
</html>