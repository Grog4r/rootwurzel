<!DOCTYPE HTML>
<html>

<head>
    <link rel="stylesheet" href="styleDetails.css">
    <link rel="shortcut icon" href="../favicon.png">
    <meta charset="utf-8" />
    <script src="script.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js"></script>
</head>

<body>
    <header>
        <div id="box" onclick="home()">
            <div id="root">&lt;&#47;root&gt;</div>
        </div>
        <div id="menu">
            <ul>
                <li><a href="/projects.html">Projects</a></li>
                <li><a href="">Gallery</a></li>
                <li><a href="">About</a></li>
                <li><a href="">Contact</a></li>
            </ul>
        </div>
    </header>

    <?php
        function dateIsToday() {
            $date = $_POST["date"];
            if(is_null($date)) {
                $date = date("d.m.Y");
            }
            return ($date == date("d.m.Y") ? "true" : "false");
        }
    ?>

    <main>
        <div id="mainContent">
            <h1>WeatherData:</h1>
            <div id="output"></div>
            <h1>Chart:</h1>
            <div id="chartDiv">
                <canvas id="chart" width="800" height="480"></canvas>
                <script>
                    function createChart() {
                            <?php if(isset($_POST["date"])) {
                                $date = "'&date=" . $_POST["date"] . "'";
                            } else {
                                $date = "'&date=" . date("d.m.Y") . "'";
                            }
                            ?>
                        let get_url = 'getChartData.php?dev=' + <?php echo "'" . $_GET["dev"] . "'"?> + <?php echo $date ?>;
                    
                        $.ajax({
                            type: 'GET',
                            url: get_url,
                            success: function (data) {
                                var g = document.createElement("script");
                                var s = document.getElementsByTagName('script')[0];
                                g.text = data;
                                s.parentNode.insertBefore(g, s);
                            }
                        });
                    }

                    function getData() {
                        $.ajax({
                            type: 'GET',
                            url: 'detailsData.php?dev=' + <?php echo "'" . $_GET["dev"] . "'" ?>,
                            success: function(data) {
                                $('#output').html(data);
                            }
                        });
                    }

                    function checkData(handleData) {
                        $.ajax({
                            type: 'GET',
                            url: 'checkData.php?dev=' + <?php echo "'" . $_GET["dev"] . "'" ?>,
                            success: function(data) {
                                handleData(data);
                            }
                        });
                    }

                    

                    $(document).ready(function() {
                        window.sessionStorage.setItem("timestamp", "00:00:00");
                        checkData(function(data) {
                                if(data === window.sessionStorage.getItem("timestamp")) {
                                    console.log("No new data.");
                                } else {
                                    console.log("Loading new data.");
                                    getData();
                                    createChart();
                                    window.sessionStorage.setItem("timestamp", data);
                                }
                        });

                        setInterval(function () {
                            console.log("Checking new data...");
                            if(<?php echo dateIsToday() ?>) {
                                console.log("Date is today.");
                                checkData(function(data) {
                                    if(data === window.sessionStorage.getItem("timestamp")) {
                                        console.log("data: " + data);
                                        console.log("session timestamp: " + window.sessionStorage.getItem("timestamp"))
                                        console.log("No new data.");
                                    } else {
                                        console.log("Loading new data.");
                                        getData();
                                        createChart();
                                        window.sessionStorage.setItem("timestamp", data);
                                    }
                                });
                            } else {
                                console.log("Date in past, no need to look for new data.");
                            }
                        }, 20000);  // will refresh the data every 20 sec

                    });

                </script>
            </div>

            <div id="days">
                <form action="details.php?dev=<?php echo $_GET["dev"] ?>" method="post">
                    <p> Choose day to inspect:<br><br>
                        <select name="date" class="inputs">
                            <?php
                            $server = "X.X.X.X";
                            $username = "X";
                            $password = "X";
                            $db = "X";
                            $con = mysqli_connect($server, $username, $password, $db);
                            if($con->connect_error) {
                                die("Connection failed<br> " . $con->connection_error);
                            }

                            if($_GET["dev"] == "D1Mini_N") {
                                $sqlString = "SELECT DISTINCT `date` FROM wetterDatenNiklas";
                            } else if($_GET["dev"] == "D1Mini_F") {
                                $sqlString = "SELECT DISTINCT `date` FROM wetterDatenFelix";
                            } else if($_GET["dev"] == "D1Mini_P") {
                                $sqlString = "SELECT DISTINCT `date` FROM wetterDatenPapa";
                            }

                            $res = mysqli_query($con, $sqlString);

                            while($daten = mysqli_fetch_assoc($res)) {
                                $selected = "";
                                if(isset($_POST["date"])) {
                                    if($daten["date"] == $_POST["date"]) {
                                        $selected = "selected";
                                    }
                                } else {
                                    if($daten["date"] == date("d.m.Y")) {
                                        $selected = "selected";
                                    }
                                }
                                
                                $option = "<option value='" . $daten["date"] . "' " . $selected . "> " . $daten["date"] . "</option>";
                                echo $option;
                                mysqli_close($con);
                            }
                            
                            ?>
                        </select>
                        <input type="submit" value="Go" class="inputs">
                    </p>
                </form>
            </div>
            
        </div>
    </main>

    <footer>
        <div id="credits">
            <p>&#9400; Niklas Küchen</p>
        </div>
    </footer>
</body>

</html>