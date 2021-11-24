<?php

$server = "X.X.X.X";
$username = "X";
$password = "X";
$db = "X";
$con = mysqli_connect($server, $username, $password, $db);
if($con->connect_error) {
    die("Connection failed<br> " . $con->connection_error);
}



echo "<table><tr><th>Device</th><th>Temperature</th><th>Humidity</th><th>Pressure</th><th>Timestamp</th></tr>";

$sqlString = "SELECT * FROM wetterDatenNiklas ORDER BY ID DESC LIMIT 1";
$res = mysqli_query($con,$sqlString);
while ($daten = mysqli_fetch_assoc($res)) {
    echo "<tr onclick='openDetails(`D1Mini_N`)'><td>D1Mini_N</td><td>" . number_format($daten["temp"], 2) . " °C</td><td>" . number_format($daten["hum"], 2) . " %</td><td>" . number_format($daten["pres"], 2) . " hPa</td><td>" . $daten["time"] . " " . $daten["date"] . "</td></tr>";
}

$sqlString = "SELECT * FROM wetterDatenFelix ORDER BY ID DESC LIMIT 1";
$res = mysqli_query($con,$sqlString);
while ($daten = mysqli_fetch_assoc($res)) {
    echo "<tr onclick='openDetails(`D1Mini_F`)'><td>D1Mini_F</td><td>" . number_format($daten["temp"], 2) . " °C</td><td>" . number_format($daten["hum"], 2) . " %</td><td>" . number_format($daten["pres"], 2) . " hPa</td><td>" . $daten["time"] . " " . $daten["date"] . "</td></tr>";
}

$sqlString = "SELECT * FROM wetterDatenPapa ORDER BY ID DESC LIMIT 1";
$res = mysqli_query($con,$sqlString);
while ($daten = mysqli_fetch_assoc($res)) {
    echo "<tr onclick='openDetails(`D1Mini_P`)'><td>D1Mini_P</td><td>" . number_format($daten["temp"], 2) . " °C</td><td>" . number_format($daten["hum"], 2) . " %</td><td>" . number_format($daten["pres"], 2) . " hPa</td><td>" . $daten["time"] . " " . $daten["date"] . "</td></tr>";
}

echo "</table>";
mysqli_close($con);

?>

