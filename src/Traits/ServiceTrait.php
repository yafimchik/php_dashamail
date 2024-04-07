<?php

namespace Yafimchik\PhpDashamail\Traits;

use Exception;

/**
 * ServiceTrait - Служебные функции
 */

trait ServiceTrait
{
    use CheckEmailTrait;
    private array $errors = [
        '2' => 'Ошибка при добавлении в базу',
        '3' => 'Заданы не все необходимые параметры',
        '4' => 'Нет данных при выводе',
        '5' => 'У пользователя нет адресной базы с таким id',
        '6' => 'Некорректный email-адрес',
        '7' => 'Такой пользователь уже есть в этой адресной базе',
        '8' => 'Лимит по количеству активных подписчиков на тарифном плане клиента',
        '9' => 'Нет такого подписчика у клиента',
        '10' => 'Пользователь уже отписан',
        '11' => 'Нет данных для обновления подписчика',
        '12' => 'Не заданы элементы списка',
        '13' => 'Не задано время рассылки',
        '14' => 'Не задан заголовок письма',
        '15' => 'Не задано поле От Кого?',
        '16' => 'Не задан обратный адрес',
        '17' => 'Не задана ни html ни plain_text версия письма',
        '18' => 'Нет ссылки отписаться в тексте рассылки. Пример ссылки: отписаться',
        '19' => 'Нет ссылки отписаться в тексте рассылки',
        '20' => 'Задан недопустимый статус рассылки',
        '21' => 'Рассылка уже отправляется',
        '22' => 'У вас нет кампании с таким campaign_id',
        '23' => 'Нет такого поля для сортировки',
        '24' => 'Заданы недопустимые события для авторассылки',
        '25' => 'Загружаемый файл уже существует',
        '26' => 'Загружаемый файл больше 5 Мб',
        '27' => 'Файл не найден',
        '28' => 'Указанный шаблон не существует',
        '29' => 'Определен одноразовый email-адрес',
        '30' => 'Отправка рассылок заблокирована по подозрению в спаме',
        '31' => 'Массив email-адресов пуст',
        '32' => 'Нет корректных адресов для добавления',
        '33' => 'Недопустимый формат файла',
        '34' => 'Необходимо настроить собственный домен отправки',
        '35' => 'Данный функционал недоступен на бесплатных тарифах и во время триального периода',
        '36' => 'Ошибка при отправке письма',
        '37' => 'Рассылка еще не прошла модерацию',
        '38' => 'Недопустимый сегмент',
        '39' => 'Нет папки с таким id',
        '40' => 'Рассылка не находится в статусе PROCESSING или SENT',
        '41' => 'Рассылка не отправляется в данный момент',
        '42' => 'У вас нет рассылки на паузе с таким campaign_id',
        '43' => 'Пользователь в черном списке (двойная отписка)',
        '44' => 'Пользователь в черном списке (нажатие «это спам»)',
        '45' => 'Пользователь в черном списке (ручное)',
        '46' => 'Несуществующий email-адрес (находится в глобальном списке возвратов)',
        '47' => 'Ваш ip-адрес не включен в список разрешенных',
        '48' => 'Не удалось отправить письмо подтверждения для обратного адреса',
        '49' => 'Такой адрес уже подтвержден',
        '50' => 'Нельзя использовать одноразовые email в обратном адресе',
        '51' => 'Использование обратного адреса на публичных доменах Mail.ru СТРОГО ЗАПРЕЩЕНО политикой DMARC данного почтового провайдера',
        '52' => 'Email-адрес не подтвержден в качестве отправителя',
        '53' => 'Недопустимое событие для webhook',
        '54' => 'Некорректный домен. Кириллические и другие национальные домены в качестве DKIM/SPF запрещены',
        '55' => 'Данный домен находится в черном списке, его добавление запрещено',
        '56' => 'Данный домен занят другим аккаунтом',
        '1000' => 'Неверные данные для подключения API',
        '1001' => 'Несуществующий метод API или указан некорректный метод API',
    ];

    private $apiUrl = 'https://api.dashamail.com/';

    public function __construct(
        protected string $apiKey
    ) {
        if (empty($apiKey)) {
            throw new Exception($this->getError('1000'));
        }
    }

    /**
     * @throws Exception
     */
    final protected function getData(string $method, array $params = []): mixed
    {
        if (empty($method)) {
            return $this->getError('1001');
        }

        $params = array_merge(['api_key' => $this->apiKey, 'format' => 'json'], $params);
        $params = http_build_query($params);

        $url = $this->apiUrl . '?method=' . $method . '&' . $params;

        return $this->curl([
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => 0,
        ]);
    }

    /**
     * @throws Exception
     */
    final protected function sendData(string $method, array $params = []): mixed
    {
        if (empty($method)) {
            return $this->getError('1001');
        }

        $params = array_merge(['api_key' => $this->apiKey, 'format' => 'json'], $params);

        return $this->curl([
            CURLOPT_URL => $this->apiUrl . '?method=' . $method,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => 0,
        ]);
    }

    //get error codes
    final protected function getError(string $key): string
    {
        return $this->errors[$key] ?? 'Неизвестная ошибка апи';
    }

    /**
     * @param array $options
     * @return mixed|string
     * @throws Exception
     */
    private function curl(array $options): mixed
    {
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        if (!$result) {
            throw new Exception(curl_error($ch));
        }

        curl_close($ch);

        $final = json_decode($result, TRUE);
        if (!$final)
            throw new Exception('Получены неверные данные, пожалуйста, убедитесь, что запрашиваемый метод API существует');
        if ($final['msg']['err_code'] == '0') {
            return $final['data'];
        } else {
            return $this->getError($final['msg']['err_code']);
        }
    }
}
