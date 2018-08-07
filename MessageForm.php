<?php
$messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : [];

// define variables and set to empty values
$fullnameError = $emailError = $birthdateError = $messageError = "";
$fullname = $email = $birthdate = $message = "";
$message = new Message();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["fullname"])) {
        $fullnameError = " privalomas laukas";
    } else {
        $message->setFullname(test_input($_POST["fullname"]));
        if (!preg_match("/^[a-zA-Z ]*$/", $message->getFullname())) {
            $fullnameError = " leidžiamos tik raidės";
        }
        if (!(count(explode(' ', $message->getFullname())) == 2)) {
            $fullnameError = " turi būti du žodžiai";
        }
    }

    if (empty($_POST["birthdate"])) {
        $birthdateError = "privaloma užpildyti";
    } else {
        $message->setBirthday(test_input($_POST["birthdate"]));
        if (!validateDate($message->getBirthday())) {
            $birthdateError = "netiksli data";
        }
    }

    if (empty($_POST["email"])) {
        //$emailError = "Paštas privalomas";
    } else {
        $message->setEmail(test_input($_POST["email"]));
        if (!filter_var($message->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $emailError = " blogas formatas";
        }
    }


    if (empty($_POST["message"])) {
        $message->setMessage("");
        $messageError = " privaloma užpildyti";
    } else {
        $message->setMessage(test_input($_POST["message"]));
    }

    if(!$fullnameError && !$emailError && !$birthdateError && !$messageError) {


        array_unshift($messages, $message);
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

        <input id="fullname" type="text" name="fullname" value="<?php echo $message->getFullname(); ?>"/>

    </p>



    <p class="<?php if($birthdateError) {echo "err";}?>">

        <label for="birthdate">Gimimo data *<?php if($birthdateError) {echo $birthdateError;}?></label><br/>

        <input id="birthdate" type="text" name="birthdate" value="<?php echo $message->getBirthday(); ?>"/>

    </p>



    <p class="<?php if($emailError) {echo "err";}?>">

        <label for="email">El.pašto adresas <?php if($emailError) {echo $emailError;}?></label><br/>

        <input id="email" type="text" name="email" value="<?php echo $message->getEmail(); ?>"/>

    </p>



    <p class="<?php if($messageError) {echo "err";}?>">

        <label for="message">Jūsų žinutė *<?php if($messageError) {echo $messageError;}?></label><br/>

        <textarea name="message" rows="5" cols="30" id="message" maxlength="255"><?php echo $message->getMessage(); ?></textarea>

    </p>



    <p>
        <span>* - privalomi laukai</span>
        <input type="submit" value="Skelbti"/>
        <img src="img/ajax-loader.gif" alt="loading"/>
    </p>
</form>