<?php

namespace Yafimchik\PhpDashamail\Traits;

use Exception;

/**
 * CheckEmailTrait - Проверка емейла
 */

trait CheckEmailTrait
{
    /**
     * @var string check email api url
     */
    private string $checkUrl = 'https://labs.dashamail.com/email.fix/check.php';

    /**
     * check email address
     *
     * @param string $email
     * @return string|false
     * @throws Exception
     */
    final public function checkEmail(string $email): string|false
    {
        $checking = $this->checkUrl . '?email=' . $email . '&format=xml';
        $result = file_get_contents($checking);
        $xml = simplexml_load_string($result);
        $json = json_encode($xml);
        $final = json_decode($json, TRUE);
        if (!$final)
            throw new Exception('При проверке email получены неверные данные');
        $err = $final['err_code'];
        if ($err == '0' || $err == '1') {
            return $final['text'] ?: false;
        } else {
            return false;
        }
    }
}
