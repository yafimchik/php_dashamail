<?php

namespace Yafimchik\PhpDashamail;

use Exception;
use Yafimchik\PhpDashamail\Api\CampaignApi;
use Yafimchik\PhpDashamail\Api\ListApi;
use Yafimchik\PhpDashamail\Api\ReportApi;
use Yafimchik\PhpDashamail\Api\TransactionalApi;
use Yafimchik\PhpDashamail\Traits\CheckEmailTrait;

class DashaMailApi
{
    use CheckEmailTrait;

    public ListApi $lists;
    public CampaignApi $campaigns;
    public ReportApi $reports;
    public TransactionalApi $transactional;

    /**
     * @throws Exception
     */
    public function __construct(string $apiKey)
    {
        if (empty($apiKey)) {
            throw new Exception('Не задан ключ для подключения API');
        }
        $this->lists = new ListApi($apiKey);
        $this->campaigns = new CampaignApi($apiKey);
        $this->reports = new ReportApi($apiKey);
        $this->transactional = new TransactionalApi($apiKey);
    }

    /**
     * @param string $apiKey
     * @return DashaMailApi
     * @throws Exception
     */
    public static function create(string $apiKey): DashaMailApi
    {
        return new DashaMailApi($apiKey);
    }
}
