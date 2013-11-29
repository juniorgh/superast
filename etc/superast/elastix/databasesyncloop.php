#!/usr/bin/php -q
<?php
/** 
 * Script responsável pela comparação dos dados entre as bases
 * do Elastix, Asterisk e a da telefonia do sistema de CRM.
 */

exit;

$content = null;

$cURL = curl_init('http://crm.scitech.dev/settings/roles/save');
curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
$dados = array(
    'role_name' => 'Administrador de Redes 2'
);

curl_setopt($cURL, CURLOPT_POST, true);
curl_setopt($cURL, CURLOPT_POSTFIELDS, $dados);
curl_setopt($cURL, CURLOPT_REFERER, 'console@localhost');
$resultado = curl_exec($cURL);
var_dump($resultado);
curl_close($cURL);

// $handle = fopen('app.txt', 'w+');
// fwrite($handle, $content);
// fclose($handle);

?>