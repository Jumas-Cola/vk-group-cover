<?php
function build_data_files($boundary, $fields, $files){
	    $data = '';
	    $eol = "\r\n";

	    $delimiter = '-------------' . $boundary;

	    foreach ($fields as $name => $content) {
	        $data .= "--" . $delimiter . $eol
	            . 'Content-Disposition: form-data; name="' . $name . "\"".$eol.$eol
	            . $content . $eol;
	    }


	    foreach ($files as $name => $content) {
	        $data .= "--" . $delimiter . $eol
	            . 'Content-Disposition: form-data; name="' . $name . '"; filename="' . $name . '"' . $eol
	            //. 'Content-Type: image/png'.$eol
	            . 'Content-Transfer-Encoding: binary'.$eol
	            ;

	        $data .= $eol;
	        $data .= $content . $eol;
	    }
	    $data .= "--" . $delimiter . "--".$eol;


	    return $data;
	}


ini_set('display_errors', 1);

require 'config.php';

//Receive and decode notification
$data = json_decode(file_get_contents('php://input'));

//Check the "type" field
switch ($data->type) {
    case 'confirmation':
    echo $config['confirmation_token'];
    break;

    case 'group_join':
    $VkGroup->updateCover($data);
    
	list($width, $height) = getimagesize('cover.jpg');
    $request_params = array(
       'group_id' => $config['group_id'],
        'crop_x'   => 0,
        'crop_y'   => 0,
        'crop_x2'  => $width,
        'crop_y2'  => $height,
        'access_token' => $config['service_token'],
        'v' => '5.0'
    );
    $get_params = http_build_query($request_params);
    $upload_url = json_decode(file_get_contents('https://api.vk.com/method/photos.getOwnerCoverPhotoUploadServer?' . $get_params));
    // URL to upload to
    $url = $upload_url->response->upload_url;
    // Инициализируем cURL
	$ch = curl_init();

	// Поля POST-запроса
	$cover_path = dirname(__FILE__).'/cover.jpg';
	$post_data = array('file' => new CURLFile($cover_path, 'image/jpg', 'image0'));

	// фото отправлено
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$json = curl_exec($ch);
	$obj = json_decode($json);

	// Закрываем соединение
	curl_close($ch);


	$request_params = array(
       'hash' => $obj->hash,
        'photo'   => $obj->photo,
        'access_token' => $config['service_token'],
        'v' => '5.0'
    );
    $get_params = http_build_query($request_params);
    $uploaded_photo = json_decode(file_get_contents('https://api.vk.com/method/photos.saveOwnerCoverPhoto?' . $get_params));
    //Возвращаем "ok" серверу Callback API
    echo('ok');
    break;

    default: echo 'undefined request type';
}
