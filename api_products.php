<?php
require 'db.php';

// Veritabanındaki ürünleri en yeniden eskiye doğru çek
$sql = "SELECT * FROM products ORDER BY id DESC";
$stmt = $db->query($sql);
$urunler = $stmt->fetchAll(PDO::FETCH_ASSOC);

// JSON Kriteri: Veriyi JSON formatında dışarı aktar
header('Content-Type: application/json; charset=utf-8');
echo json_encode($urunler);
?>