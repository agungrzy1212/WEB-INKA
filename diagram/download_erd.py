import base64
import urllib.request
import json

mermaid_str = """erDiagram
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
    }"""

state = {
    "code": mermaid_str,
    "mermaid": {"theme": "default"}
}
json_str = json.dumps(state)
encoded = base64.b64encode(json_str.encode('utf-8')).decode('utf-8')
url = f"https://mermaid.ink/img/pako:{encoded}" # pako isn't strictly necessary if it's base64, but mermaid.ink accepts base64 natively without pako by just using the base64 string.
url = f"https://mermaid.ink/img/{base64.urlsafe_b64encode(mermaid_str.encode('utf-8')).decode('utf-8')}"

try:
    print(f"Downloading from: {url}")
    # We add a User-Agent header as some servers block default urllib requests
    req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})
    with urllib.request.urlopen(req) as response, open(r"c:\WEB INKA\diagram\struktur-tabel.png", 'wb') as out_file:
        data = response.read()
        out_file.write(data)
    print("Success")
except Exception as e:
    print(f"Error: {e}")
