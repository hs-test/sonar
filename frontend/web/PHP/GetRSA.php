<?php

include('Crypto.php');
//$url = "https://test.ccavenue.com/transaction/getRSAKey";
//$fields = array(
//    'access_code' => "AVCE02GF77BY72ECYB",
//    'order_id' => 26656565
//);
//
//$postvars = '';
//$sep = '';
//foreach ($fields as $key => $value) {
//    $postvars.= $sep . urlencode($key) . '=' . urlencode($value);
//    $sep = '&';
//}
//
//$ch = curl_init();
//
//curl_setopt($ch, CURLOPT_URL, $url);
//curl_setopt($ch, CURLOPT_POST, count($fields));
//curl_setopt($ch, CURLOPT_CAINFO, 'http://iepf.demodevelopment.com/PHP/cacert.pem');
//curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//$result = curl_exec($ch);
//
//$callbackUrl = 'ccavResponseHandler';
//$params = [
//    'currency' => 'INR',
//    'merchant_id' => '218783',
//    'order_id' => '26656565',
//    'amount' => '1',
//    'redirect_url' => $callbackUrl,
//    'cancel_url' => $callbackUrl,
//    'language' => 'EN',
//    
//];
//$merchant_data = '2';
//foreach ($params as $keydsds => $value) {
//    $merchant_data.=$keydsds . '=' . $value . '&';
//}
//
//$keyss = (string)$result;
$encrypted_data = encrypt('dadadsaddasdasdasdassd', '0A83F0CF56D73A450D20432ED4283B62');
echo $encrypted_data;
die;

//$encrypted_data = Yii::$app->ccAvenue->encrypt($merchant_data, $workingKey); // Method for encrypting the data.
?>
