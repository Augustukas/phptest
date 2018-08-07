<?php

/**
 * @param Message $message
 * @return string
 */
function formatNameWithUrlOrNot($message) {

    $url = '<a href="mailto:'.$message->getEmail() . '">'.$message->getFullname() . '</a>';

    if(!$message->getEmail()) {
        $url = $message->getFullname();
    }

    return $url;
}
?>

<ul>
    <?php if (count($messages) == 0) {echo '<li><strong>Šiuo metu žinučių nėra. Būk pirmas!</strong></li>';}?>

    <?php
    /** @var Message $messageObject */
    if (count($messages) > 0) {
        foreach ($messages as $messageObject) {
            echo '<li>

                        <span>'.gmdate('Y-m-d H:i:s', $messageObject->getMessageTime()) . '</span>
                         
                        '.formatNameWithUrlOrNot($messageObject).', '
                        .$messageObject->calculatePersonAge() . '<br/>'
                        .$messageObject->getMessage() . '
                </li>';
        }
    }
    ?>
</ul>