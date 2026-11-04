import base64
import json
import urllib.request

mermaid_code = """flowchart LR
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
"""

encoded = base64.b64encode(json.dumps({"code": mermaid_code, "mermaid": {"theme": "default"}}).encode('utf-8')).decode('utf-8')
url = f"https://mermaid.ink/img/{encoded}"

try:
    urllib.request.urlretrieve(url, "c:\\WEB INKA\\diagram\\usecase.png")
    print("Success")
except Exception as e:
    print("Error:", e)
