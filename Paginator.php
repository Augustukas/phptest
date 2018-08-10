<?php
namespace MessagingBoard;
use stdClass;

class Paginator
{

    private $limit;
    private $page;
    private $total;
    private $messageRepository;

    /**
     * Paginator constructor.
     * @param \MessagingBoard\MessageRepository $messageRepository
     */
    public function __construct($messageRepository)
    {
        $config = parse_ini_file('./private/config.ini');
        $this->limit = $config['pagesize'];
        $this->messageRepository = $messageRepository;
        $this->total = $this->messageRepository->getMessageCount();
        $this->page = 1;

    }

    private function validateInput(int $page)
    {
        $page = trim($page);
        $page = htmlspecialchars($page);
        $last = ceil($this->total / $this->limit);
        if ($page <1 || $page > $last) {
            $page = 1;
        }
        return $page;
    }

    public function getData($page = 1)
    {
        $page = self::validateInput($page);
        $this->page = $page;

        $results = $this->messageRepository->getLimitedMessages($this->limit, $page);


        $result = new stdClass();
        $result->page = $this->page;
        $result->limit = $this->limit;
        $result->total = $this->total;
        $result->data = $results;

        return $result;
    }

    public function createLinks($listId)
    {

        $last = ceil($this->total / $this->limit);

        $start = 1;

        $html = '<p id="' . $listId . '">';

        $html .= '<a href="?page=' . ($this->page == $start ? $start : ($this->page - 1)) . '">Atgal&nbsp;</a>';


        for ($i = $start; $i <= $last; $i++) {
            if($this->page != $i) {
                $html .= '<a href="?page=' . $i . '">' . $i . '&nbsp;</a>';
            } else {
                $html .= $i.'&nbsp;';
            }
        }


        $html .= '<a href="?page=' . ($last == $this->page ? $last : ($this->page + 1)) . '">&nbsp;Toliau</a>';

        $html .= '</p>';

        return $html;
    }
}