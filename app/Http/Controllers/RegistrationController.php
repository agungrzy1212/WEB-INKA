<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RegistrationController extends Controller
{
    public function form(Request $request)
    {
        $user = Auth::user();
        
        // Block admins from accessing student registration form
        if ($user->role === 'admin') {
            return redirect()->route('dashboard.admin');
        }

        $courses = Course::orderBy('name', 'asc')->get();
        
        // Find existing registration based on selected course if provided
        $selectedCourseId = $request->query('course_id');
        
        if ($selectedCourseId) {
            $registration = Registration::where('user_id', $user->id)
                ->where('course_id', $selectedCourseId)
                ->first();
            
            // If approved for this specific course, redirect to dashboard
            if ($registration && $registration->status === 'approved') {
                return redirect()->route('dashboard.siswa')->with('toast_warning', 'Pendaftaran Anda untuk kursus ini sudah disetujui, silakan cetak bukti pendaftaran.');
            }
        } else {
            // Find latest registration for pre-filling personal info and files
            $registration = Registration::where('user_id', $user->id)->latest()->first();
        }

        return view('pendaftaran.form', compact('courses', 'registration', 'selectedCourseId'));
    }

    public function submit(Request $request)
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            return redirect()->route('dashboard.admin');
        }

        // Check if registration exists for this specific course
        $existingReg = Registration::where('user_id', $user->id)
            ->where('course_id', $request->input('course_id'))
            ->first();

        // Check if user has any existing registration at all to reuse files
        $anyReg = Registration::where('user_id', $user->id)->latest()->first();

        // Validation rules
        $rules = [
            'course_id' => ['required', 'exists:courses,id'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['required', 'string'],
            'nomer_hp' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
        ];

        // Files are required on new registration if no prior registration exists, optional on update or if prior files exist
        if (!$existingReg && !$anyReg) {
            $rules['ijazah'] = ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'];
            $rules['ktp'] = ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'];
            $rules['kk'] = ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'];
            $rules['pas_foto'] = ['required', 'file', 'mimes:jpg,jpeg,png', 'max:2048'];
            $rules['payment_receipt'] = ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'];
        } else {
            $rules['ijazah'] = ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'];
            $rules['ktp'] = ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'];
            $rules['kk'] = ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'];
            $rules['pas_foto'] = ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:2048'];
            $rules['payment_receipt'] = ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'];
        }

        $validated = $request->validate($rules);
        $course = Course::findOrFail($validated['course_id']);

        $data = [
            'user_id' => $user->id,
            'course_id' => $validated['course_id'],
            'course_name' => $course->name,
            'nama_lengkap' => $validated['nama_lengkap'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'alamat' => $validated['alamat'],
            'nomer_hp' => $validated['nomer_hp'],
            'email' => $validated['email'],
            'status' => 'pending', // reset to pending on submit/update
            'admin_notes' => null, // clear old rejection/hold notes
        ];

        // Upload and save paths
        $files = ['ijazah' => 'ijazah_path', 'ktp' => 'ktp_path', 'kk' => 'kk_path', 'pas_foto' => 'pas_foto_path', 'payment_receipt' => 'payment_receipt_path'];
        
        foreach ($files as $inputName => $dbField) {
            if ($request->hasFile($inputName)) {
                // Delete old file if exists
                if ($existingReg && $existingReg->$dbField) {
                    Storage::disk('public')->delete($existingReg->$dbField);
                }
                // Store new file
                $path = $request->file($inputName)->store('registrations', 'public');
                $data[$dbField] = $path;
            } elseif ($existingReg && $existingReg->$dbField) {
                // Keep old file from this specific registration
                $data[$dbField] = $existingReg->$dbField;
            } elseif ($anyReg && $anyReg->$dbField) {
                // Reuse file from the other registration of the same user
                $data[$dbField] = $anyReg->$dbField;
            }
        }

        if ($existingReg) {
            $existingReg->update($data);
        } else {
            $existingReg = Registration::create($data);
        }

        $request->session()->flash('toast_success', 'Pendaftaran Anda berhasil dikirim! Silakan lihat bukti pendaftaran.');

        return redirect()->route('pendaftaran.bukti', ['id' => $existingReg->id]);
    }

    public function cancel(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('dashboard.admin');
        }

        $registration = Registration::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        if ($registration->status === 'pending') {
            $files = ['ijazah_path', 'ktp_path', 'kk_path', 'pas_foto_path', 'payment_receipt_path'];
            foreach ($files as $file) {
                if ($registration->$file) {
                    Storage::disk('public')->delete($registration->$file);
                }
            }
            $registration->delete();
            return redirect()->route('dashboard.siswa')->with('toast_success', 'Pendaftaran berhasil dibatalkan dan dihapus.');
        }

        return redirect()->back()->with('toast_warning', 'Hanya pendaftaran berstatus pending yang dapat dibatalkan.');
    }

    public function bukti(Request $request)
    {
        $user = Auth::user();
        
        $query = Registration::with('course')->where('user_id', $user->id);

        if ($request->has('id')) {
            $registration = $query->where('id', $request->query('id'))->first();
        } else {
            $registration = $query->latest()->first();
        }
        
        if (!$registration) {
            return redirect()->route('pendaftaran')->with('toast_warning', 'Silakan isi formulir pendaftaran terlebih dahulu.');
        }

        return view('pendaftaran.bukti', compact('registration'));
    }

    public function dashboard(Request $request)
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            return redirect()->route('dashboard.admin');
        }

        $registrations = Registration::with('course')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $registration = null;
        if ($registrations->isNotEmpty()) {
            if ($request->has('id')) {
                $registration = $registrations->firstWhere('id', $request->query('id'));
            }
            if (!$registration) {
                $registration = $registrations->first();
            }
        }

        return view('dashboard.student', compact('user', 'registrations', 'registration'));
    }
}
