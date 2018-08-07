<ul>
    <?php if (count($messages) == 0) {echo '<li><strong>Šiuo metu žinučių nėra. Būk pirmas!</strong></li>';}?>

    <?php
    /** @var Message $messageObject */
    if (count($messages) > 0) {
        foreach ($messages as $messageObject) {
            echo '<li>

                        <span>'.gmdate('Y-m-d H:i:s', $messageObject->getMessageTime()) . '</span>
                         
                        <a href="mailto:'
                .$messageObject->getEmail() . '">'
                .$messageObject->getFullname() . '</a>, '
                .$messageObject->calculatePersonAge() . '<br/>'
                .$messageObject->getMessage() . '</li>';
        }
    }
    ?>
</ul>