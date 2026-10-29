<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ad_soyad = htmlspecialchars($_POST['ad_soyad']);
    $email = htmlspecialchars($_POST['email']);
    $sifre = password_hash($_POST['sifre'], PASSWORD_DEFAULT); // Güvenlik Kriteri: Şifreleme

    $sql = "INSERT INTO users (ad_soyad, email, sifre) VALUES (:ad_soyad, :email, :sifre)";
    $stmt = $db->prepare($sql);
    
    try {
        $stmt->execute([':ad_soyad' => $ad_soyad, ':email' => $email, ':sifre' => $sifre]);
        $mesaj = "Kayıt başarılı! Şimdi giriş yapabilirsiniz.";
    } catch (PDOException $e) {
        $mesaj = "Hata: Bu e-posta adresi zaten sistemde kayıtlı.";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kayıt Ol - baZZkıla</title>
</head>
<body>
    <h2>baZZkıla - Yeni Müşteri Kaydı</h2>
    <?php if(isset($mesaj)) echo "<p><b>$mesaj</b></p>"; ?>
    <form method="POST">
        <label>Ad Soyad:</label><br>
        <input type="text" name="ad_soyad" required><br><br>
        <label>E-posta:</label><br>
        <input type="email" name="email" required><br><br>
        <label>Şifre:</label><br>
        <input type="password" name="sifre" required><br><br>
        <button type="submit">Kayıt Ol</button>
    </form>
</body>
</html>