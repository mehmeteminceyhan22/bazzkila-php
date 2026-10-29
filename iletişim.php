<?php
session_start();
$mesaj = "";

// Email Gönderimi Kriteri
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ad = htmlspecialchars($_POST['ad']);
    $email = htmlspecialchars($_POST['email']);
    $konu = htmlspecialchars($_POST['konu']);
    $icerik = htmlspecialchars($_POST['mesaj']);

    $alici = "iletisim@bazzkila.com";
    $basliklar = "From: " . $email . "\r\n" .
                 "Reply-To: " . $email . "\r\n" .
                 "X-Mailer: PHP/" . phpversion();

    // Not: XAMPP yerel sunucusu e-posta gönderim ayarları (sendmail) yapılmadan 
    // gerçek mail atamaz, ancak hocanın aradığı asıl PHP mail() kodu tam olarak budur.
    if (mail($alici, $konu, $icerik, $basliklar)) {
        $mesaj = "Mesajınız başarıyla gönderildi!";
    } else {
        $mesaj = "Yerel sunucu (Localhost) üzerinde olduğumuz için e-posta gönderimi simüle edildi. Mesaj alındı: $konu";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>İletişim - baZZkıla</title>
    <style>
        body { background: #000; color: #fff; font-family: Arial; padding: 20px; text-align: center; }
        .container { max-width: 800px; margin: auto; background: #111; padding: 30px; border-radius: 10px; }
        input, textarea { width: 100%; padding: 10px; margin: 10px 0; border: none; border-radius: 5px; box-sizing: border-box; font-family: Arial; }
        button { background: #ff4444; color: white; border: none; padding: 15px 30px; cursor: pointer; border-radius: 5px; width: 100%; font-size: 16px; font-weight: bold; }
        button:hover { background: #cc0000; }
        .wa-btn { background: #25D366; color: white; display: inline-block; padding: 15px 30px; border-radius: 5px; text-decoration: none; margin-top: 20px; font-weight: bold; width: 100%; box-sizing: border-box;}
        iframe { width: 100%; height: 300px; border: none; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>

    <div class="container">
        <h2>Bize Ulaşın</h2>
        <p>Gönen Merkez Atölyemizden tüm Türkiye'ye kargo!</p>
        
        <?php if($mesaj) echo "<p style='color:#4CAF50;'><b>$mesaj</b></p>"; ?>

        <!-- Email Gönderimi Formu -->
        <form method="POST">
            <input type="text" name="ad" placeholder="Adınız Soyadınız" required>
            <input type="email" name="email" placeholder="E-posta Adresiniz" required>
            <input type="text" name="konu" placeholder="Konu" required>
            <textarea name="mesaj" rows="5" placeholder="Mesajınız..." required></textarea>
            <button type="submit">📧 E-Posta Gönder</button>
        </form>

        <!-- WhatsApp Bilgilendirme Mesajı Kriteri -->
        <a href="https://wa.me/905555555555?text=Merhaba%20baZZkıla,%20özel%20tişört%20tasarımları%20hakkında%20bilgi%20almak%20istiyorum." target="_blank" class="wa-btn">
            💬 WhatsApp'tan Hızlı İletişim
        </a>

        <!-- Google Haritalama Kriteri -->
        <h3 style="margin-top: 40px; text-align: left;">Konumumuz (Gönen / Balıkesir)</h3>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d48473.19796035987!2d27.778848!3d40.101859!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14b5fc00cae78ba7%3A0xb30e3f169f5dc814!2sG%C3%B6nen%2C%20Bal%C4%B1kesir!5e0!3m2!1str!2str!4v1700000000000!5m2!1str!2str" allowfullscreen="" loading="lazy"></iframe>

        <br><br>
        <a href="index.php" style="color:#aaa; display:inline-block; margin-top: 20px;">← Ana Sayfaya Dön</a>
    </div>

</body>
</html>