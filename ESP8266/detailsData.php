<?php

$server = "X.X.X.X";
$username = "X";
$password = "X";
$db = "X";
$con = mysqli_connect($server, $username, $password, $db);
if($con->connect_error) {
    die("Connection failed<br> " . $con->connection_error);
}



echo "<table id='dataTable'><tr><th>Device</th><th>Temperature</th><th>Humidity</th><th>Pressure</th><th>Timestamp</th><th>Temperature Karlsruhe</th></tr>";

if($_GET["dev"] == "D1Mini_N") {
    $sqlString = "SELECT * FROM wetterDatenNiklas ORDER BY ID DESC LIMIT 1";
    $res = mysqli_query($con,$sqlString);
    $temp_ka_url = "http://api.openweathermap.org/data/2.5/weather?q=Karlsruhe&appid=XXXXXXXXXXXXXXXXXXX&units=metric";
    $contents = file_get_contents($temp_ka_url);
    $json_obj = json_decode($contents);
    $main = $json_obj->main;
    $temp_ka = $main->temp . " °C";
    while ($daten = mysqli_fetch_assoc($res)) {
        echo "<tr onclick='overview()'><td>D1Mini_N</td><td>" . number_format($daten["temp"], 2) . " °C</td><td>" . number_format($daten["hum"], 2) . " %</td><td>" . number_format($daten["pres"], 2) . " hPa</td><td>" . $daten["time"] . " " . $daten["date"] . "</td><td>" . $temp_ka . "</td></tr>";
    }
}


else if($_GET["dev"] == "D1Mini_F") {
    $sqlString = "SELECT * FROM wetterDatenFelix ORDER BY ID DESC LIMIT 1";
    $res = mysqli_query($con,$sqlString);
    while ($daten = mysqli_fetch_assoc($res)) {
        echo "<tr onclick='overview()'><td>D1Mini_F</td><td>" . number_format($daten["temp"], 2) . " °C</td><td>" . number_format($daten["hum"], 2) . " %</td><td>" . number_format($daten["pres"], 2) . " hPa</td><td>" . $daten["time"] . " " . $daten["date"] . "</td></tr>";
    }
}


else if($_GET["dev"] == "D1Mini_P") {
    $sqlString = "SELECT * FROM wetterDatenPapa ORDER BY ID DESC LIMIT 1";
    $res = mysqli_query($con,$sqlString);
    while ($daten = mysqli_fetch_assoc($res)) {
        echo "<tr onclick='overview()'><td>D1Mini_P</td><td>" . number_format($daten["temp"], 2) . " °C</td><td>" . number_format($daten["hum"], 2) . " %</td><td>" . number_format($daten["pres"], 2) . " hPa</td><td>" . $daten["time"] . " " . $daten["date"] . "</td></tr>";
    }
}


echo "</table>";
mysqli_close($con);

?>

