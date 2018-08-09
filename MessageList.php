<?php
$messages = []; //isset($_SESSION['messages']) ? $_SESSION['messages'] : [];
$instance = DbConnection::GetInstance();

/** @var mysqli $connection */
$connection = $instance->getConnection();
$result = $connection->query("SELECT * FROM messagingboard.messages");

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $message = MessageFactory::createFromDbResponse($row);

        array_unshift($messages, $message);
    }
} else {
    echo "0 results";
}


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

                        <span>'.$messageObject->getMessageTime(). '</span>
                         
                        '.formatNameWithUrlOrNot($messageObject).', '
                        .$messageObject->calculatePersonAge() . '<br/>'
                        .$messageObject->getMessage() . '
                </li>';
        }
    }
    ?>
</ul>

<?php include 'Pagination.php'?>