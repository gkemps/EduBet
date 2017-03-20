<?php
namespace EduBet\PickForWin\Service;

use Zend\Http\Client;

class PickForWinService
{
    /** @var  Client */
    protected $client;

    /**
     * PickForWinService constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }


}