<?php
$server = "X.X.X.X";
$username = "X";
$password = "X";
$db = "X";
$con = mysqli_connect($server, $username, $password, $db);
if ($con->connect_error) {
    die("Connection failed<br> " . $con->connection_error);
}

$date = $_GET["date"];

$sqlString = "SELECT `temp`, `hum`, `pres`, `time` FROM ";

if ($_GET["dev"] == "D1Mini_N") {
    $sqlString = $sqlString . "wetterDatenNiklas WHERE `date` = '" . $date . "'";
} else if ($_GET["dev"] == "D1Mini_F") {
    $sqlString = $sqlString . "wetterDatenFelix WHERE `date` = '" . $date . "'";
} else if ($_GET["dev"] == "D1Mini_P") {
    $sqlString = $sqlString . "wetterDatenPapa WHERE `date` = '" . $date . "'";
} else {
    $sqlString = $sqlString . "wetterDatenNiklas WHERE `date` = '" . $date . "'";
}

$res = mysqli_query($con, $sqlString);
$temp = "";
$hum = "";
$pres = "";
while ($daten = mysqli_fetch_assoc($res)) {
    $temp = $temp . "{ x:'" . substr($daten["time"], 0, 5) . "', y:" . $daten["temp"] . "}, ";
    $hum = $hum . "{ x:'" . substr($daten["time"], 0, 5) . "', y:" . $daten["hum"] . "}, ";
    $pres = $pres . "{ x:'" . substr($daten["time"], 0, 5) . "', y:" . $daten["pres"] . "}, ";
}


mysqli_close($con);
echo "function callChart() {
            var ctx = document.getElementById('chart').getContext('2d');
                    if(window.innerHeight < 850) {
                        document.getElementById('chart').width = window.innerWidth * 0.6;
                        document.getElementById('chart').height = window.innerHeight * 0.8;
                    } else {
                        document.getElementById('chart').width = window.innerWidth * 0.7;
                        document.getElementById('chart').height = window.innerHeight - 440;
                    }
                    if(window.innerHeight > window.innerWidth) {
                        document.getElementById('chart').width = window.innerWidth * 0.8;
                        document.getElementById('chart').height = window.innerWidth * 0.8;
                    }


                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            datasets: [{
                                label: 'Temperature',
                                backgroundColor: 'rgba(255, 30, 30, 0.4)',
                                borderColor: 'rgba(255, 30, 30, 0.2)',
                                borderJoinStyle: 'round',
                                fill: null,
                                yAxisID: 'temp',
                                data: [" . $temp . "]
                            },{
                                label: 'Humidity',
                                backgroundColor: 'rgba(30, 30, 255, 0.4)',
                                borderColor: 'rgba(30, 30, 255, 0.2)',
                                borderJoinStyle: 'round',
                                fill: null,
                                yAxisID: 'hum',
                                data: [" . $hum . "]
                            },{
                                label: 'Pressure',
                                backgroundColor: 'rgba(30, 255, 30, 0.4)',
                                borderColor: 'rgba(30, 255, 30, 0.2)',
                                borderJoinStyle: 'round',
                                fill: null,
                                yAxisID: 'pres',
                                data: [" . $pres . "]
                            }]
                        },
                        options: {
                            responsive: false,
                            scales: {
                                xAxes: [{
                                    type: 'time',
                                    time: {
                                        parser: 'HH:mm',
                                        unit: 'minutes',
                                        min: '00:00',
                                        max: '24:00',
                                        unitStepSize: 30,
                                        fontColor: 'rgba(255,255,255,0.8)',
                                        displayFormats: {
                                            'minutes': 'HH:mm'
                                        }
                                    }
                                }],
                                yAxes: [{
                                    id: 'temp',
                                    type: 'linear',
                                    position: 'left',
                                    ticks: {
                                    fontColor: 'rgba(255,30,30,0.8)',
                                    fontSize: 14
                                    },
                                    gridLines: {
                                        display: false,
                                        drawBorder: false
                                    }
                                },{
                                    id: 'hum',
                                    type: 'linear',
                                    position: 'left',
                                    ticks: {
                                    fontColor: 'rgba(30,30,255,0.8)',
                                    fontSize: 14
                                    },
                                    gridLines: {
                                        display: false,
                                        drawBorder: false
                                    }
                                },{
                                    id: 'pres',
                                    type: 'linear',
                                    position: 'right',
                                    ticks: {
                                    fontColor: 'rgba(30,255,30,0.8)',
                                    fontSize: 14
                                    },
                                    gridLines: {
                                        display: false,
                                        drawBorder: false
                                    }
                                }]
                            }
                        }
                    });
                }
                callChart();";




