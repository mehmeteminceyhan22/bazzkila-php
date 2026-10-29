<?php
session_start();
require 'db.php';

// Güvenlik Kriteri: Sadece yetkisi 'admin' olanlar girebilir
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    die("HATA: Bu sayfayı görüntüleme yetkiniz yok!");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $urun_adi = htmlspecialchars($_POST['urun_adi']);
    $fiyat = (float) $_POST['fiyat'];
    
    // 1. Kriter: Dosya Yükleme ve Yönetim Sistemi
    $hedef_klasor = "uploads/";
    if (!is_dir($hedef_klasor)) {
        mkdir($hedef_klasor, 0777, true); // Klasör yoksa oluşturur
    }
    
    $dosya_adi = time() . "_" . basename($_FILES["urun_resmi"]["name"]);
    $hedef_dosya = $hedef_klasor . $dosya_adi;
    $dosya_turu = strtolower(pathinfo($hedef_dosya, PATHINFO_EXTENSION));

    if ($dosya_turu == "jpg" || $dosya_turu == "jpeg" || $dosya_turu == "png") {
        if (move_uploaded_file($_FILES["urun_resmi"]["tmp_name"], $hedef_dosya)) {
            
            // 2. Kriter: PHP Resim İşleme Kütüphaneleri (GD Library ile Boyutlandırma)
            list($genislik, $yukseklik) = getimagesize($hedef_dosya);
            $yeni_genislik = 800;
            $yeni_yukseklik = 800; // Tişört fotoğraflarını 800x800 kare yapıyoruz
            $hedef_resim = imagecreatetruecolor($yeni_genislik, $yeni_yukseklik);
            
            // Arka planı beyaz yap (PNG'lerde siyah çıkmasın diye)
            $beyaz = imagecolorallocate($hedef_resim, 255, 255, 255);
            imagefill($hedef_resim, 0, 0, $beyaz);

            if ($dosya_turu == "png") {
                $kaynak_resim = imagecreatefrompng($hedef_dosya);
            } else {
                $kaynak_resim = imagecreatefromjpeg($hedef_dosya);
            }
            
            // Resmi yeniden boyutlandır ve kırp
            imagecopyresampled($hedef_resim, $kaynak_resim, 0, 0, 0, 0, $yeni_genislik, $yeni_yukseklik, $genislik, $yukseklik);
            
            // İşlenmiş resmi aynı isimle klasöre kaydet
            if ($dosya_turu == "png") {
                imagepng($hedef_resim, $hedef_dosya);
            } else {
                imagejpeg($hedef_resim, $hedef_dosya, 90);
            }
            imagedestroy($hedef_resim);
            imagedestroy($kaynak_resim);

            // 3. Kriter: Form Verisi ile Dinamik İçerik Üretimi (DB'ye kayıt)
            $sql = "INSERT INTO products (urun_adi, fiyat, resim_yolu) VALUES (:urun_adi, :fiyat, :resim_yolu)";
            $stmt = $db->prepare($sql);
            $stmt->execute([':urun_adi' => $urun_adi, ':fiyat' => $fiyat, ':resim_yolu' => $hedef_dosya]);
            
            $mesaj = "Harika! Ürün eklendi ve fotoğraf 800x800 olarak işlendi.";
        } else {
            $mesaj = "Fotoğraf klasöre yüklenirken bir hata oluştu.";
        }
    } else {
        $mesaj = "Hata: Sadece JPG veya PNG yükleyebilirsiniz.";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ürün Ekle - baZZkıla Admin</title>
</head>
<body>
    <h2>Yönetim Paneli - Yeni Ürün Ekle</h2>
    <?php if(isset($mesaj)) echo "<p style='color:green;'><b>$mesaj</b></p>"; ?>
    <form method="POST" enctype="multipart/form-data">
        <label>Tişört Adı:</label><br>
        <input type="text" name="urun_adi" required><br><br>
        
        <label>Fiyat (TL):</label><br>
        <input type="number" step="0.01" name="fiyat" required><br><br>
        
        <label>Ürün Fotoğrafı:</label><br>
        <!-- enctype="multipart/form-data" sayesinde dosya yükleme çalışır -->
        <input type="file" name="urun_resmi" accept="image/*" required><br><br>
        
        <button type="submit">Sisteme Yükle</button>
    </form>
    <br>
    <a href="index.php">Ana Sayfaya Dön</a>
</body>
</html>