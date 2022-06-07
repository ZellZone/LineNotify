# Line Notify 使用PHP


## 1.Line Notify後台註冊開啟服務
[Line Notify 官網](https://notify-bot.line.me/zh_TW/)

##### 依照官網流程註冊取得 Client ID 與 Client Secret.

## 2.綁定使用者的Line Notify

```url
ttps://notify-bot.line.me/oauth/authorize?response_type=code&scope=notify&client_id=client_id&redirect_uri=url&state=state
```
##### client_id = Line Notify後台取得的 Client ID
##### redirect_uri = Line Notify後台設定的Callback URL
##### state = 可以自訂義傳入redirect_uri中網頁的資訊
##### 使用者通過這個鏈結後台可以取得code($_GET[“code”])

## 3.使用code換取Token
[範例](https://github.com/ZellZone/LineNotify/blob/main/callback/index.php)
```php
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
```
##### redirect_uri = Line Notify後台設定的Callback URL
##### client_id = Line Notify後台取得的 Client ID
##### client_secret= Line Notify後台取得的 Client Secret
#### 執行後會取得 access_token

## 利用 Access Token 來推播訊息
[範例](https://github.com/ZellZone/LineNotify/blob/main/index.php)
```php
<?php
    //發送訊息
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://notify-api.line.me/api/notify",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => array('message' => 'hello world'),
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ".$access_token
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    echo $response;
```
