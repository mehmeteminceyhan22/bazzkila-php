<?php
// Veritabanı yapılandırma bilgileri
$host = 'localhost';
$dbname = 'bazzkila_db';
$username = 'root';
$password = ''; // XAMPP'ta varsayılan şifre boştur

try {
    // PDO ile güvenli veritabanı bağlantısı (SQL Injection önlemi)
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Hata modunu Exception (İstisna) olarak ayarla
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Güvenlik için emulate prepares kapalı tutulur
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
} catch (PDOException $e) {
    // Bağlantı hatası durumunda mesaj göster ve çalışmayı durdur
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
?>