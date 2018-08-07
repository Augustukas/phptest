<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Žinutės</title>
    <link rel="stylesheet" media="screen" type="text/css" href="css/screen.css"/>
</head>
<body>

<?php
// define variables and set to empty values
$fullnameError = $emailError = $birthdateError = $messageError = "";
$fullname = $email = $birthdate = $message = "";

$messages = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["fullname"])) {
        $fullnameError = " privalomas laukas";
    } else {
        $fullname = test_input($_POST["fullname"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $fullname)) {
            $fullnameError = " leidžiamos tik raidės";
        }
    }

    if (empty($_POST["birthdate"])) {
        $birthdateError = "privaloma užpildyti";
    } else {
        $birthdate = test_input($_POST["birthdate"]);
        if (!validateDate($birthdate)) {
            $birthdateError = "netiksli data";
        }
    }

    if (empty($_POST["email"])) {
        //$emailError = "Paštas privalomas";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = " blogas formatas";
        }
    }


    if (empty($_POST["message"])) {
        $message = "";
        $messageError = " privaloma užpildyti";
    } else {
        $message = test_input($_POST["message"]);
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

?>

<div id="wrapper">

    <h1>Jūsų žinutės</h1>
    <form method="post" ACTION="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">


        <p class="<?php if($fullnameError) {echo "err";}?>">

            <label for="fullname">Vardas, pavardė * <?php if($fullnameError) {echo $fullnameError;}?></label><br/>

            <input id="fullname" type="text" name="fullname" value="<?php echo $fullname; ?>"/>

        </p>



        <p class="<?php if($birthdateError) {echo "err";}?>">

            <label for="birthdate">Gimimo data *<?php if($birthdateError) {echo $birthdateError;}?></label><br/>

            <input id="birthdate" type="text" name="birthdate" value="<?php echo $birthdate; ?>"/>

        </p>



        <p class="<?php if($emailError) {echo "err";}?>">

            <label for="email">El.pašto adresas <?php if($emailError) {echo $emailError;}?></label><br/>

            <input id="email" type="text" name="email" value="<?php echo $email; ?>"/>

        </p>



        <p class="<?php if($messageError) {echo "err";}?>">

            <label for="message">Jūsų žinutė *<?php if($messageError) {echo $messageError;}?></label><br/>

            <textarea name="message" rows="5" cols="30" id="message"><?php echo $message; ?></textarea>

        </p>



        <p>
            <span>* - privalomi laukai</span>
            <input type="submit" value="Skelbti"/>
            <img src="img/ajax-loader.gif" alt=""/>
        </p>
    </form>

    <ul>
        <li>
            <strong>Šiuo metu žinučių nėra. Būk pirmas!</strong>
        </li>
        <li>
            <span>2010 01 01 08:59</span> <a href="mailto:example@example.com">Vardas Pavardė</a>, 13 m.<br/>
            Įkėlėme šeimos dienos akciją. Dėl papildomos medžiagos užtrukome šiek tiek ilgiau nei įprasta.
        </li>
        <li>
            <span>2010 01 01 08:59</span> Vardas Pavardė, 75 m. <br/>
            Įkėlėme šeimos dienos akciją. Dėl papildomos medžiagos užtrukome šiek tiek ilgiau nei įprasta.
        </li>
        <li>
            <span>2010 01 01 08:59</span> Vardas Pavardė, 10 m. <br/>
            Įkėlėme šeimos dienos akciją. Dėl papildomos medžiagos užtrukome šiek tiek ilgiau nei įprasta.
        </li>
        <li>
            <span>2010 01 01 08:59</span> <a href="mailto:example@example.com">Vardas Pavardė</a>, 25 m. <br/>
            Įkėlėme šeimos dienos akciją. Dėl papildomos medžiagos užtrukome šiek tiek ilgiau nei įprasta.
        </li>
        <li>
            <span>2010 01 01 08:59</span> Vardas Pavardė, 26 m. <br/>
            Įkėlėme šeimos dienos akciją. Dėl papildomos medžiagos užtrukome šiek tiek ilgiau nei įprasta.
        </li>
    </ul>
    <p id="pages">
        <a href="#" title="atgal">atgal</a>
        <a href="#" title="1">1</a>
        2
        <a href="#" title="3">3</a>
        <a href="#" title="4">4</a>
        <a href="#" title="toliau">toliau</a>
    </p>
</div>
</body>
</html>
