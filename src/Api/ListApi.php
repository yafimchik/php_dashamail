<?php

namespace Yafimchik\PhpDashamail\Api;

use Yafimchik\PhpDashamail\Traits\ServiceTrait;

/**
 * ListApi - Работа с Адресными Базами
*/

class ListApi
{
    use ServiceTrait;

    /**
     * lists.get - Получаем список баз пользователя
     *
     * optional: list_id, merge_json
     *
     * @see https://dashamail.ru/api_details/?method=lists.get
     *
     */
    public function get(array $params = [])
    {
        return $this->getData('lists.get', $params);
    }

    /**
     * lists.add - Добавляем адресную базу
     *
     * required: string name
     * optional: fields, company, address, ...
     *
     * @see https://dashamail.ru/api_details.php?method=lists.add
     */
    public function add(string $name, array $params = [])
    {
        if (empty($name)) {
            return $this->getError('3');
        }

        if (isset($params['abuse_email'])) {
            $email = $this->checkEmail($params['abuse_email']);
            if ($email !== false)
                $params['abuse_email'] = $email;
            else
                return $this->getError('6');
        }

        $params = array_merge(['name' => $name], $params);

        return $this->sendData('lists.add', $params);
    }

    /**
     * lists.update - Обновляем контактную информацию адресной базы
     *
     * required: list_id
     * optional:  name, company, address, ...
     *
     * @see https://dashamail.ru/api_details.php?method=lists.update
     */
    public function update(int $list_id, array $params = [])
    {
        if (isset($params['abuse_email'])) {
            $email = $this->checkEmail($params['abuse_email']);
            if ($email !== false)
                $params['abuse_email'] = $email;
            else
                return $this->getError('6');
        }

        $params = array_merge(['list_id' => $list_id], $params);

        return $this->sendData('lists.update', $params);
    }

    /**
     * lists.delete - Удаляем адресную базу и всех активных подписчиков в ней
     *
     * required: list_id
     *
     * @see https://dashamail.ru/api_details/?method=lists.delete
     */
    public function delete(int $list_id)
    {
        return $this->sendData('lists.delete', ['list_id' => $list_id]);
    }

    /**
     * lists.get_members - Получаем подписчиков в адресной базе с возможность фильтра и регулировки выдачи
     *
     * required: list_id
     * optional: state, start, limit, order, member_id, email
     *
     * @see https://dashamail.ru/api_details.php?method=lists.get_members
     */
    public function getMembers(int $list_id, array $params = [])
    {
        $params = array_merge(['list_id' => $list_id], $params);

        return $this->getData('lists.get_members', $params);
    }

    /**
     * lists.upload - Импорт подписчиков из файла
     *
     * required: list_id
     * optional: file, import-file, mode, ...
     *
     * @see https://dashamail.ru/api_details.php?method=lists.upload
     */
    public function upload(int $list_id, array $params = [])
    {
        $params = array_merge(['list_id' => $list_id], $params);

        return $this->sendData('lists.upload', $params);
    }

    /**
     * lists.add_member - Добавляем подписчика в базу
     *
     * required: list_id, email
     * optional: gender, update, no_check, ...
     *
     * @see https://dashamail.ru/api_details.php?method=lists.add_member
     */
    public function addMember(int $list_id, string $email, array $params = [])
    {
        if (empty($email)) {
            return $this->getError('6');
        }

        $email = $this->checkEmail($email);
        if (!$email) {
            return $this->getError('6');
        }

        $params = array_merge(['list_id' => $list_id, 'email' => $email], $params);

        return $this->sendData('lists.add_member', $params);
    }

    /**
     * lists.update_member - Редактируем подписчика в базе
     *
     * required: member_id, email, list_id
     * optional: gender, state, update_tags, ...
     *
     * @see https://dashamail.ru/api_details.php?method=lists.update_member
     */
    public function updateMember(int $member_id, string $email, int $list_id, array $params = [])
    {
        if (empty($email)) {
            return $this->getError('6');
        }

        $email = $this->checkEmail($email);
        if (!$email) {
            return $this->getError('6');
        }

        $params = array_merge(['member_id' => $member_id, 'email' => $email, 'list_id' => $list_id], $params);

        return $this->sendData('lists.update_member', $params);
    }

    /**
     * lists.delete_member - Удаляем подписчика из базы
     *
     * required: member_id
     *
     * @see https://dashamail.ru/api_details/?method=lists.delete_member
     */
    public function deleteMember(int $member_id)
    {
        return $this->sendData('lists.delete_member', ['member_id' => $member_id]);
    }

    /**
     * lists.unsubscribe_member - Редактируем подписчика в базе
     *
     * optional: member_id, email, list_id
     *
     * @see https://dashamail.ru/api_details.php?method=lists.unsubscribe_member
     */
    public function unsubscribeMember(array $params = [])
    {
        if (isset($params['email'])) {
            $email = $this->checkEmail($params['email']);

            if ($email !== false) {
                $params['email'] = $email;
            } else {
                return $this->getError('6');
            }
        }

        return $this->sendData('lists.unsubscribe_member', $params);
    }

    /**
     * lists.move_member - Перемещаем подписчика в другую адресную базу
     *
     * required: member_id, list_id
     *
     * @see https://dashamail.ru/api_details/?method=lists.move_member
     */
    public function moveMember(int $member_id, int $list_id)
    {
        return $this->sendData('lists.move_member', ['member_id' => $member_id, 'list_id' => $list_id]);
    }

    /**
     * lists.copy_member - Копируем подписчика в другую адресную базу
     *
     * required: member_id, list_id
     *
     * @see https://dashamail.ru/api_details/?method=lists.copy_member
     */
    public function copyMember(int $member_id, int $list_id)
    {
        return $this->sendData('lists.copy_member', ['member_id' => $member_id, 'list_id' => $list_id]);
    }

    /**
     * lists.add_merge - Добавить дополнительное поле в адресную базу
     *
     * required: list_id, type
     * optional: choices, title, ...
     *
     * @see https://dashamail.ru/api_details.php?method=lists.add_merge
     */
    public function addMerge(int $list_id, string $type, array $params = [])
    {
        if (empty($type)) {
            return $this->getError('3');
        }
        if ($type === 'choice' && empty($params['choices'])) {
            return $this->getError('3');
        }

        $params = array_merge(['list_id' => $list_id, 'type' => $type], $params);

        return $this->sendData('lists.add_merge', $params);
    }

    /**
     * lists.update_merge - Обновить настройки дополнительного поля в адресной базе
     *
     * required: list_id, merge_id
     * optional: choices, title, ...
     *
     * @see https://dashamail.ru/api_details.php?method=lists.update_merge
     */
    public function updateMerge(int $list_id, int $merge_id, array $params = [])
    {
        $params = array_merge(['list_id' => $list_id, 'merge_id' => $merge_id], $params);

        return $this->sendData('lists.update_merge', $params);
    }

    /**
     * lists.delete_merge - Удалить дополнительное поле из адресной базы
     *
     * required: list_id, merge_id
     *
     * @see https://dashamail.ru/api_details.php?method=lists.delete_merge
     */
    public function deleteMerge(int $list_id, int $merge_id)
    {
        return $this->sendData('lists.delete_merge', ['list_id' => $list_id, 'merge_id' => $merge_id]);
    }
}
