<?php
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://waaw1.tv/player/embed_player.php?vid=bYOfnHYp24b2');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


$headers = array();
$headers[] = 'Referer:https://www.verfilmeshd.gratis/';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

var_dump ($result);
?>