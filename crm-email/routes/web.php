<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Models\EmailTemplate;
use App\Models\EmailLog;
use App\Models\WaLog;
use App\Models\User;
use App\Models\Pic;

use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class,'loginForm'])->name('login');
Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/dashboard');
});

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    =====================
    DASHBOARD
    =====================
    */
   Route::get('/dashboard', function (Request $request) {

    $query = EmailLog::query();

    if ($request->from && $request->to) {
        $query->whereBetween('created_at', [
            $request->from.' 00:00:00',
            $request->to.' 23:59:59'
        ]);
    }

    $totalEmails = $query->count();

    // ✅ PAGINATION
    $recentEmails = $query->latest()->paginate(10);

    // ✅ AGAR FILTER TETAP SAAT PINDAH HALAMAN
    $recentEmails->appends($request->all());

    $totalTemplates = EmailTemplate::count();

    return view('dashboard', compact(
        'totalEmails',
        'totalTemplates',
        'recentEmails'
    ));
});

    /*
    =====================
    ✅ BARU: EXPORT EMAIL LOG KE EXCEL (CSV)
    =====================
    */
    Route::get('/dashboard/export', function (Request $request) {

        $query = EmailLog::query();

        if ($request->from && $request->to) {
            $query->whereBetween('created_at', [
                $request->from.' 00:00:00',
                $request->to.' 23:59:59'
            ]);
        }

        $emails = $query->latest()->get();

        $fileName = 'email-log-' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        return response()->streamDownload(function () use ($emails) {

            $handle = fopen('php://output', 'w');

            // ✅ BOM UTF-8 supaya Excel baca karakter dengan benar
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, ['No', 'Case ID', 'PIC', 'Customer', 'Email', 'Nomor WA', 'Subject', 'Tanggal']);

            foreach ($emails as $i => $row) {
                fputcsv($handle, [
                    $i + 1,
                    $row->case_id,
                    $row->pic,
                    $row->customer_name,
                    $row->customer_email,
                    $row->customer_phone,
                    $row->subject,
                    \Carbon\Carbon::parse($row->created_at)->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);

        }, $fileName, $headers);
    })->name('dashboard.export');

    /*
    =====================
    CREATE EMAIL
    =====================
    */
    Route::get('/create-email', function () {
    $templates = EmailTemplate::all();
    $pics = Pic::all(); // ✅ TAMBAH INI

    return view('create-email', compact('templates','pics'));
});

    Route::get('/get-template-fields/{id}', function ($id) {
        $template = EmailTemplate::find($id);
        return response()->json([
            'fields' => json_decode($template->required_fields)
        ]);
    });

    /*
    =====================
    WA DASHBOARD
    =====================
    */
    Route::get('/wa-dashboard', function (Request $request) {

    $query = WaLog::query();

    if($request->from && $request->to){
        $query->whereBetween('created_at', [
            $request->from.' 00:00:00',
            $request->to.' 23:59:59'
        ]);
    }

    $totalWa = $query->count();

    // ✅ PAGINATION
    $recentWa = $query->latest()->paginate(10);

    // ✅ BIAR FILTER TETAP
    $recentWa->appends($request->all());

    return view('wa-dashboard', compact('totalWa','recentWa'));
});

    /*
    =====================
    ✅ BARU: EXPORT WA LOG KE EXCEL (CSV)
    =====================
    */
    Route::get('/wa-dashboard/export', function (Request $request) {

        $query = WaLog::query();

        if ($request->from && $request->to) {
            $query->whereBetween('created_at', [
                $request->from.' 00:00:00',
                $request->to.' 23:59:59'
            ]);
        }

        $waLogs = $query->latest()->get();

        $fileName = 'wa-log-' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        return response()->streamDownload(function () use ($waLogs) {

            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, ['No', 'Case ID', 'PIC', 'Customer', 'Nomor', 'Pesan', 'Status', 'Tanggal']);

            foreach ($waLogs as $i => $row) {
                fputcsv($handle, [
                    $i + 1,
                    $row->case_id,
                    $row->pic,
                    $row->customer_name,
                    $row->customer_phone,
                    $row->message,
                    $row->status,
                    \Carbon\Carbon::parse($row->created_at)->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);

        }, $fileName, $headers);
    })->name('wa.dashboard.export');
    /*
    =====================
    TEST EMAIL
    =====================
    */
    Route::get('/test-email', function () {

        Mail::raw('Test Email Laravel CRM', function ($message) {
            $message->to('emailtujuan@gmail.com')
                    ->subject('Test Email');
        });

        return 'Email Sent';
    });

    /*
    =====================
    SEND EMAIL + WA
    =====================
    */
    Route::post('/send-email', function (Request $request) {

    // =====================
    // VALIDASI
    // =====================
    $request->validate([
        'customer_name' => 'required',
        'customer_email' => 'required|email',
        'customer_phone' => 'required',
        'attachment' => 'nullable|file|mimes:pdf,doc,docx,xlsx,png,jpg|max:2048'
    ]);

    // =====================
    // AMBIL TEMPLATE
    // =====================
    $template = EmailTemplate::find($request->template_id);

    if (!$template) {
        return back()->with('error', 'Template tidak ditemukan');
    }

    $channels = $request->channels ?? [];

    if (empty($channels)) {
        return back()->with('error', 'Pilih metode pengiriman');
    }

    // =====================
    // PREPARE DATA
    // =====================
    $data = $request->all();
    unset($data['channels']);

    $waBody = $template->wa_body ?? '';

    // DEFAULT DATA
    $data['sender_name'] = "HP Service Center Semarang";
    $data['sender_position'] = "Customer Service";
    $data['company_name'] = "PT. Harmoni Putra Solusindo";
    $data['sender_phone'] = "085747009467";

    $subject = $template->subject;
    $body = $template->body;

    foreach ($data as $key => $value) {
        if (is_array($value)) continue;

        $subject = str_replace('{{' . $key . '}}', $value, $subject);
        $body = str_replace('{{' . $key . '}}', $value, $body);
        $waBody = str_replace('{{' . $key . '}}', $value, $waBody);
    }

    // =====================
    // HANDLE ATTACHMENT
    // =====================
    $filePath = null;
    $isImageAttachment = false;

    if ($request->hasFile('attachment')) {
        $file = $request->file('attachment');

    $originalName = $file->getClientOriginalName();

    // ✅ CEK APAKAH FILE INI GAMBAR (supaya bisa ditampilkan langsung di
    //    badan email tanpa perlu didownload, bukan sekadar jadi lampiran)
    $isImageAttachment = str_starts_with($file->getMimeType(), 'image/');

    $filePath = $file->storeAs('attachments', $originalName, 'public');
    }

    // =====================
    // SEND EMAIL
    // =====================
    if (in_array('email', $channels)) {

        Mail::send([], [], function ($message) use ($request, $subject, $body, $filePath, $isImageAttachment) {

            $logoPath = public_path('images/signiture.png');
            $cid = file_exists($logoPath) ? $message->embed($logoPath) : '';

            $finalBody = str_replace('{{company_logo}}', $cid, $body);

            // ✅ KALAU LAMPIRANNYA GAMBAR: embed langsung ke badan email
            //    supaya customer bisa lihat tanpa perlu klik/download.
            if ($filePath && $isImageAttachment) {
                $attachmentCid = $message->embed(storage_path('app/public/' . $filePath));
                $finalBody .= '<p><img src="' . $attachmentCid . '" style="max-width:100%; height:auto; margin-top:15px; border-radius:6px;" alt="Lampiran Gambar"></p>';
            }

            $message->to($request->customer_email)
                ->bcc('yogi.prastiya@harmoniputra.com')
                ->subject($subject)
                ->from(config('mail.from.address'), config('mail.from.name'))
                ->replyTo('custcare@harmoniputra.com', 'Customer Care')
                ->html($finalBody);

            // ✅ ATTACH FILE DARI STORAGE — hanya untuk file NON-gambar
            //    (PDF, Word, Excel, dll) yang memang harus didownload dulu.
            //    Gambar tidak dobel dilampirkan karena sudah tampil inline di atas.
            if ($filePath && !$isImageAttachment) {
                $message->attach(storage_path('app/public/' . $filePath));
            }
        });
    }

    // =====================
    // SEND WHATSAPP
    // =====================
    if (in_array('wa', $channels)) {

        $formatPhone = function ($phone) {
            $phone = preg_replace('/[^0-9]/', '', $phone);

            if (substr($phone, 0, 1) == '0') {
                $phone = '62' . substr($phone, 1);
            }

            return $phone;
        };

        $mainPhone = $formatPhone($request->customer_phone);

        $response = Http::withHeaders([
            'x-api-key' => '123456'
        ])->post('http://localhost:2025/send', [
            'nomor' => $mainPhone,
            'pesan' => $waBody
        ]);

        // BCC WA
        foreach ($request->input('bcc_phones', []) as $phone) {

            if (empty($phone)) continue;

            $phone = $formatPhone($phone);

            $bccResponse = Http::withHeaders([
                'x-api-key' => '123456'
            ])->post('http://localhost:2025/send', [
                'nomor' => $phone,
                'pesan' => "[COPY] " . $waBody
            ]);

            if (!$bccResponse->successful()) {
                \Log::error('WA BCC gagal', [
                    'phone' => $phone,
                    'response' => $bccResponse->body()
                ]);
            }

            sleep(1);
        }

        WaLog::create([
            'pic' => $request->pic,
            'customer_name' => $request->customer_name,
            'customer_phone' => $mainPhone,
            'case_id' => $request->workorder,
            'message' => $waBody,
            'status' => $response->successful() ? 'sent' : 'failed'
        ]);
    }

    // =====================
    // LOG EMAIL
    // =====================
    EmailLog::create([
        'pic' => $request->pic,
        'customer_name' => $request->customer_name,
        'customer_email' => $request->customer_email,
        'customer_phone' => $request->customer_phone,
        'case_id' => $request->workorder,
        'subject' => $subject,
        'attachment' => $filePath // ✅ SIMPAN PATH
    ]);

    return redirect('/dashboard')->with('success', 'Pesan berhasil dikirim');
});
    /*
    =====================
    👑 ADMIN ONLY (CS0)
    =====================
    */

    Route::get('/users', function () {
        if(auth()->user()->role != 'admin') abort(403);

        $users = User::all();
        return view('users', compact('users'));
    });

    Route::get('/users/create', function () {
        if(auth()->user()->role != 'admin') abort(403);

        return view('create-user');
    });

    Route::post('/users/store', function (Request $request) {
        if(auth()->user()->role != 'admin') abort(403);

        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email, // ✅ WAJIB
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return redirect('/users')->with('success','User ditambahkan');
    });

    Route::get('/users/edit/{id}', function ($id) {
        if(auth()->user()->role != 'admin') abort(403);

        $user = User::findOrFail($id);
        return view('edit-user', compact('user'));
    });

    Route::post('/users/update/{id}', function (Request $request, $id) {
        if(auth()->user()->role != 'admin') abort(403);

        $user = User::findOrFail($id);

        $user->username = $request->username;
        $user->role = $request->role;

        if($request->password){
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect('/users')->with('success','User diupdate');
    });

    Route::get('/users/delete/{id}', function ($id) {
        if(auth()->user()->role != 'admin') abort(403);

        if($id == auth()->id()){
            return back()->with('error','Tidak bisa hapus diri sendiri');
        }

        User::findOrFail($id)->delete();

        return redirect('/users')->with('success','User dihapus');
    });
    
    // Tamplate
    Route::get('/templates', function () {
    $templates = EmailTemplate::all();
    return view('templates', compact('templates'));
});

Route::get('/templates/edit/{id}', function ($id) {
    $template = EmailTemplate::findOrFail($id);
    return view('edit-template', compact('template'));
});

Route::post('/templates/update/{id}', function (Request $request, $id) {
    $template = EmailTemplate::findOrFail($id);

    $template->name = $request->name;
    $template->subject = $request->subject;
    $template->body = $request->body;
    $template->wa_body = $request->wa_body;

    $template->save();

    return redirect('/templates')->with('success','Template berhasil diupdate');
});
// FORM TAMBAH
Route::get('/templates/create', function () {
    return view('create-template');
});

// SIMPAN DATA BARU
Route::post('/templates/store', function (Request $request) {

    $request->validate([
        'subject' => 'required',
        'body' => 'required'
    ]);

    EmailTemplate::create([
        'subject' => $request->subject,
        'body' => $request->body,
        'wa_body' => $request->wa_body,
    ]);

    return redirect('/templates')->with('success','Template berhasil ditambahkan');
});

// HAPUS
Route::get('/templates/delete/{id}', function ($id) {
    EmailTemplate::findOrFail($id)->delete();

    return redirect('/templates')->with('success','Template berhasil dihapus');
});

    // Preview
    Route::post('/preview-email', function (Request $request) {

    $template = EmailTemplate::find($request->template_id);

    $data = $request->all();

    $subject = $template->subject;
    $body = $template->body;
    $waBody = $template->wa_body ?? '';

    foreach($data as $key => $value){
        if(is_array($value)) continue;

        $subject = str_replace('{{'.$key.'}}', $value, $subject);
        $body = str_replace('{{'.$key.'}}', $value, $body);
        $waBody = str_replace('{{'.$key.'}}', $value, $waBody);
    }

    return view('preview-email', compact('subject','body','waBody'));
});
// LIST TEKNISI
Route::get('/technicians', function () {
    $technicians = \App\Models\Technician::all();
    return view('technicians', compact('technicians'));
});

// FORM TAMBAH
Route::get('/technicians/create', function () {
    return view('create-technician');
});

// SIMPAN
Route::post('/technicians/store', function (Request $request) {

    $request->validate([
        'name' => 'required',
        'phone' => 'required'
    ]);

    \App\Models\Technician::create([
        'name' => $request->name,
        'phone' => $request->phone
    ]);

    return redirect('/technicians')->with('success','Teknisi berhasil ditambahkan');
});

// HAPUS
Route::get('/technicians/delete/{id}', function ($id) {
    \App\Models\Technician::findOrFail($id)->delete();

    return redirect('/technicians')->with('success','Teknisi dihapus');
});
// FORM EDIT
Route::get('/technicians/edit/{id}', function ($id) {
    $technician = \App\Models\Technician::findOrFail($id);
    return view('edit-technician', compact('technician'));
});

// UPDATE DATA
Route::post('/technicians/update/{id}', function (Request $request, $id) {

    $request->validate([
        'name' => 'required',
        'phone' => 'required'
    ]);

    $technician = \App\Models\Technician::findOrFail($id);

    $technician->name = $request->name;
    $technician->phone = $request->phone;
    $technician->save();

    return redirect('/technicians')->with('success','Teknisi berhasil diupdate');
});

    // pic
// LIST
Route::get('/pics', function () {
    $pics = Pic::all();
    return view('pics', compact('pics'));
});

// FORM TAMBAH
Route::get('/pics/create', function () {
    return view('create-pic');
});

// SIMPAN
Route::post('/pics/store', function (Request $request) {

    $request->validate([
        'name' => 'required'
    ]);

    Pic::create([
        'name' => $request->name
    ]);

    return redirect('/pics')->with('success','PIC ditambahkan');
});

// EDIT
Route::get('/pics/edit/{id}', function ($id) {
    $pic = Pic::findOrFail($id);
    return view('edit-pic', compact('pic'));
});

// UPDATE
Route::post('/pics/update/{id}', function (Request $request, $id) {

    $pic = Pic::findOrFail($id);

    $pic->name = $request->name;
    $pic->save();

    return redirect('/pics')->with('success','PIC diupdate');
});

// HAPUS
Route::get('/pics/delete/{id}', function ($id) {
    Pic::findOrFail($id)->delete();

    return redirect('/pics')->with('success','PIC dihapus');
});

    /*
    =====================
    ✅ BARU: BACKUP HISTORY (hasil backup:export-daily)
    =====================
    */
    Route::get('/backup-history', function () {

        $baseDir = 'backups';

        $folders = collect(Storage::disk('local')->directories($baseDir))
            ->sortDesc()
            ->values()
            ->map(function ($folder) {
                $date = basename($folder);

                $files = collect(Storage::disk('local')->files($folder))
                    ->sortDesc()
                    ->map(function ($f) {
                        return [
                            'name' => basename($f),
                            'size' => Storage::disk('local')->size($f),
                            'path' => $f,
                        ];
                    })
                    ->values();

                return ['date' => $date, 'files' => $files];
            });

        return view('backup-history', compact('folders'));
    });

    Route::get('/backup-history/download', function (Request $request) {

        $path = $request->query('path');

        // ✅ VALIDASI KEAMANAN: path WAJIB di dalam folder backups/ saja,
        // supaya tidak bisa dipakai untuk mengunduh file lain di server.
        if (!$path || !str_starts_with($path, 'backups/') || str_contains($path, '..')) {
            abort(403);
        }

        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return Storage::disk('local')->download($path);
    });
});