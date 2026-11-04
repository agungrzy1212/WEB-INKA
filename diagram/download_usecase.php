<?php
$mermaid_code = <<<EOT
flowchart LR
    Pengunjung(["Pengunjung (Guest)"])
    Siswa(["Siswa"])
    Admin(["Admin"])

    subgraph Sistem["Sistem Informasi Pendaftaran Kursus LKP INKA"]
        direction TB
        UC1("Melihat Informasi (Home, Profil, Berita)")
        UC2("Melihat Daftar Kursus")
        UC3("Registrasi Akun")
        UC4("Login / Logout")
        UC5("Melakukan Pendaftaran Kursus")
        UC6("Membatalkan Pendaftaran")
        UC7("Melihat & Cetak Bukti")
        UC8("Kelola Data Pendaftaran")
        UC9("Kelola Data Kursus")
        UC10("Kelola Konten (Berita & Galeri)")
        UC11("Pengaturan Website")
    end

    Pengunjung --> UC1
    Pengunjung --> UC2
    Pengunjung --> UC3
    Pengunjung --> UC4

    Siswa --> UC4
    Siswa --> UC5
    Siswa --> UC6
    Siswa --> UC7

    Admin --> UC4
    Admin --> UC8
    Admin --> UC9
    Admin --> UC10
    Admin --> UC11
EOT;

$json = json_encode([
    'code' => $mermaid_code,
    'mermaid' => ['theme' => 'default']
]);

$encoded = base64_encode($json);
// mermaid.ink uses base64 but with a specific format or direct base64, actually it's just base64 string but URL safe might be needed?
// Let's use the standard base64 string. In some cases padding '=' is fine.
$url = "https://mermaid.ink/img/" . $encoded;

$options = [
    "http" => [
        "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n"
    ]
];
$context = stream_context_create($options);

$img = file_get_contents($url, false, $context);
if ($img !== false) {
    file_put_contents("c:\\WEB INKA\\diagram\\usecase.png", $img);
    echo "Success\n";
} else {
    echo "Failed to download\n";
}
