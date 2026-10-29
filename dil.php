<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kullanıcı dil seçerse bunu oturuma (session) kaydet
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Varsayılan dil Türkçe olsun
$secili_dil = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'tr';

// i18n Kriteri: Çeviri Dizisi
$i18n = [
    'tr' => [
        'slogan' => 'Sıradanlığı Reddet, Kendi Lüksünü Giy.',
        'yeni_gelenler' => 'Yeni Gelenler',
        'cikis' => 'Çıkış Yap',
        'iletisim' => 'İletişim'
    ],
    'en' => [
        'slogan' => 'Reject the Ordinary, Wear Your Own Luxury.',
        'yeni_gelenler' => 'New Arrivals',
        'cikis' => 'Logout',
        'iletisim' => 'Contact Us'
    ]
];
?>