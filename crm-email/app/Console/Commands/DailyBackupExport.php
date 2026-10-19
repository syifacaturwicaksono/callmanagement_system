<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

/**
 * ✅ BARU: Backup otomatis harian ke file Excel (CSV) — project cm_crm.
 *
 * Meng-export 2 tabel: email_logs, wa_logs
 * (project ini tidak punya tabel pending_case/close_case/upload_batches
 * seperti project HPS CRM, jadi cukup 2 tabel ini saja).
 *
 * Kolom diambil OTOMATIS dari struktur tabel (Schema::getColumnListing),
 * jadi tetap ikut lengkap walau kolomnya nanti berubah/bertambah.
 *
 * Cara jalanin manual (tes): php artisan backup:export-daily
 * Otomatis tiap hari: didaftarkan di app/Console/Kernel.php.
 */
class DailyBackupExport extends Command
{
    protected $signature = 'backup:export-daily';

    protected $description = 'Export harian email_logs & wa_logs ke file Excel (CSV) untuk backup otomatis';

    /**
     * Backup lebih lama dari sekian hari otomatis dihapus supaya disk
     * server tidak penuh. Ubah angka ini kalau mau retensi lebih lama/pendek.
     */
    protected $retentionDays = 30;

    protected $tables = ['email_logs', 'wa_logs'];

    public function handle()
    {
        $now = Carbon::now();
        $dateFolder = $now->format('Y-m-d');
        $timeSuffix = $now->format('His');

        $this->info("Mulai backup harian ({$dateFolder})...");

        foreach ($this->tables as $table) {
            $this->exportTable($table, $dateFolder, $timeSuffix);
        }

        $this->cleanupOldBackups();

        $this->info('Backup harian selesai.');
    }

    protected function exportTable($table, $dateFolder, $timeSuffix)
    {
        if (!Schema::hasTable($table)) {
            $this->warn("⚠ Tabel `{$table}` tidak ditemukan, dilewati.");
            return;
        }

        $columns = Schema::getColumnListing($table);
        $folder = "backups/{$dateFolder}";
        $fileName = "{$table}-{$dateFolder}_{$timeSuffix}.csv";
        $path = "{$folder}/{$fileName}";

        $handle = fopen('php://temp', 'w+');

        // ✅ BOM UTF-8 supaya Excel baca karakter dengan benar
        fwrite($handle, "\xEF\xBB\xBF");
        fputcsv($handle, $columns);

        // ✅ CHUNK supaya aman untuk tabel besar tanpa menghabiskan memory server.
        DB::table($table)->orderBy('id')->chunk(500, function ($rows) use ($handle, $columns) {
            foreach ($rows as $row) {
                $rowArr = (array) $row;
                $line = [];
                foreach ($columns as $col) {
                    $line[] = $this->sanitizeForCsv($rowArr[$col] ?? '');
                }
                fputcsv($handle, $line);
            }
        });

        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        Storage::disk('local')->put($path, $csvContent);

        $rowCount = DB::table($table)->count();
        $this->info("  ✓ {$table} ({$rowCount} baris) → storage/app/{$path}");
    }

    /**
     * ✅ Bersihkan baris baru (enter) dalam isi kolom, ganti jadi spasi.
     * Kalau ada baris baru dibiarkan mentah, saat file .csv dibuka langsung
     * (double-click) di Excel, 1 baris data database bisa "pecah" jadi
     * beberapa baris terpisah dan kolomnya jadi geser/berantakan.
     * Dengan ini, 1 baris database SELALU jadi 1 baris Excel.
     */
    protected function sanitizeForCsv($value)
    {
        if ($value === null) {
            return '';
        }

        $value = str_replace(["\r\n", "\r", "\n"], ' ', (string) $value);

        return trim(preg_replace('/\s+/', ' ', $value));
    }

    /**
     * Hapus folder backup yang lebih tua dari $retentionDays hari.
     */
    protected function cleanupOldBackups()
    {
        $cutoff = Carbon::now()->subDays($this->retentionDays);

        $folders = Storage::disk('local')->directories('backups');

        foreach ($folders as $folder) {
            $folderDate = basename($folder);

            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $folderDate)) {
                continue;
            }

            if (Carbon::parse($folderDate)->lt($cutoff)) {
                Storage::disk('local')->deleteDirectory($folder);
                $this->info("  🗑 Backup lama dihapus: {$folder}");
            }
        }
    }
}
