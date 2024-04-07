<?php

namespace Yafimchik\PhpDashamail\Api;

use Yafimchik\PhpDashamail\Traits\ServiceTrait;

/**
 * ReportApi - Работа с отчетами
*/

class ReportApi
{
    use ServiceTrait;

    /**
     * reports.send - Список отправленных писем в рассылке
     *
     * required: campaign_id
     * optional: start, limit, order
     *
     * @see https://dashamail.ru/api_details.php?method=reports.sent
     */
    public function sent(int $campaign_id, array $params = [])
    {
        return $this->sendData('reports.sent', array_merge(['campaign_id' => $campaign_id], $params));
    }

    /**
     * reports.delivered - Список доставленных писем в рассылке
     *
     * required: campaign_id
     * optional: start, limit, order
     *
     * @see https://dashamail.ru/api_details.php?method=reports.delivered
     */
    public function delivered(int $campaign_id, array $params = [])
    {
        return $this->getData('reports.delivered', array_merge(['campaign_id' => $campaign_id], $params));
    }

    /**
     * reports.opened - Список открытых писем в рассылке
     *
     * required: campaign_id
     * optional: start, limit, order
     *
     * @see https://dashamail.ru/api_details.php?method=reports.opened
     */
    public function opened(int $campaign_id, array $params = [])
    {
        return $this->getData('reports.opened', array_merge(['campaign_id' => $campaign_id], $params));
    }

    /**
     * reports.unsubscribed - Список писем отписавшихся подписчиков в рассылке
     *
     * required: campaign_id
     * optional: start, limit, order
     *
     * @see https://dashamail.ru/api_details.php?method=reports.unsubscribed
     */
    public function unsubscribed(int $campaign_id, array $params = [])
    {
        return $this->getData('reports.unsubscribed', array_merge(['campaign_id' => $campaign_id], $params));
    }

    /**
     * reports.bounced - Список возвратившихся писем в рассылке
     *
     * required: campaign_id
     * optional: start, limit, order
     *
     * @see https://dashamail.ru/api_details.php?method=reports.bounced
     */
    public function bounced(int $campaign_id, array $params = [])
    {
        return $this->getData('reports.unsubscribed', array_merge(['campaign_id' => $campaign_id], $params));
    }

    /**
     * reports.clickstat - Cтатистика по кликам по различным url в письме
     *
     * required: campaign_id
     *
     * @see https://dashamail.ru/api_details.php?method=reports.clickstat
     */
    public function clickstat(int $campaign_id)
    {
        return $this->getData('reports.clickstat', ['campaign_id' => $campaign_id]);
    }

    /**
     * reports.bouncestat - Cтатистика по всевозможным причинам возврата письма
     *
     * required: campaign_id
     *
     * @see https://dashamail.ru/api_details.php?method=reports.bouncestat
     */
    public function bouncestat(int $campaign_id)
    {
        return $this->getData('reports.bouncestat', ['campaign_id' => $campaign_id]);
    }

    /**
     * reports.summary - Краткая статистика по рассылке
     *
     * required: campaign_id
     *
     * @see https://dashamail.ru/api_details.php?method=reports.summary
     */
    public function summary(int $campaign_id)
    {
        return $this->getData('reports.summary', ['campaign_id' => $campaign_id]);
    }

    /**
     * reports.clients - Cтатистика по браузерам, ОС и почтовым клиентам
     *
     * required: campaign_id
     *
     * @see https://dashamail.ru/api_details.php?method=reports.clients
     */
    public function clients(int $campaign_id)
    {
        return $this->getData('reports.clients', ['campaign_id' => $campaign_id]);
    }

    /**
     * reports.geo - Cтатистика по регионам открытия
     *
     * required: campaign_id
     *
     * @see https://dashamail.ru/api_details.php?method=reports.geo
     */
    public function geo(int $campaign_id)
    {
        return $this->getData('reports.geo', ['campaign_id' => $campaign_id]);
    }
}
