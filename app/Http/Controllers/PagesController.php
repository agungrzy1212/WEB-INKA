<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\News;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home()
    {
        $heroTitle = SiteSetting::getValue('home_hero_title', 'Sistem Informasi Pendaftaran Kursus LKP INKA Wonosobo');
        $heroSubtitle = SiteSetting::getValue('home_hero_subtitle', 'Raih Keahlian Profesional dan Masa Depan Gemilang Bersama Lembaga Pelatihan Terakreditasi di Wonosobo.');
        $ctaText = SiteSetting::getValue('home_cta_text', 'Daftar Kursus Sekarang');
        
        $coursesCount = Course::count();
        $news = News::orderBy('created_at', 'desc')->take(3)->get();
        
        return view('home', compact('heroTitle', 'heroSubtitle', 'ctaText', 'coursesCount', 'news'));
    }

    public function profil()
    {
        $about = SiteSetting::getValue('profil_about', 'LKP INKA Wonosobo merupakan lembaga kursus profesional terakreditasi.');
        $sejarah = SiteSetting::getValue('profil_sejarah', 'Didirikan di Wonosobo, LKP INKA lahir dari visi luhur untuk membantu mengurangi angka pengangguran melalui pembekalan keterampilan (vocational skills) yang aplikatif dan sesuai dengan pasar industri. Dimulai dengan kelas komputer dasar, kini LKP INKA telah berevolusi menyediakan 24 variasi program keterampilan berstandar nasional dan meluluskan puluhan ribu alumni yang sukses bekerja maupun mendirikan usaha mandiri di berbagai daerah.');
        $visi = SiteSetting::getValue('profil_visi', 'Menjadi lembaga unggulan.');
        $misi = SiteSetting::getValue('profil_misi', 'Menyelenggarakan pelatihan kerja berkualitas.');
        
        $galleryImages = \App\Models\GalleryImage::orderBy('created_at', 'desc')->get();
        
        return view('profil', compact('about', 'sejarah', 'visi', 'misi', 'galleryImages'));
    }

    public function kursus(Request $request)
    {
        $query = Course::query();
        
        if ($request->has('q') && !empty($request->q)) {
            $query->where('name', 'like', '%' . $request->q . '%')
                  ->orWhere('description', 'like', '%' . $request->q . '%');
        }
        
        if ($request->has('category') && !empty($request->category) && $request->category !== 'all') {
            $query->where('category', $request->category);
        }
        
        $courses = $query->orderBy('name', 'asc')->get();
        $categories = Course::select('category')->distinct()->pluck('category')->toArray();
        
        return view('kursus', compact('courses', 'categories'));
    }

    public function news()
    {
        $news = News::orderBy('created_at', 'desc')->get();
        return view('news', compact('news'));
    }

    public function newsDetail($id)
    {
        $article = News::findOrFail($id);
        return view('news-detail', compact('article'));
    }
}
