<?php
session_start();

function sendRequest($url, $postData = null, $cookieFile = 'cookies.txt') {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    if ($postData) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    }

    $headers = [
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36",
        "x-requested-with: XMLHttpRequest"
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
}

// **انتظار حل الكابتشا يدويًا من المستخدم**
$captchaUrl = "https://zefoy.com";
$response = sendRequest($captchaUrl);
if (strpos($response, "Enter the CAPTCHA") !== false) {
    die("⚠️ يجب عليك حل الكابتشا يدويًا على Zefoy أولاً من الإطار في الصفحة!");
}

// **إرسال الطلب بعد حل الكابتشا**
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $videoUrl = $_POST["video_url"] ?? '';

    if (empty($videoUrl)) {
        die("❌ خطأ: لم يتم إدخال رابط الفيديو!");
    }

    $apiUrl = "https://zefoy.com/c2VuZC9mb2xeb3dlcnNfdGlrdG9V"; // API
    $payload = ["050db60e" => $videoUrl];
    
    $result = sendRequest($apiUrl, $payload);
    echo "✅ تم إرسال المشاهدات بنجاح! النتيجة: " . htmlentities($result);
} else {
    echo "❌ خطأ: طلب غير صالح!";
}
?>
