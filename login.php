<?php
session_start();
require 'db.php';

// Zaten giriş yapılmışsa ana sayfaya yönlendir
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $sifre = $_POST['sifre'];

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $db->prepare($sql);
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Şifre doğrulama (Kayıt olurken hashlemiştik)
    if ($user && password_verify($sifre, $user['sifre'])) {
        // Oturum (Session) Kullanımı Kriteri
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['ad_soyad'] = $user['ad_soyad'];
        $_SESSION['rol'] = $user['rol']; // Rol Bazlı Yetkilendirme için

        // Çerez (Cookie) Kullanımı Kriteri - "Beni Hatırla"
        if (isset($_POST['beni_hatirla'])) {
            setcookie("user_email", $email, time() + (86400 * 30), "/"); // 30 gün boyunca hatırlar
        }

        header("Location: index.php");
        exit;
    } else {
        $hata = "E-posta veya şifre hatalı!";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap - baZZkıla</title>
</head>
<body>
    <h2>baZZkıla - Giriş Yap</h2>
    <?php if(isset($hata)) echo "<p style='color:red;'><b>$hata</b></p>"; ?>
    
    <form method="POST">
        <label>E-posta:</label><br>
        <!-- Çerez (Cookie) varsa e-posta kutusuna otomatik yazdırır -->
        <input type="email" name="email" value="<?php echo isset($_COOKIE['user_email']) ? htmlspecialchars($_COOKIE['user_email']) : ''; ?>" required><br><br>
        
        <label>Şifre:</label><br>
        <input type="password" name="sifre" required><br><br>
        
        <label>
            <input type="checkbox" name="beni_hatirla"> Beni Hatırla (Çerez)
        </label><br><br>

        <button type="submit">Giriş Yap</button>
    </form>
</body>
</html>