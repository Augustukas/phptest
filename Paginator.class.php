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

    public function getData($page = 1)
    {

        $this->page = $page;

        $results = $this->messageRepository->getLimitedMessages($this->limit, $page);


        $result = new stdClass();
        $result->page = $this->page;
        $result->limit = $this->limit;
        $result->total = $this->total;
        $result->data = $results;

        return $result;
    }

    public function createLinks($links, $listId)
    {

        $last = ceil($this->total / $this->limit);

        $start = (($this->page - $links) > 0) ? $this->page - $links : 1;
        $end = (($this->page + $links) < $last) ? $this->page + $links : $last;

        $html = '<p id="' . $listId . '">';

        $html .= '<a href="?page=' . ($this->page - 1) . '">Atgal&nbsp;</a>';

        if ($start > 1) {
            $html .= '<a href="?page=1">1</a>';
        }

        for ($i = $start; $i <= $end; $i++) {
            if($this->page !== $i) {
                $html .= '<a href="?page=' . $i . '">' . $i . '&nbsp;</a>';
            } else {
                $html .= $i.'&nbsp;';
            }
        }

        if ($end < $last) {
            $html .= '<a href="?page=' . $last . '">' . $last . '</a>';
        }

        $html .= '<a href="?page=' . ($this->page + 1) . '">&nbsp;Toliau</a>';

        $html .= '</p>';

        return $html;
    }
}