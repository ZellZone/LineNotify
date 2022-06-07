<?php
    //取得token
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://notify-bot.line.me/oauth/token",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => array(
        'grant_type' => 'authorization_code',
        'redirect_uri' => 'redirect_uri',
        'client_id' => 'client_id',
        'client_secret' => 'client_secret',
        'code' => $_GET["code"]
      ),
      CURLOPT_HTTPHEADER => array(
        "Content-Type:  application/x-www-form-urlencoded"
      ),
    ));
    
    $response = curl_exec($curl);
    curl_close($curl);
    $obj = json_decode($response);
    echo json_encode($obj, true);