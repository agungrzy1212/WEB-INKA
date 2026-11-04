<?php
$mermaid_str = 'erDiagram
    USERS ||--o{ REGISTRATIONS : "has"
    COURSES ||--o{ REGISTRATIONS : "has"

    USERS {
        bigint id PK
        string name
        string email
        timestamp email_verified_at
        string password
        string role
        string remember_token
        timestamp created_at
        timestamp updated_at
    }

    COURSES {
        bigint id PK
        string name
        string category
        text description
        integer price
        string duration
        string image
        timestamp created_at
        timestamp updated_at
    }

    REGISTRATIONS {
        bigint id PK
        bigint user_id FK
        bigint course_id FK
        string nama_lengkap
        date tanggal_lahir
        text alamat
        string nomer_hp
        string email
        string ijazah_path
        string ktp_path
        string kk_path
        string pas_foto_path
        string payment_receipt_path
        string status
        text admin_notes
        string course_name
        timestamp created_at
        timestamp updated_at
    }

    NEWS {
        bigint id PK
        string title
        text content
        string image_path
        timestamp created_at
        timestamp updated_at
    }

    SITE_SETTINGS {
        bigint id PK
        string key
        text value
        timestamp created_at
        timestamp updated_at
    }

    GALLERY_IMAGES {
        bigint id PK
        string title
        string image_path
        timestamp created_at
        timestamp updated_at
    }';

// JSON encoded version for pako/mermaid
$state = [
    'code' => $mermaid_str,
    'mermaid' => ['theme' => 'default']
];
$json_str = json_encode($state);
$base64 = base64_encode($json_str);
$url = "https://mermaid.ink/img/pako:" . $base64;

// Alternatively the simpler base64 encoding (Base64 URL Safe)
$base64_simple = base64_encode($mermaid_str);
$url = "https://mermaid.ink/img/" . $base64_simple;

echo "Downloading from: " . $url . "\n";

$ch = curl_init($url);
$fp = fopen("C:\\WEB INKA\\diagram\\struktur-tabel.png", "wb");

curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

$res = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);
fclose($fp);

if ($error) {
    echo "Error: " . $error . "\n";
} else {
    echo "Success!\n";
}
?>
