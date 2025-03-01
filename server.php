<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tiktok_url = $_POST["video_url"];

    if (empty($tiktok_url)) {
        die("❌ خطأ: لم يتم إدخال رابط الفيديو!");
    }

    // رابط API Zefoy
    $url = "https://zefoy.com/c2VuZC9mb2xeb3dlcnNfdGlrdG9V";

    // بيانات الطلب
    $payload = [
        '050db60e' => $tiktok_url
    ];

    // إعدادات الهيدر
    $headers = [
        "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.88 Safari/537.36",
        "x-requested-with: XMLHttpRequest",
        "origin: https://zefoy.com",
        "sec-fetch-site: same-origin",
        "sec-fetch-mode: cors",
        "sec-fetch-dest: empty",
        "accept-language: ar-AE,ar;q=0.9,en-AU;q=0.8,en;q=0.7,en-US;q=0.6"
    ];

    // تنفيذ الطلب باستخدام cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');

    // الحصول على الاستجابة
    $response = curl_exec($ch);
    curl_close($ch);

    // طباعة النتيجة
    echo "<h2>✅ تم إرسال المشاهدات بنجاح!</h2>";
    echo "<p>🔗 رابط الفيديو: $tiktok_url</p>";
} else {
    echo "❌ خطأ: طلب غير صالح!";
}
?>
