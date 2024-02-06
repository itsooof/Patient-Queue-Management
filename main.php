<?php
    if(isset($_POST['email'])){
        // Collect post variables
        $email = $_POST['email'];
        $sbp = $_POST['sbp'];
        $dbp = $_POST['dbp'];
        $bsl = $_POST['bsl'];
        $ol = $_POST['ol'];
        $hr = $_POST['hr'];
        $myfile = fopen("file.txt", "a+") or die("Unable to open file!");
        $myfile2 = fopen("mail.txt", "a+") or die("Unable to open file!");
        fwrite($myfile, $sbp);
        fwrite($myfile, "\n");
        fwrite($myfile, $dbp);
        fwrite($myfile, "\n");
        fwrite($myfile, $bsl);
        fwrite($myfile, "\n");
        fwrite($myfile, $ol);
        fwrite($myfile, "\n");
        fwrite($myfile, $hr);
        fwrite($myfile, "\n");
        fwrite($myfile2, $email);
        fwrite($myfile2, "\n");
        fclose($myfile);
        fclose($myfile2);

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Halth Measures</title>
    <style>
        body{
            background-image: url('sign.png');
            background-repeat: no-repeat;
            background-size: 1440px 900px;
            text-align: center;
        }
        span{
            font-size: 60px;
            font-family: cursive;
            font-weight: bold;
        }
        form,span{
            text-align: center;
        }
        input[type="number"],[type="text"]{
            font-size: 20px;
            font-family:Georgia, 'Times New Roman', Times, serif;
            width: 500px;
            height: 40px;
            margin-bottom: 10px;
            padding: 9px;
            border-radius: 12px;
            border-color: gray;
            border-width: 5px;
            background-color: black;
            color: whitesmoke;
            opacity: 0.9;
        }
        input[type="submit"]{
            font-size: 20px;
            font-family:Georgia, 'Times New Roman', Times, serif;
            border-radius: 12px;
            padding: 12px;
            font-weight: bold;
            margin-top: 10px;
            width: 150px;
        }
        input[type="number"]:hover{
            background-color: gray;
            font-size: 25px;
            border-color: black;
        }
        input[type="text"]:hover{
            background-color: gray;
            font-size: 25px;
            border-color: black;
        }
        input[type="submit"]:hover{
            background-color: black;
            color: white;
            border-color: black;
        }
    </style>
</head>
<body>
    <span>Patient Health Measures</span>
    <?php
    $filePath = fopen("file.txt", "r") or die("Unable to open file!");
    $lines = count(file("file.txt"));
    $val=($lines/5)+1;
    echo "<center><B><div style='font-size:30px;'>Patient Number $val</div></B><center>";
    fclose($filePath);
    ?>
    <form action="main.php" method="POST">
        <p><input type="text" name="email" id="email" placeholder="Receiver Email"></p>
        <p><input type="number" id="sbp" name="sbp" placeholder="Systolic Blood Pressure"></p>
        <p><input type="number" id="dbp" name="dbp" placeholder="Diatolic Blood Pressure"></p>
        <p><input type="number" id="bsl" name="bsl" placeholder="Blood Sugar Level"></p>
        <p><input type="number" id="ol" name="ol" placeholder="Oxygen Level"></p>
        <p><input type="number" id="hr" name="hr" placeholder="Heart Rate"></p>
        <p><input type="submit" name="submit" value="SUBMIT"></p>
    </form>
    <?php
    if(array_key_exists('truncate', $_POST)) {
        truncate();
    }
    function truncate(){
            $fp = fopen("file.txt", "r+");
            ftruncate($fp, 0);
            fclose($fp);
        }
    ?>
    <form method="POST">
    <input type="submit" name="truncate" class="button" value="RESET" />
    </form>
</body>
</html>