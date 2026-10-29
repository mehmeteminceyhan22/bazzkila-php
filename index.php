<?php
require 'dil.php'; // Çoklu dil motorunu dahil et

// Güvenlik Kriteri: Giriş yapılmamışsa logine gönder
if (!isset($_SESSION['user_id'])) {
    header("Location: login"); // SEO uyumlu URL (.php yok)
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>baZZkıla - Kendi Lüksünü Giy</title>
    <style>
        /* Tema/Şablon Entegrasyonu & Responsive Tasarım Kriterleri */
        body {
            background-color: #000;
            color: #fff;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background: #111;
            border-bottom: 1px solid #333;
        }
        .header a { color: #fff; text-decoration: none; margin-left: 15px; }
        .hero {
            text-align: center;
            padding: 100px 20px;
            font-size: 2.5rem;
            font-weight: bold;
            letter-spacing: 2px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        /* Mobil uyumlu Grid ızgara sistemi */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }
        .card {
            background: #111;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.3s;
        }
        .card:hover { transform: scale(1.05); }
        .card img {
            max-width: 100%;
            border-radius: 5px;
        }
        .btn {
            background: #fff;
            color: #000;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
            margin-top: 15px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>baZZkıla</h2>
        <div>
            <!-- Çoklu Dil (i18n) Butonları -->
            <a href="?lang=tr" style="font-size: 20px;">🇹🇷 TR</a> | 
            <a href="?lang=en" style="font-size: 20px;">🇬🇧 EN</a>
            
            <span style="margin-left: 15px; color:#aaa;">Hoş Geldin, <?php echo htmlspecialchars($_SESSION['ad_soyad']); ?></span>
            
            <?php if ($_SESSION['rol'] == 'admin'): ?>
                <!-- Linklerdeki .php uzantılarını kaldırdık (SEO Kriteri) -->
                <a href="add_product" style="color: #ff4444;">[+] Ürün Ekle</a>
            <?php endif; ?>
            
            <a href="ai_tasarim" style="color: #4CAF50;">[🤖 AI Asistan]</a>
            
            <!-- Dinamik Çevirili Butonlar -->
            <a href="iletisim" style="color: #ccc;"><?php echo $i18n[$secili_dil]['iletisim']; ?></a>
            <a href="login?cikis=1" style="color: #ccc;"><?php echo $i18n[$secili_dil]['cikis']; ?></a>
        </div>
    </div>

    <div class="hero">
        <!-- Dinamik Çevirili Slogan -->
        <?php echo $i18n[$secili_dil]['slogan']; ?>
    </div>

    <div class="container">
        <!-- Dinamik Çevirili Başlık -->
        <h3 style="border-bottom: 1px solid #333; padding-bottom: 10px;"><?php echo $i18n[$secili_dil]['yeni_gelenler']; ?></h3>
        
        <!-- Ürünlerin JavaScript ile basılacağı boş kutu -->
        <div class="grid" id="product-grid"></div>
    </div>

    <script>
        // api_products.php'den JSON verisini çekme (JS Etkileşimli Arayüz)
        fetch('api_products.php')
            .then(response => response.json())
            .then(data => {
                const grid = document.getElementById('product-grid');
                
                if(data.length === 0) {
                    grid.innerHTML = "<p>Henüz ürün eklenmemiş.</p>";
                    return;
                }

                data.forEach(urun => {
                    grid.innerHTML += `
                        <div class="card">
                            <img src="${urun.resim_yolu}" alt="${urun.urun_adi}">
                            <h4>${urun.urun_adi}</h4>
                            <p style="color: #aaa;">${urun.fiyat} ₺</p>
                            <a href="#" class="btn">İncele</a>
                        </div>
                    `;
            })
            .catch(error => console.error('Veri çekme hatası:', error));
    </script>
</body>
</html>