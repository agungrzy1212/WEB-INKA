<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekapitulasi Pendaftaran - LKP INKA Wonosobo</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #1e293b;
            background: #f8fafc;
            line-height: 1.5;
            font-size: 13px;
            padding: 30px;
        }

        .action-bar {
            max-width: 1050px;
            margin: 0 auto 25px auto;
            background: white;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .print-btn {
            background: #1d4ed8;
            color: white;
            padding: 10px 22px;
            font-weight: 700;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            text-decoration: none;
        }
        .print-btn:hover {
            background: #1e40af;
            transform: translateY(-1px);
        }

        .excel-btn {
            background: #059669;
            color: white;
            padding: 10px 22px;
            font-weight: 700;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            text-decoration: none;
        }
        .excel-btn:hover {
            background: #047857;
            transform: translateY(-1px);
        }

        .back-btn {
            background: #f1f5f9;
            color: #475569;
            padding: 10px 20px;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid #cbd5e1;
        }
        .back-btn:hover {
            background: #e2e8f0;
        }

        /* Printable Document Container (A4 / Letter Styling) */
        .sheet {
            max-width: 1050px;
            margin: 0 auto;
            background: white;
            padding: 40px 45px;
            border-radius: 12px;
            box-shadow: 0 4px 30px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
        }

        /* Kop Surat Resmi */
        .kop-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 3px double #0f172a;
            padding-bottom: 18px;
            margin-bottom: 25px;
        }
        .kop-logo {
            width: 85px;
            height: auto;
            object-fit: contain;
        }
        .kop-center {
            text-align: center;
            flex: 1;
            padding: 0 20px;
        }
        .kop-center h2 {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        .kop-center h3 {
            font-size: 14px;
            font-weight: 700;
            color: #1d4ed8;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .kop-center p {
            font-size: 11.5px;
            color: #475569;
            line-height: 1.4;
        }

        .report-title-box {
            text-align: center;
            margin-bottom: 25px;
        }
        .report-title-box h1 {
            font-size: 17px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        .report-title-box .badge-filter {
            display: inline-block;
            background: #eff6ff;
            color: #1d4ed8;
            font-weight: 700;
            font-size: 12px;
            padding: 4px 14px;
            border-radius: 20px;
            border: 1px solid #bfdbfe;
        }

        /* Stats Summary Box */
        .stats-summary {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }
        .summary-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 16px;
            text-align: center;
        }
        .summary-card .number {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 2px;
        }
        .summary-card .label {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 700;
        }

        /* Table */
        table.report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            font-size: 12px;
        }
        table.report-table th, table.report-table td {
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            vertical-align: middle;
        }
        table.report-table th {
            background-color: #f1f5f9;
            color: #0f172a;
            font-weight: 800;
            text-align: left;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.3px;
        }
        table.report-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .status-tag {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .status-approved {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #86efac;
        }
        .status-pending {
            background: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
        }
        .status-rejected {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
        }

        /* Tanda Tangan */
        .signature-section {
            display: flex;
            justify-content: flex-end;
            margin-top: 40px;
            page-break-inside: avoid;
        }
        .signature-box {
            width: 250px;
            text-align: center;
        }
        .signature-box .date-line {
            font-size: 12px;
            margin-bottom: 5px;
        }
        .signature-box .role-line {
            font-weight: 700;
            font-size: 12px;
            margin-bottom: 60px;
        }
        .signature-box .name-line {
            font-weight: 800;
            font-size: 13px;
            text-decoration: underline;
        }
        .signature-box .nip-line {
            font-size: 11px;
            color: #64748b;
        }

        /* Print Media Styles */
        @media print {
            body {
                background: white;
                padding: 0;
                font-size: 11pt;
            }
            .action-bar {
                display: none !important;
            }
            .sheet {
                box-shadow: none;
                border: none;
                padding: 10mm 15mm;
                max-width: 100%;
            }
            @page {
                size: A4 landscape;
                margin: 10mm;
            }
            table.report-table th {
                background-color: #f1f5f9 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .status-tag {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <!-- ACTION CONTROLS (HIDDEN WHEN PRINTING) -->
    <div class="action-bar">
        <a href="{{ route('dashboard.admin', ['tab' => 'rekap']) }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('admin.rekap.excel', ['year' => $year, 'month' => $month, 'status' => $status]) }}" class="excel-btn">
                <i class="fa-solid fa-file-excel"></i> Ekspor ke Excel (.xls)
            </a>
            <button onclick="window.print()" class="print-btn">
                <i class="fa-solid fa-print"></i> Cetak Dokumen / Simpan PDF
            </button>
        </div>
    </div>

    <!-- DOCUMENT SHEET -->
    <div class="sheet">
        
        <!-- KOP SURAT RESMI -->
        <div class="kop-header">
            <img src="{{ asset('img/logo.png') }}" alt="Logo LKP INKA" class="kop-logo">
            <div class="kop-center">
                <h2>LEMBAGA KURSUS DAN PELATIHAN (LKP) INKA</h2>
                <h3>TERAKREDITASI BAN</h3>
                <p>Jl.Bhayangkara No. 45 Rt 004 Rw 011, Kel.Wonosobo Barat, Kec.Wonosobo Kab.Wonosobo, Prov.Jawa Tengah 56311<br>Telepon: (0286)321403 | WhatsApp: 082324876436 | Website: https://lkpinka.com</p>
            </div>
            <div style="width: 85px;"></div>
        </div>

        <!-- REPORT TITLE -->
        <div class="report-title-box">
            <h1>LAPORAN REKAPITULASI PENDAFTARAN SISWA KURSUS</h1>
            <div class="badge-filter">
                <i class="fa-solid fa-calendar-check" style="margin-right: 5px;"></i> Periode: {{ $filterLabel }}
                @if($status)
                    | Status: {{ strtoupper($status) }}
                @endif
            </div>
        </div>

        <!-- SUMMARY STATS -->
        <div class="stats-summary">
            <div class="summary-card">
                <div class="number" style="color: #0f172a;">{{ $records->count() }}</div>
                <div class="label">Total Terdaftar</div>
            </div>
            <div class="summary-card">
                <div class="number" style="color: #15803d;">{{ $records->where('status', 'approved')->count() }}</div>
                <div class="label">Disetujui</div>
            </div>
            <div class="summary-card">
                <div class="number" style="color: #b45309;">{{ $records->where('status', 'pending')->count() }}</div>
                <div class="label">Menunggu (Pending)</div>
            </div>
            <div class="summary-card">
                <div class="number" style="color: #b91c1c;">{{ $records->where('status', 'rejected')->count() }}</div>
                <div class="label">Ditolak</div>
            </div>
        </div>

        <!-- DATA TABLE -->
        <table class="report-table">
            <thead>
                <tr>
                    <th style="width: 35px; text-align: center;">No</th>
                    <th style="width: 100px;">No. Registrasi</th>
                    <th>Nama Lengkap</th>
                    <th>Program Kursus</th>
                    <th style="width: 110px;">No. Telepon / HP</th>
                    <th style="width: 95px;">Tgl Daftar</th>
                    <th style="width: 100px; text-align: right;">Biaya Kursus</th>
                    <th style="width: 90px; text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $index => $item)
                    <tr>
                        <td style="text-align: center; font-weight: 700;">{{ $index + 1 }}</td>
                        <td style="font-family: monospace; font-weight: 700;">INKA-{{ $item->created_at->format('Y') }}-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td style="font-weight: 600;">
                            {{ $item->nama_lengkap }}
                            <div style="font-size: 10px; color: #64748b;">{{ $item->email }}</div>
                        </td>
                        <td>{{ $item->course ? $item->course->name : ($item->course_name ?? '-') }}</td>
                        <td>{{ $item->nomer_hp }}</td>
                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                        <td style="text-align: right; font-weight: 700;">Rp {{ number_format($item->course ? $item->course->price : 0, 0, ',', '.') }}</td>
                        <td style="text-align: center;">
                            @if($item->status === 'approved')
                                <span class="status-tag status-approved">Disetujui</span>
                            @elseif($item->status === 'rejected')
                                <span class="status-tag status-rejected">Ditolak</span>
                            @else
                                <span class="status-tag status-pending">Pending</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 30px; color: #64748b;">
                            Tidak ada data pendaftaran yang sesuai dengan filter periode ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background: #f1f5f9; font-weight: 800;">
                    <td colspan="6" style="text-align: right; text-transform: uppercase;">Total Pendaftar / Akumulasi Biaya:</td>
                    <td style="text-align: right; color: #1d4ed8;">
                        Rp {{ number_format($records->sum(function($r) { return $r->course ? $r->course->price : 0; }), 0, ',', '.') }}
                    </td>
                    <td style="text-align: center;">{{ $records->count() }} Orang</td>
                </tr>
            </tfoot>
        </table>

        <!-- SIGNATURE SECTION -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="date-line">Wonosobo, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                <div class="role-line">Pimpinan LKP INKA Wonosobo,</div>
                <div class="name-line">Akhmad Ridhowi S.Kom.</div>
            </div>
        </div>

    </div>

</body>
</html>
