<?php

use MessagingBoard\DbConnection;
use MessagingBoard\Message;
use MessagingBoard\MessageRepository;
use MessagingBoard\Paginator;

$messages = [];
$instance = DbConnection::getInstance();
$messageRepository = new MessageRepository();
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$config = parse_ini_file('./private/config.ini');
$limit = $config['pagesize'];
$messages = $messageRepository->getLimitedMessages($limit, $page);


/**
 * @param Message $message
 * @return string
 */
function formatNameWithUrlOrNot($message)
{

    $url = '<a href="mailto:' . $message->getEmail() . '">' . $message->getFullname() . '</a>';

    if (!$message->getEmail()) {
        $url = $message->getFullname();
    }

    return $url;
}

?>

    <ul>
        <?php if (count($messages) == 0) {
            echo '<li><strong>Šiuo metu žinučių nėra. Būk pirmas!</strong></li>';
        } ?>

        <?php
        /** @var Message $messageObject */
        if (count($messages) > 0) {
            foreach ($messages as $messageObject) {
                echo '<li>

                        <span>' . $messageObject->getMessageTime() . '</span>
                         
                        ' . formatNameWithUrlOrNot($messageObject) . ', '
                    . $messageObject->calculatePersonAge() . '<br/>'
                    . $messageObject->getMessage() . '
                </li>';
            }
        }
        ?>
    </ul>

<?php
$paginator = new Paginator($messageRepository);
$paginator->getData($page);
echo $paginator->createLinks('pages');
?>