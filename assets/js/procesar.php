<?php

$secretKey = "6LeQBkksAAAAAKMQQ3XMCE5uoop6tYfRnbr_fblF";


if (!isset($_POST['recaptcha_response'])) {
    die("Error: token de captcha no enviado");
}

$token = $_POST['recaptcha_response'];
$userIP = $_SERVER['REMOTE_ADDR'];


$url = "https://www.google.com/recaptcha/api/siteverify";
$data = [
    'secret'   => $secretKey,
    'response' => $token,
    'remoteip' => $userIP
];

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ],
];

$context  = stream_context_create($options);
$verify   = file_get_contents($url, false, $context);
$result   = json_decode($verify);


if (
    $result->success == true &&
    $result->score >= 0.5 &&
    $result->action == 'submit'
) {
    echo "Formulario enviado correctamente";
    // Procesar formulario
} else {
    echo "Captcha sospechoso o inválido";
}



