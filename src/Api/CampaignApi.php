<?php

namespace Yafimchik\PhpDashamail\Api;

use Yafimchik\PhpDashamail\Traits\ServiceTrait;

/**
 * CampaignApi - Работа с рассылками
*/

class CampaignApi
{
    use ServiceTrait;

    /**
     * campaigns.get - Получаем список рассылок пользователя
     *
     * optional: campaign_id, status, list_id, type, ...
     *
     * @see https://dashamail.ru/api_details.php?method=campaigns.get
     *
     */
    public function get(array $params = [])
    {
        return $this->getData('campaigns.get', $params);
    }

    /**
     * campaigns.create - Создаем рассылку
     *
     * required: list_id
     * optional: name, subject, ...
     *
     * @see https://dashamail.ru/api_details.php?method=campaigns.create
     *
     */
    public function create(array $list_id, array $params = [])
    {
        if (empty($list_id)) {
            return $this->getError('3');
        }

        $params = array_merge(['list_id' => serialize($list_id)], $params);
        return $this->sendData('campaigns.create', $params);
    }

    /**
     * campaigns.create_auto - Создаем авторассылку
     *
     * optional: list_id, name, subject, ...
     *
     * @see https://dashamail.ru/api_details.php?method=campaigns.create_auto
     */
    public function createAuto(array $params = [])
    {
        if (!empty($params['list_id'])) {
            $params['list_id'] = serialize($params['list_id']);
        }

        return $this->sendData('campaigns.create_auto', $params);
    }

    /**
     * campaigns.update - Обновляем параметры рассылки
     *
     * required: campaign_id
     * optional: list_id, name, subject, ...
     *
     * @see https://dashamail.ru/api_details.php?method=campaigns.update
     */
    public function update(int $campaign_id = null, array $params = [])
    {
        if (!empty($params['list_id'])) {
            $params['list_id'] = serialize($params['list_id']);
        }

        $params = array_merge(['campaign_id' => $campaign_id], $params);
        return $this->sendData('campaigns.update', $params);
    }

    /**
     * campaigns.update_auto - Обновляем параметры авторассылки
     *
     * required: campaign_id
     * optional: list_id, name, subject, ...
     *
     * @see https://dashamail.ru/api_details.php?method=campaigns.update_auto
     */
    public function updateAuto(int $campaign_id, array $params = [])
    {
        if (!empty($params['list_id'])) {
            $params['list_id'] = serialize($params['list_id']);
        }

        $params = array_merge(['campaign_id' => $campaign_id], $params);

        return $this->sendData('campaigns.update_auto', $params);
    }

    /**
     * campaigns.delete - Удаляем рассылку
     *
     * required: campaign_id
     *
     * @see https://dashamail.ru/api_details.php?method=campaigns.delete
     */
    public function delete(int $campaign_id)
    {
        return $this->sendData('campaigns.delete', ['campaign_id' => $campaign_id]);
    }

    /**
     * campaigns.attach - Прикрепляем файл
     *
     * required: campaign_id, url
     * optional: name, separate_link
     *
     * @see https://dashamail.ru/api_details.php?method=campaigns.attach
     */
    public function attach(int $campaign_id, string $url, array $params = [])
    {
        if (empty($url)) {
            return $this->getError('3');
        }

        $params = array_merge(['campaign_id' => $campaign_id, 'url' => $url], $params);

        return $this->sendData('campaigns.attach', $params);
    }

    /**
     * campaigns.get_attachments - Получаем приложенные файлы
     *
     * required: campaign_id
     *
     * @see https://dashamail.ru/api_details.php?method=campaigns.get_attachments
     */
    public function getAttachments(int $campaign_id)
    {
        return $this->getData('campaigns.get_attachments', ['campaign_id' => $campaign_id]);
    }

    /**
     * campaigns.delete_attachments - Удаляем приложенный файл
     *
     * required: campaign_id, id
     *
     * @see https://dashamail.ru/api_details/?method=campaigns.delete_attachment
     */
    public function deleteAttachments(int $campaign_id, int $id)
    {
        return $this->sendData('campaigns.delete_attachments', ['campaign_id' => $campaign_id, 'id' => $id]);
    }

    /**
     * campaigns.get_templates - Получаем html шаблоны
     *
     * optional: name, id
     *
     * @see https://dashamail.ru/api_details.php?method=campaigns.get_templates
     */
    public function getTemplates(array $params = [])
    {
        return $this->getData('campaigns.get_templates', $params);
    }

    /**
     * campaigns.add_template - Добавляем html шаблон
     *
     * required: name, template
     * optional: cloud
     *
     * @see https://dashamail.ru/api_details.php?method=campaigns.add_template
     */
    public function addTemplate(string $name, string $template, array $params = [])
    {
        $params = array_merge(['name' => $name, 'template' => $template], $params);

        return $this->sendData('campaigns.add_template', $params);
    }

    /**
     * campaigns.delete_template - Удаляем html шаблон
     *
     * required: id
     *
     * @see https://dashamail.ru/api_details/?method=campaigns.delete_template
     */
    public function deleteTemplate(int $id)
    {
        return $this->sendData('campaigns.delete_templates', ['id' => $id]);
    }

    /**
     * campaigns.force_auto - Принудительно вызываем срабатывание авторассылки (при этом она должна быть активна)
     *
     * required: campaign_id, member_id
     * optional: delay
     *
     * @see https://dashamail.ru/api_details.php?method=campaigns.force_auto
     */
    public function forceAuto(int $campaign_id, int $member_id, array $params = [])
    {
        $params = array_merge(['campaign_id' => $campaign_id, 'member_id' => $member_id], $params);

        return $this->sendData('campaigns.force_auto', $params);
    }
}
