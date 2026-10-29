<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$ai_fikir = "";

// Kullanıcı butona bastığında API'yi tetikle
if (isset($_POST['fikir_uret'])) {
    // 1. Kriter: Harici API Entegrasyonu (Ücretsiz tavsiye API'si)
    // 2. Kriter: Yapay Zeka (AI) Tabanlı Özellik Simülasyonu
    $api_url = "https://api.adviceslip.com/advice";
    
    // cURL ile dışarıdan veri çekme
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);
    
    if ($response) {
        $data = json_decode($response, true);
        $ingilizce_fikir = $data['slip']['advice'];
        $ai_fikir = "AI Önerisi: \"$ingilizce_fikir\" tarzında bir konsept tasarlayabiliriz!";
    } else {
        $ai_fikir = "API'ye şu an ulaşılamıyor, lütfen tekrar deneyin.";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>AI Tasarım Asistanı - baZZkıla</title>
    <style>
        body { background: #000; color: #fff; font-family: Arial; text-align: center; padding: 50px; }
        .ai-box { background: #222; padding: 30px; border-radius: 10px; max-width: 600px; margin: auto; }
        button { background: #ff4444; color: white; border: none; padding: 15px 30px; cursor: pointer; font-size: 16px; border-radius: 5px; }
        button:hover { background: #cc0000; }
        .fikir { margin-top: 20px; font-size: 20px; font-style: italic; color: #4CAF50; }
        a { color: #fff; text-decoration: none; margin-top: 30px; display: inline-block; }
    </style>
</head>
<body>

    <div class="ai-box">
        <h2>🤖 Yapay Zeka Tasarım Asistanı</h2>
        <p>Tişörtüne ne baskı yaptıracağına karar veremedin mi?<br>Yapay zekadan ilham al!</p>
        
        <form method="POST">
            <button type="submit" name="fikir_uret">Bana Bir Fikir Üret</button>
        </form>

        <?php if ($ai_fikir): ?>
            <div class="fikir"><?php echo $ai_fikir; ?></div>
        <?php endif; ?>
    </div>
    
    <a href="index.php">← Ana Sayfaya Dön</a>

</body>
</html>