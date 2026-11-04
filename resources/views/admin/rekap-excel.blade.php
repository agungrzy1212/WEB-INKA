<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        .header-title {
            font-size: 16pt;
            font-weight: bold;
            color: #0f172a;
            text-align: center;
        }
        .header-sub {
            font-size: 11pt;
            color: #475569;
            text-align: center;
        }
        .th-header {
            background-color: #1e3c72;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
            border: 1px solid #000000;
            padding: 8px;
        }
        .td-cell {
            border: 1px solid #cccccc;
            padding: 6px;
            vertical-align: middle;
        }
        .td-center {
            text-align: center;
            border: 1px solid #cccccc;
            padding: 6px;
            vertical-align: middle;
        }
        .td-number {
            text-align: right;
            border: 1px solid #cccccc;
            padding: 6px;
            mso-number-format: "\#\,\#\#0";
        }
        .td-date {
            text-align: center;
            border: 1px solid #cccccc;
            padding: 6px;
            mso-number-format: "\@";
        }
        .status-approved {
            background-color: #dcfce7;
            color: #166534;
            font-weight: bold;
            text-align: center;
            border: 1px solid #cccccc;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #854d0e;
            font-weight: bold;
            text-align: center;
            border: 1px solid #cccccc;
        }
        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
            font-weight: bold;
            text-align: center;
            border: 1px solid #cccccc;
        }
        .total-row {
            background-color: #f1f5f9;
            font-weight: bold;
            border: 1px solid #000000;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="9" class="header-title">LEMBAGA KURSUS DAN PELATIHAN (LKP) INKA WONOSOBO</td>
        </tr>
        <tr>
            <td colspan="9" class="header-sub">LAPORAN REKAPITULASI PENDAFTARAN SISWA KURSUS</td>
        </tr>
        <tr>
            <td colspan="9" class="header-sub">Periode: {{ $periodTitle }} | Diekspor Tanggal: {{ date('d/m/Y H:i') }} WIB</td>
        </tr>
        <tr><td colspan="9"></td></tr>

        <thead>
            <tr>
                <th class="th-header" style="width: 40px;">No</th>
                <th class="th-header" style="width: 140px;">No. Registrasi</th>
                <th class="th-header" style="width: 220px;">Nama Lengkap Siswa</th>
                <th class="th-header" style="width: 180px;">Email</th>
                <th class="th-header" style="width: 130px;">No. Telepon / WhatsApp</th>
                <th class="th-header" style="width: 200px;">Program Kursus</th>
                <th class="th-header" style="width: 100px;">Tanggal Daftar</th>
                <th class="th-header" style="width: 120px;">Biaya (Rp)</th>
                <th class="th-header" style="width: 100px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $index => $item)
                <tr>
                    <td class="td-center">{{ $index + 1 }}</td>
                    <td class="td-center" style="mso-number-format: '\@';">INKA-{{ $item->created_at->format('Y') }}-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td class="td-cell">{{ $item->nama_lengkap }}</td>
                    <td class="td-cell">{{ $item->email }}</td>
                    <td class="td-center" style="mso-number-format: '\@';">{{ $item->nomer_hp }}</td>
                    <td class="td-cell">{{ $item->course ? $item->course->name : ($item->course_name ?? '-') }}</td>
                    <td class="td-date" style="mso-number-format: '\@'; text-align: center;">{{ $item->created_at ? $item->created_at->format('d/m/Y') : '-' }}</td>
                    <td class="td-number">{{ $item->course ? $item->course->price : 0 }}</td>
                    @if($item->status === 'approved')
                        <td class="status-approved">DISETUJUI</td>
                    @elseif($item->status === 'rejected')
                        <td class="status-rejected">DITOLAK</td>
                    @else
                        <td class="status-pending">PENDING</td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="td-center" style="padding: 20px;">Tidak ada data pendaftaran pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" class="total-row" style="text-align: right; padding: 8px;">TOTAL AKUMULASI BIAYA & SISWA:</td>
                <td class="total-row td-number" style="font-weight: bold;">{{ $records->sum(function($r) { return $r->course ? $r->course->price : 0; }) }}</td>
                <td class="total-row td-center">{{ $records->count() }} Orang</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
