<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\News;
use App\Models\Registration;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Enforce admin check for safety.
     */
    protected function checkAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        }
    }

    public function dashboard()
    {
        $this->checkAdmin();

        $registrations = Registration::with(['user', 'course'])->orderBy('created_at', 'desc')->get();
        $courses = Course::orderBy('name', 'asc')->get();
        $news = News::orderBy('created_at', 'desc')->get();
        $galleryImages = \App\Models\GalleryImage::orderBy('created_at', 'desc')->get();

        // Available years for filter
        $availableYears = Registration::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();
        if (empty($availableYears)) {
            $availableYears = [(int)date('Y')];
        }

        // Summary counts for Rekap
        $totalAll = Registration::count();
        $totalApproved = Registration::where('status', 'approved')->count();
        $totalPending = Registration::where('status', 'pending')->count();
        $totalRejected = Registration::where('status', 'rejected')->count();

        // Rekap per Tahun
        $rekapPerTahun = Registration::selectRaw('YEAR(created_at) as year, COUNT(*) as total,
            SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved_count,
            SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending_count,
            SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected_count')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        // Rekap per Bulan (Current Year by default or all)
        $currentFilterYear = request('filter_year', date('Y'));
        $currentFilterMonth = request('filter_month', '');

        $rekapBulanQuery = Registration::query();
        if ($currentFilterYear !== 'all') {
            $rekapBulanQuery->whereYear('created_at', $currentFilterYear);
        }
        if (!empty($currentFilterMonth)) {
            $rekapBulanQuery->whereMonth('created_at', $currentFilterMonth);
        }
        $filteredRegistrations = (clone $rekapBulanQuery)->with(['course', 'user'])->orderBy('created_at', 'desc')->get();

        // Site settings for CMS
        $settings = [
            'home_hero_title' => SiteSetting::getValue('home_hero_title'),
            'home_hero_subtitle' => SiteSetting::getValue('home_hero_subtitle'),
            'home_cta_text' => SiteSetting::getValue('home_cta_text'),
            'profil_about' => SiteSetting::getValue('profil_about'),
            'profil_sejarah' => SiteSetting::getValue('profil_sejarah'),
            'profil_visi' => SiteSetting::getValue('profil_visi'),
            'profil_misi' => SiteSetting::getValue('profil_misi'),
        ];

        return view('dashboard.admin', compact(
            'registrations', 
            'courses', 
            'news', 
            'galleryImages', 
            'settings',
            'availableYears',
            'totalAll',
            'totalApproved',
            'totalPending',
            'totalRejected',
            'rekapPerTahun',
            'currentFilterYear',
            'currentFilterMonth',
            'filteredRegistrations'
        ));
    }

    /**
     * Halaman Cetak PDF Laporan Rekap Pendaftar
     */
    public function printRekapPdf(Request $request)
    {
        $this->checkAdmin();

        $year = $request->query('year', date('Y'));
        $month = $request->query('month', '');
        $status = $request->query('status', '');

        $query = Registration::with(['course', 'user']);

        if ($year !== 'all' && !empty($year)) {
            $query->whereYear('created_at', $year);
        }
        if (!empty($month)) {
            $query->whereMonth('created_at', $month);
        }
        if (!empty($status)) {
            $query->where('status', $status);
        }

        $records = $query->orderBy('created_at', 'asc')->get();

        $monthNames = [
            '1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April',
            '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus',
            '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];

        $filterLabel = 'Semua Periode';
        if ($year !== 'all' && !empty($month)) {
            $filterLabel = 'Bulan ' . ($monthNames[(string)(int)$month] ?? $month) . ' ' . $year;
        } elseif ($year !== 'all') {
            $filterLabel = 'Tahun ' . $year;
        } elseif (!empty($month)) {
            $filterLabel = 'Bulan ' . ($monthNames[(string)(int)$month] ?? $month) . ' (Semua Tahun)';
        }

        return view('admin.rekap-cetak-pdf', compact('records', 'year', 'month', 'status', 'filterLabel', 'monthNames'));
    }

    /**
     * Ekspor Rekap Pendaftar ke Excel (format .xls kompatibel universal dengan styling rapi)
     */
    public function exportRekapExcel(Request $request)
    {
        $this->checkAdmin();

        $year = $request->query('year', date('Y'));
        $month = $request->query('month', '');
        $status = $request->query('status', '');

        $query = Registration::with(['course', 'user']);

        if ($year !== 'all' && !empty($year)) {
            $query->whereYear('created_at', $year);
        }
        if (!empty($month)) {
            $query->whereMonth('created_at', $month);
        }
        if (!empty($status)) {
            $query->where('status', $status);
        }

        $records = $query->orderBy('created_at', 'asc')->get();

        $monthNames = [
            '1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April',
            '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus',
            '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];

        $periodTitle = 'Semua Periode';
        $fileSuffix = 'SEMUA';
        if ($year !== 'all' && !empty($month)) {
            $periodTitle = ($monthNames[(string)(int)$month] ?? $month) . ' ' . $year;
            $fileSuffix = ($monthNames[(string)(int)$month] ?? $month) . '_' . $year;
        } elseif ($year !== 'all') {
            $periodTitle = 'Tahun ' . $year;
            $fileSuffix = 'TAHUN_' . $year;
        }

        $fileName = 'REKAP_PENDAFTAR_INKA_' . str_replace(' ', '_', strtoupper($fileSuffix)) . '_' . date('Ymd_His') . '.xls';

        return response()->view('admin.rekap-excel', compact('records', 'periodTitle', 'year', 'month', 'status'), 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control' => 'max-age=0, no-cache, must-revalidate, proxy-revalidate',
            'Pragma' => 'public',
        ]);
    }

    public function processRegistration(Request $request, $id)
    {
        $this->checkAdmin();

        $request->validate([
            'status' => ['required', 'in:approved,rejected'],
            'admin_notes' => ['nullable', 'string'],
        ]);

        $registration = Registration::findOrFail($id);
        $registration->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        $statusText = $request->status === 'approved' ? 'DISETUJUI' : 'DITOLAK';
        $request->session()->flash('toast_success', 'Status pendaftaran ' . $registration->nama_lengkap . ' berhasil diubah menjadi ' . $statusText . '.');

        return redirect()->route('dashboard.admin', ['tab' => 'pendaftar']);
    }

    public function destroyRegistration($id)
    {
        $this->checkAdmin();

        $registration = Registration::with('course')->findOrFail($id);
        $name = $registration->nama_lengkap;
        $courseName = $registration->course->name;

        // Delete uploaded files only if they are not used by any other registration of this user or others
        $files = ['ijazah_path', 'ktp_path', 'kk_path', 'pas_foto_path', 'payment_receipt_path'];
        foreach ($files as $field) {
            $filePath = $registration->$field;
            if ($filePath) {
                // Check if any other registration record is using the same file path
                $isUsedElsewhere = Registration::where('id', '!=', $registration->id)
                    ->where($field, $filePath)
                    ->exists();

                if (!$isUsedElsewhere) {
                    Storage::disk('public')->delete($filePath);
                }
            }
        }

        $registration->delete();
        session()->flash('toast_success', 'Data pendaftaran kursus "' . $courseName . '" oleh ' . $name . ' berhasil dihapus.');

        return redirect()->route('dashboard.admin', ['tab' => 'pendaftar']);
    }

    public function updateSettings(Request $request)
    {
        $this->checkAdmin();

        $request->validate([
            'home_hero_title' => ['required', 'string', 'max:255'],
            'home_hero_subtitle' => ['required', 'string'],
            'home_cta_text' => ['required', 'string', 'max:50'],
            'profil_about' => ['required', 'string'],
            'profil_sejarah' => ['required', 'string'],
            'profil_visi' => ['required', 'string'],
            'profil_misi' => ['required', 'string'],
        ]);

        SiteSetting::setValue('home_hero_title', $request->home_hero_title);
        SiteSetting::setValue('home_hero_subtitle', $request->home_hero_subtitle);
        SiteSetting::setValue('home_cta_text', $request->home_cta_text);
        SiteSetting::setValue('profil_about', $request->profil_about);
        SiteSetting::setValue('profil_sejarah', $request->profil_sejarah);
        SiteSetting::setValue('profil_visi', $request->profil_visi);
        SiteSetting::setValue('profil_misi', $request->profil_misi);

        $request->session()->flash('toast_success', 'Konten website (CMS) LKP INKA berhasil diperbarui.');

        return redirect()->route('dashboard.admin', ['tab' => 'cms']);
    }

    /* --- COURSES CRUD --- */

    public function storeCourse(Request $request)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'duration' => ['nullable', 'string', 'max:100'],
        ]);

        Course::create($validated);

        $request->session()->flash('toast_success', 'Program kursus baru "' . $request->name . '" berhasil ditambahkan.');

        return redirect()->route('dashboard.admin', ['tab' => 'kursus']);
    }

    public function updateCourse(Request $request, $id)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'duration' => ['nullable', 'string', 'max:100'],
        ]);

        $course = Course::findOrFail($id);
        $course->update($validated);

        $request->session()->flash('toast_success', 'Program kursus "' . $request->name . '" berhasil diperbarui.');

        return redirect()->route('dashboard.admin', ['tab' => 'kursus']);
    }

    public function destroyCourse($id)
    {
        $this->checkAdmin();

        $course = Course::findOrFail($id);
        $courseName = $course->name;
        $course->delete();

        session()->flash('toast_success', 'Program kursus "' . $courseName . '" berhasil dihapus.');

        return redirect()->route('dashboard.admin', ['tab' => 'kursus']);
    }

    /* --- NEWS CRUD --- */

    public function storeNews(Request $request)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = [
            'title' => $validated['title'],
            'content' => $validated['content'],
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('news', 'public');
        }

        News::create($data);

        $request->session()->flash('toast_success', 'Berita baru berhasil diterbitkan.');

        return redirect()->route('dashboard.admin', ['tab' => 'berita']);
    }

    public function updateNews(Request $request, $id)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $news = News::findOrFail($id);
        $data = [
            'title' => $validated['title'],
            'content' => $validated['content'],
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if ($news->image_path) {
                Storage::disk('public')->delete($news->image_path);
            }
            $data['image_path'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);

        $request->session()->flash('toast_success', 'Berita "' . $news->title . '" berhasil diperbarui.');

        return redirect()->route('dashboard.admin', ['tab' => 'berita']);
    }

    public function destroyNews($id)
    {
        $this->checkAdmin();

        $news = News::findOrFail($id);
        if ($news->image_path) {
            Storage::disk('public')->delete($news->image_path);
        }
        $newsName = $news->title;
        $news->delete();

        session()->flash('toast_success', 'Berita "' . $newsName . '" berhasil dihapus.');

        return redirect()->route('dashboard.admin', ['tab' => 'berita']);
    }

    /* --- GALLERY CRUD --- */

    public function storeGallery(Request $request)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'image' => ['required', 'image', 'max:2048'],
        ]);

        $path = $request->file('image')->store('gallery', 'public');

        \App\Models\GalleryImage::create([
            'title' => $validated['title'],
            'image_path' => $path,
        ]);

        $request->session()->flash('toast_success', 'Foto galeri kegiatan berhasil ditambahkan.');

        return redirect()->route('dashboard.admin', ['tab' => 'galeri']);
    }

    public function destroyGallery($id)
    {
        $this->checkAdmin();

        $gallery = \App\Models\GalleryImage::findOrFail($id);
        if ($gallery->image_path) {
            Storage::disk('public')->delete($gallery->image_path);
        }
        $gallery->delete();

        session()->flash('toast_success', 'Foto galeri kegiatan berhasil dihapus.');

        return redirect()->route('dashboard.admin', ['tab' => 'galeri']);
    }
}
