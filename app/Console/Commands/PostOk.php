<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PostOk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ok:post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'post to ok.ru';

    // Параметры
    //tkn180Dmnu5orjLFlMJoY28zePbbopCHcQpWbOdurQnxXevJgANRoBPGN1KaxdCRVupSg:CBPPPNJGDIHBABABA
//    private $ok_access_token    = "tkn1gWLZAuB4RiRceEkdQZjTEDcddnZ9Zvb4VsnjXFfQQqNRxBQ5uLTlsX0qxvauLXV791";  // Наш вечный токен
    private $ok_access_token    = "tkn180Dmnu5orjLFlMJoY28zePbbopCHcQpWbOdurQnxXevJgANRoBPGN1KaxdCRVupSg:CBPPPNJGDIHBABABA";  // Наш вечный токен
    private $ok_private_key     = "3C689A74BD065F94CE3A22DA";  // Секретный ключ приложения
    private $ok_public_key      = "CQNGKLJGDIHBABABA";  // Публичный ключ приложения
    private $ok_group_id        = "59138679505015";  // ID нашей группы
    private $message            = "HELLO WORLD";  // Сообщение к посту, можно с переносами строки

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }


    // Запрос
    public function getUrl($url, $type = "GET", $params = array(), $timeout = 30, $image = false, $decode = true) {
        if ($ch = curl_init()) {
            
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, false);

        if ($type == "POST") {

            curl_setopt($ch, CURLOPT_POST, true);

            // Картинка
            if ($image) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            }
            // Обычный запрос       
            elseif($decode) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
            }
            // Текст
            else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            }
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_USERAGENT, 'PHP Bot');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $data = curl_exec($ch);

        curl_close($ch);

        // Еще разок, если API завис
        if (isset($data['error_code']) && $data['error_code'] == 5000) {
            $data = getUrl($url, $type, $params, $timeout, $image, $decode);
        }

	echo $data;	

        return $data;

    }
    else {
        return "{}";
    }
}

// Массив аргументов в строку
private function arInStr($array) {

    ksort($array);

    $string = "";

    foreach($array as $key => $val) {
        if (is_array($val)) {
            $string .= $key."=".arInStr($val);
        } else {
            $string .= $key."=".$val;
        }
    }

    return $string;
}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        
        //58900893401207
    
        // 1. Получим адрес для загрузки 1 фото

        $params = array(
            "application_key"   =>  $this->ok_public_key,
            "method"            => "photosV2.getUploadUrl",
            "count"             =>  1,  // количество фото для загрузки
            "gid"               =>  $this->ok_group_id,
            "format"            =>  "json"
        );

        // Подпишем запрос
        $sig = md5( $this->arInStr($params) . md5("{$this->ok_access_token}{$this->ok_private_key}") );

        $params['access_token'] = $this->ok_access_token;
        $params['sig']          = $sig;

        // Выполним
        $step1 = json_decode($this->getUrl("https://api.ok.ru/fb.do", "POST", $params), true);

        // Если ошибка
        if (isset($step1['error_code'])) {
            // Обработка ошибки
            die("die1");
        }

        // Идентификатор для загрузки фото
        $photo_id = $step1['photo_ids'][0];

        // 2. Закачаем фотку

        // Предполагается, что картинка располагается в каталоге со скриптом
        $params = array(
            "pic1" => "@picture.jpg",
        );

        // Отправляем картинку на сервер, подписывать не нужно
        $step2 = json_decode( getUrl( $step1['upload_url'], "POST", $params, 30, true), true);

        // Если ошибка
        if (isset($step2['error_code'])) {
            // Обработка ошибки
            die("die2");
        }

        // Токен загруженной фотки
        $token = $step2['photos'][$photo_id]['token'];

        // Заменим переносы строк, чтоб не вываливалась ошибка аттача
        $message_json = str_replace("\n", "\\n", $message);

        // 3. Запостим в группу
        $attachment = 
        '{
                    "media": [
                        {
                            "type": "text",
                            "text": "'.$message_json.'"
                        },
                        {
                            "type": "photo",
                            "list": [
                            {
                                "id": "'.$token.'"
                            }
                    ]
                }
            ]
        }';

        $params = array(
            "application_key"   =>  self::ok_public_key,
            "method"            =>  "mediatopic.post",
            "gid"               =>  self::ok_group_id,
            "type"              =>  "GROUP_THEME",
            "attachment"        =>  $attachment,
            "format"            =>  "json",
        );

        // Подпишем
        //$sig = md5( arInStr($params) . md5(self::ok_access_token.self::ok_private_key) );
        $sig = md5( arInStr($params) . md5("{ok_access_token}{ok_private_key}") );

        $params['access_token'] = self::ok_access_token;
        $params['sig']          = $sig;

        $step3 = json_decode( getUrl("https://api.ok.ru/fb.do", "POST", $params, 30, false, false ), true);

        // Если ошибка
        if (isset($step3['error_code'])) {
        // Обработка ошибки
            die("die3");
        }

        // Успешно
        echo 'OK';

    }
}
