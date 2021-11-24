<!DOCTYPE HTML>
<html>
    <head><meta charset="utf8"></head>
    <body>
    <?php 

        $temp = $_GET["temp"];
        $hum = $_GET["hum"];
        $pres = $_GET["pres"];
        $dev = $_GET["dev"];

       
        $server = "X.X.X.X";
        $username = "X";
        $password = "X";
        $db = "X";
        $con = mysqli_connect($server, $username, $password, $db);

        if($con->connect_error) {
            die("Connection failed<br> " . $con->connection_error);
        }

        if($dev == "D1Mini_N") {
            $sql = "INSERT INTO `wetterDatenNiklas` (`time`, `temp`, `hum`, `pres`, `date`) VALUES ('" . date("H:i:s") . "', '" . $temp . "', '" . $hum . "', '" . $pres . "', '" . date("d.m.Y") . "')";
            mysqli_query($con, $sql);
        } else if($dev == "D1Mini_F") {
            $sql = "INSERT INTO `wetterDatenFelix` (`time`, `temp`, `hum`, `pres`, `date`) VALUES ('" . date("H:i:s") . "', '" . $temp . "', '" . $hum . "', '" . $pres . "', '" . date("d.m.Y") . "')";
            mysqli_query($con, $sql);
        } else if($dev == "D1Mini_P") {
            $sql = "INSERT INTO `wetterDatenPapa` (`time`, `temp`, `hum`, `pres`, `date`) VALUES ('" . date("H:i:s") . "', '" . $temp . "', '" . $hum . "', '" . $pres . "', '" . date("d.m.Y") . "')";
            mysqli_query($con, $sql);
        }
        
        mysqli_close($con);
        
    ?>
    </body>    
</html>