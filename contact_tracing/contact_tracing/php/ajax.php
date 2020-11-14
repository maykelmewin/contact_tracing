<?php
	session_start();
    include 'conn.php';
    
	$request = isset($_POST["request"]) ? $_POST["request"] : "";
    date_default_timezone_set("Asia/Manila");
    $t = time();
	$thisD = date("Y-m-d",$t);
    $thisT = date("h:i A",$t); 

    if($request == "addGuest"){

        $fn = $_POST["firstName"];
        $mn = $_POST["middleName"];
        $ln = $_POST["lastName"];
        $as = $_POST["street"];
        $ab = $_POST["barangay"];
        $am = $_POST["municipality"];
        $ap = $_POST["province"];
        $cn = $_POST["cNumber"];
        $em = $_POST["email"];
        $bd = $_POST["bday"];

        $newsql = "SELECT * FROM `guest` WHERE name_first='$fn' AND name_last='$ln' AND name_middle='$mn' AND birthday='$bd'";
        $newrs = mysqli_query($conn,$newsql);
        if(mysqli_num_rows($newrs) > 0){
            echo 'alert("Already Exist");'; 
        }else{
            mysqli_query($conn,"INSERT INTO `guest` (`name_first`,`name_middle`,`name_last`,`address_street`,`address_barangay`,`address_municipality`,`address_province`,`contact_number`,`email`,`birthday`,`date`,`time`)
            VALUES('$fn','$mn','$ln','$as','$ab','$am','$ap','$cn','$em','$bd','$thisD','$thisT')");
            echo 'alert("Added Succesfully");';
        }
		echo 'window.location.reload(true);';
    }

    if($request == "addEvent"){
        
        $en = $_POST["name"];
        $ls = $_POST["street"];
        $lb = $_POST["barangay"];
        $lm = $_POST["municipality"];
        $lp = $_POST["province"];
        $ed = $_POST["date"];

        $newsql = "SELECT * FROM `event` WHERE name='$en' AND location_street='$ls' AND location_barangay='$lb' AND location_municipality='$lm' AND location_province='$lp' AND event_date='$ed'";
        $newrs = mysqli_query($conn,$newsql);
        if(mysqli_num_rows($newrs) > 0){
            echo 'alert("Already Exist");'; 
        }else{
            mysqli_query($conn,"INSERT INTO `event` (`name`,`location_street`,`location_barangay`,`location_municipality`,`location_province`,`event_date`,`date`,`time`)
            VALUES('$en','$ls','$lb','$lm','$lp','$ed','$thisD','$thisT')");
            echo 'alert("Added Succesfully");';
        }
		echo 'window.location.reload(true);';
    }

    if($request == "editGuest"){
        $id = $_POST["id"];
        $fn = $_POST["firstName"];
        $mn = $_POST["middleName"];
        $ln = $_POST["lastName"];
        $as = $_POST["street"];
        $ab = $_POST["barangay"];
        $am = $_POST["municipality"];
        $ap = $_POST["province"];
        $cn = $_POST["cNumber"];
        $em = $_POST["email"];
        $bd = $_POST["bday"];

        $newsql = "UPDATE `guest` SET `name_first` = '$fn' , `name_middle` = '$mn' , `name_last` = '$ln' , `address_street` = '$as' , `address_barangay` = '$ab' , `address_municipality` = '$am' , `address_province` = '$ap' , `contact_number` = '$cn' , `email` = '$em' , `birthday` = '$bd' WHERE id = $id";
        $newrs = mysqli_query($conn,$newsql);
        if ($newrs == true) {
			echo "alert('Edit Saved');";
		} else {
		echo "alert('Error Edit');";
		}
		echo 'window.location.reload(true);';
    }

    if($request == "editEvent"){
        $id = $_POST["id"];
        $en = $_POST["name"];
        $ls = $_POST["street"];
        $lb = $_POST["barangay"];
        $lm = $_POST["municipality"];
        $lp = $_POST["province"];
        $ed = $_POST["date"];

        $newsql = "UPDATE `event` SET `name` = '$en' , `location_street` = '$ls' , `location_barangay` = '$lb' , `location_municipality` = '$lm' , `location_province` = '$lp' , `event_date` = '$ed' WHERE id = $id";
        $newrs = mysqli_query($conn,$newsql);
        if ($newrs == true) {
			echo "alert('Edit Saved');";
		} else {
		echo "alert('Error Edit');";
		}
		echo 'window.location.reload(true);';
    }
    
    if($request == "deleteGuest"){
        $id = $_POST["id"];
        $f_sql = "DELETE FROM guest WHERE id = $id";
		$f_rs = mysqli_query($conn,$f_sql);
		if ($f_rs == true) {
			echo 'alert("Already Removed");';
		}else {
			echo 'alert("Error Removed");';
		}
        
        $f_sql = "DELETE FROM event_attendance WHERE guest_id = $id";
		$f_rs = mysqli_query($conn,$f_sql);
		if ($f_rs == true) {
			echo 'alert("Attendance Already Removed");';
		}else {
			echo 'alert("Error Attendance Removed");';
		}
		echo 'window.location.reload(true);';
    }
    
    if($request == "deleteEvent"){
        $id = $_POST["id"];
        $f_sql = "DELETE FROM event WHERE id = $id";
		$f_rs = mysqli_query($conn,$f_sql);
		if ($f_rs == true) {
			echo 'alert("Already Removed");';
		}else {
			echo 'alert("Error Removed");';
        }
        
        $f_sql = "DELETE FROM event_attendance WHERE event_id = $id";
		$f_rs = mysqli_query($conn,$f_sql);
		if ($f_rs == true) {
			echo 'alert("Attendance Already Removed");';
		}else {
			echo 'alert("Error Attendance Removed");';
		}
		echo 'window.location.reload(true);';
    }
    
    if($request == "deleteParticipant"){
        $gid = $_POST["gid"];
        $eid = $_POST["eid"];
        $f_sql = "DELETE FROM event_attendance WHERE guest_id = $gid AND event_id = $eid";
		$f_rs = mysqli_query($conn,$f_sql);
		if ($f_rs == true) {
			echo 'alert("Already Removed");';
		}else {
			echo 'alert("Error Removed");';
        }
        
		echo 'window.location.reload(true);';
    }

    if($request == "addParticipant"){

        $eid = $_POST["eid"];
        $gid = $_POST["gid"];
        $rem = $_POST["rem"];

        $newsql = "SELECT * FROM `event_attendance` WHERE guest_id='$gid' AND event_id='$eid'";
        $newrs = mysqli_query($conn,$newsql);
        if(mysqli_num_rows($newrs) > 0){
            echo 'alert("Already Exist");'; 
        }else{
            mysqli_query($conn,"INSERT INTO `event_attendance` (`guest_id`,`event_id`,`comment`,`date`,`time`)
            VALUES('$gid','$eid','$rem','$thisD','$thisT')");
            echo 'alert("Added Succesfully");';
        }
		echo 'window.location.reload(true);';
    }
?>
