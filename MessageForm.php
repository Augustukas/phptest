<?php

use MessagingBoard\Errors;
use MessagingBoard\MessageRepository;

$messages = [];
$error = new Errors();

$message = new Message();

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    /** @var Message $message */
    $message = MessageFactory::createFromPost($_POST, $error);
    $errors = $error->getErrors();
    if (count($errors) === 0) {
        $messageRepository = new MessageRepository();
        $messageRepository->saveMessage($message);
        // preventing form resubmit
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}



?>
<form method="post" ACTION="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">


    <p class="<?php if(isset($errors['fullnameError'])) {echo "err";}?>">

        <label for="fullname">Vardas, pavardė * <?php if(isset($errors['fullnameError'])) {echo $errors['fullnameError'];}?></label><br/>

        <input id="fullname" type="text" name="fullname" value="<?php echo $message->getFullname(); ?>"/>

    </p>



    <p class="<?php if(isset($errors['birthdateError'])) {echo "err";}?>">

        <label for="birthdate">Gimimo data *<?php if(isset($errors['birthdateError'])) {echo $errors['birthdateError'];}?></label><br/>

        <input id="birthdate" type="text" name="birthdate" value="<?php echo $message->getBirthday(); ?>"/>

    </p>



    <p class="<?php if(isset($errors['emailError'])) {echo "err";}?>">

        <label for="email">El.pašto adresas <?php if(isset($errors['emailError'])) {echo $errors['emailError'];}?></label><br/>

        <input id="email" type="text" name="email" value="<?php echo $message->getEmail(); ?>"/>

    </p>



    <p class="<?php if(isset($errors['messageError'])) {echo "err";}?>">

        <label for="message">Jūsų žinutė *<?php if(isset($errors['messageError'])) {echo $errors['messageError'];}?></label><br/>

        <textarea name="message" rows="5" cols="30" id="message" maxlength="255"><?php echo $message->getMessage(); ?></textarea>

    </p>



    <p>
        <span>* - privalomi laukai</span>
        <input type="submit" value="Skelbti"/>
        <img src="img/ajax-loader.gif" alt="loading"/>
    </p>
</form>