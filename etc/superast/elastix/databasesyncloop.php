#!/usr/bin/php -q
<?php
/** 
 * Script responsável pela comparação dos dados entre as bases
 * do Elastix, Asterisk e a da telefonia do sistema de CRM.
 */

// exit;

$requestTypes = array('agents', 'queues', 'extensions', 'campaigns');

while(true) {
    foreach($requestTypes as $controller) {
        $request = curl_init(sprintf('http://crm.scitech.dev/elastix/import/%s', $controller));
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);

        $dados = array(
            'request' => 'import',
            'data' => $controller
        );

        curl_setopt($request, CURLOPT_POST, true);
        curl_setopt($request, CURLOPT_POSTFIELDS, $dados);
        curl_setopt($request, CURLOPT_REFERER, 'console@localhost');
        $response = json_decode(curl_exec($request));
        curl_close($request);

        if(!is_null($response)) {
            if($response->status == false) {
                $mail_request = curl_init('http://crm.scitech.dev/elastix/import/failure-mail');
                curl_setopt($mail_request, CURLOPT_RETURNTRANSFER, true);

                $dados = array(
                    'message' => $response->message . PHP_EOL  . PHP_EOL . print_r($response->server, 1),
                    'import-type' => $controller
                );

                curl_setopt($mail_request, CURLOPT_POST, true);
                curl_setopt($mail_request, CURLOPT_POSTFIELDS, $dados);
                curl_setopt($mail_request, CURLOPT_REFERER, 'console@localhost');
                $mail_response = json_decode(curl_exec($mail_request));
                curl_close($mail_request);
            }
        }

        sleep(60);
    }
    
}

?>