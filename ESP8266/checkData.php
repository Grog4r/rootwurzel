<?php 

$server = "X.X.X.X";
$username = "X";
$password = "X";
$db = "X";
$con = mysqli_connect($server, $username, $password, $db);
if($con->connect_error) {
    die("Connection failed<br> " . $con->get_connection_stats());
}


if($_GET["dev"] == "D1Mini_N") {
    $sqlString = "SELECT `time` FROM wetterDatenNiklas ORDER BY ID DESC LIMIT 1";
    $res = mysqli_query($con,$sqlString);
    while ($data = mysqli_fetch_assoc($res)) {
        echo $data["time"];
    }
}


else if($_GET["dev"] == "D1Mini_F") {
    $sqlString = "SELECT `time` FROM wetterDatenFelix ORDER BY ID DESC LIMIT 1";
    $res = mysqli_query($con,$sqlString);
    while ($data = mysqli_fetch_assoc($res)) {
        echo $data["time"];
    }
}


else if($_GET["dev"] == "D1Mini_P") {
    $sqlString = "SELECT `time` FROM wetterDatenPapa ORDER BY ID DESC LIMIT 1";
    $res = mysqli_query($con,$sqlString);
    while ($data = mysqli_fetch_assoc($res)) {
        echo $data["time"];
    }
}
mysqli_close($con);

