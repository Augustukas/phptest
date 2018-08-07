<?php

// define variables and set to empty values
$fullnameError = $emailError = $birthdateError = $messageError = "";
$fullname = $email = $birthdate = $message = "";

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

    if(!$fullnameError && !$emailError && !$birthdateError && !$messageError) {
        $messageObject = new Message();
        $messageObject
            ->setFullname($fullname)
            ->setBirthday($birthdate)
            ->setEmail($email)
            ->setMessage($message);

        /** @var Message[] $messages */
        array_unshift($messages, $messageObject);
        $_SESSION['messages'] = $messages;
        $_POST = array();
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
        <img src="img/ajax-loader.gif" alt="loading"/>
    </p>
</form>