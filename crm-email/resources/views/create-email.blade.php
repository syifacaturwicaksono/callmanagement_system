@extends('layouts.admin')

@section('content')

<h2 class="mb-4">Create Message To Customer</h2>
<div class="card shadow-sm border-0">
    <div class="card-body">

        <form method="POST" action="/send-email" enctype="multipart/form-data" autocomplete="off">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Jenis Pesan</label>
                <select autocomplete="off" name="template_id" class="form-select" required>
                    <option value="">-- Pilih jenis pesan --</option>
                    @foreach($templates as $template)
                    <option value="{{ $template->id }}">
                        {{ $template->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Nama PIC</label>
                <select autocomplete="off" name="pic" class="form-control" required>
    <option value="">-- Pilih PIC --</option>
    @foreach($pics as $p)
        <option value="{{ $p->name }}">
            {{ $p->name }}
        </option>
    @endforeach
</select>
            </div>
            <div class="mb-3">
                <label class="form-label">Customer Email</label>
                <input autocomplete="off" type="email" name="customer_email" class="form-control" required>
            </div>

            <div id="dynamicFields"></div>

            
            <div class="mb-3">
            <label>Lampiran (Attachment)</label>
            <input autocomplete="off" type="file" name="attachment" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Kirim Melalui</label><br>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox"
                        name="channels[]" value="email" id="emailCheck">
                    <label class="form-check-label" for="emailCheck">
                        Email
                    </label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox"
                        name="channels[]" value="wa" id="waCheck">
                    <label class="form-check-label" for="waCheck">
                        WhatsApp
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                Send Email
            </button>
            <button type="submit" formaction="/preview-email" formtarget="_blank" class="btn btn-info">
                    Preview
            </button>

        </form>
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                const templateSelect = document.querySelector("select[name='template_id']");
                const dynamicFields = document.getElementById("dynamicFields");

                templateSelect.addEventListener("change", function() {

                    const selectedText = templateSelect.options[templateSelect.selectedIndex].text;

                    let html = "";

                    if (selectedText === "[2001] Recovery Windows") {
                        html = `         
        <div class="mb-3">
            <label>Customer Name</label>
            <input autocomplete="off" type="text" name="customer_name" class="form-control" required>
        </div>
        <div class="mb-3">
                    <label>Nomor Whastapp</label>
                    <input autocomplete="off" type="text" name="customer_phone" class="form-control" required>
                </div>
          
        <div class="mb-3">
                    <label>Case ID</label>
                    <input autocomplete="off" type="text" name="workorder" class="form-control" required>
                </div>
        
        <div class="mb-3">
            <label>Unit</label>
            <input autocomplete="off" type="text" name="unit" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Problem</label>
            <input autocomplete="off" type="text" name="problem" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Public Holiday</label>
            <textarea type="text" name="libur" class="form-control"></textarea>
        </div>

        
    `;
                    }

                if (selectedText === "[2002] Harga Tidak Ekonomis") {
                        html = `
                <div class="mb-3">
                    <label>Customer Name</label>
                    <input autocomplete="off" type="text" name="customer_name" class="form-control" required>
                </div>
                 
                <div class="mb-3">
                    <label>Nomor Whastapp</label>
                    <input autocomplete="off" type="text" name="customer_phone" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Case ID</label>
                    <input autocomplete="off" type="text" name="workorder" class="form-control" required>
                </div>
                    <div class="mb-3">
                    <label>Unit</label>
                    <input autocomplete="off" type="text" name="unit" class="form-control" required>
                    </div>
                <div class="mb-3">
                    <label>Deskripsi Kendala</label>
                    <input autocomplete="off" type="text" name="problem" class="form-control" required>
                </div>
                 <div class="mb-3">
                    <label>Part yang dibutuhkan</label>
                    <textarea name="need_part" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                <label>Public Holiday</label>
                <textarea type="text" name="libur" class="form-control"></textarea>
                </div>
            `;
                    }

                    
                if (selectedText === "[2003] Penawaran 1 Part Dan Baru Cek Lainnya") {
                        html = `
        <div class="mb-3">
            <label>Customer Name</label>
            <input autocomplete="off" type="text" name="customer_name" class="form-control" required>
        </div>
          
        <div class="mb-3">
                    <label>Nomor Whastapp</label>
                    <input autocomplete="off" type="text" name="customer_phone" class="form-control" required>
                </div>
        <div class="mb-3">
                    <label>Case ID</label>
                    <input autocomplete="off" type="text" name="workorder" class="form-control" required>
                </div>
                 <div class="mb-3">
                    <label>Unit</label>
                    <input autocomplete="off" type="text" name="unit" class="form-control" required>
                    </div>
                <div class="mb-3">
                    <label>Penjelasan unit</label>
                    <textarea name="problem" class="form-control" required></textarea>
                </div>
                 <div class="mb-3">
                    <label>Part yang dibutuhkan</label>
                    <textarea name="need_part" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label>Harga</label>
                    <input autocomplete="off" type="text" name="harga" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Ketersediaan Part</label>
                    <select type="text" name="eta" class="form-control" required>
                    <option value="">-- Pilih ETA --</option>
                    <option>part ready ditempat kami</option>
                    <option>part indent,estimasi waktu 2-4 hari kerja</option>
                    <option>part indent, estimasi waktu 7-14 hari kerja</option>
                    <option>part indent,estimasi waktu 5-10 mingguan</option>
                    </select>
                </div>
                <div class="mb-3">
                <label>Public Holiday</label>
                <textarea type="text" name="libur" class="form-control"></textarea>
                </div>

    `;
                    }

                    if (selectedText === "[2004] Penawaran Lebih 1 Part") {
                        html = `
        <div class="mb-3">
            <label>Customer Name</label>
            <input autocomplete="off" type="text" name="customer_name" class="form-control" required>
        </div>
          
        <div class="mb-3">
                    <label>Nomor Whastapp</label>
                    <input autocomplete="off" type="text" name="customer_phone" class="form-control" required>
                </div>
         <div class="mb-3">
                    <label>Case ID</label>
                    <input autocomplete="off" type="text" name="workorder" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Unit</label>
                    <input autocomplete="off" type="text" name="unit" class="form-control" required>
                    </div>
                    <div class="mb-3">
                    <label>Part yang bermasalah</label>
                    <textarea name="isi_masalah" class="form-control" required></textarea>
                </div>
        <div class="mb-3">
                    <label>Part yang dibutuhkan</label>
                    <textarea name="isi_part" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label>Harga</label>
                    <input autocomplete="off" type="text" name="total_harga" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>ETA</label>
                    <input autocomplete="off" type="text" name="eta" class="form-control" required>
                </div>
                <div class="mb-3">
                <label>Public Holiday</label>
                <textarea type="text" name="libur" class="form-control"></textarea>
                </div>
    `;
                    }
                    if (selectedText === "Confirm Visit Schedule - Konfirmasi Jadwal Kunjungan") {
                        html = `
        <div class="mb-3">
            <label>Customer Name</label>
            <input autocomplete="off" type="text" name="customer_name" class="form-control" required>
        </div>
          
        <div class="mb-3">
                    <label>Nomor Whastapp</label>
                    <input autocomplete="off" type="text" name="customer_phone" class="form-control" required>
                </div> 
        <div class="mb-3">
                    <label>Case ID</label>
                    <input autocomplete="off" type="text" name="workorder" class="form-control" required>
                </div> 
        <div class="mb-3">
            <label>Nama Teknisi</label>
            <select autocomplete="off" name="engineer_name" class="form-control" required>
                <option value="">-- Pilih Teknisi --</option>
                <option value="Farhan">Farhan</option>
                <option value="Bayu">Bayu</option>
                <option value="Agung">Agung</option>
                <option value="Catur">Catur</option>
                <option value="Purwanto">Purwanto</option>
                <option value="Yogi">Yogi</option>
             </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Janji Temu</label>
            <input autocomplete="off" type="date" name="appointment_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Waktu Janji Temu</label>
            <input autocomplete="off" type="time" name="appointment_time" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Public Holiday</label>
            <textarea type="text" name="libur" class="form-control"></textarea>
        </div>

         
    `;
                    }
         if (selectedText === "[2005] Penawaran Repair Mainboard") {
                        html = `         
        <div class="mb-3">
            <label>Customer Name</label>
            <input autocomplete="off" type="text" name="customer_name" class="form-control" required>
        </div>
        <div class="mb-3">
                    <label>Nomor Whastapp</label>
                    <input autocomplete="off" type="text" name="customer_phone" class="form-control" required>
                </div>
          
        <div class="mb-3">
                    <label>Case ID</label>
                    <input autocomplete="off" type="text" name="workorder" class="form-control" required>
                </div>

        <div class="mb-3">
            <label>Unit</label>
            <input autocomplete="off" type="text" name="unit" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Kendala</label>
            <textarea type="text" name="problem" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Biaya</label>
            <input autocomplete="off" type="text" name="biaya" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>ETA</label>
            <input autocomplete="off" type="text" name="eta" class="form-control" required placeholder=2-4>
        </div>
        <div class="mb-3">
            <label>Public Holiday</label>
            <textarea type="text" name="libur" class="form-control"></textarea>
        </div>

        
    `;
}
            if (selectedText === "[2006] Pengiriman Quotation") {
                        html = `         
        <div class="mb-3">
            <label>Customer Name</label>
            <input autocomplete="off" type="text" name="customer_name" class="form-control" required>
        </div>
        <div class="mb-3">
                    <label>Nomor Whastapp</label>
                    <input autocomplete="off" type="text" name="customer_phone" class="form-control" required>
                </div>
          
        <div class="mb-3">
                    <label>Case ID</label>
                    <input autocomplete="off" type="text" name="workorder" class="form-control" required>
                </div>

        <div class="mb-3">
            <label>Unit</label>
            <input autocomplete="off" type="text" name="unit" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Problem</label>
            <input autocomplete="off" type="text" name="problem" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Part Yang Diganti</label>
            <input autocomplete="off" type="text" name="part" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input autocomplete="off" type="text" name="harga" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Informasi Tambahan</label>
            <textarea type="text" name="tambahan" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Public Holiday</label>
            <textarea type="text" name="libur" class="form-control"></textarea>
        </div>

        
    `;
                    }
            if (selectedText === "[2007] Follow Up Quotation") {
                        html = `         
        <div class="mb-3">
            <label>Customer Name</label>
            <input autocomplete="off" type="text" name="customer_name" class="form-control" required>
        </div>
        <div class="mb-3">
                    <label>Nomor Whastapp</label>
                    <input autocomplete="off" type="text" name="customer_phone" class="form-control" required>
                </div>
        
        <div class="mb-3">
        <label>Case ID</label>
        <input autocomplete="off" type="text" name="workorder" class="form-control" required>
        </div>

        <div class="mb-3">
        <label>Unit</label>
        <input autocomplete="off" type="text" name="unit" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Public Holiday</label>
            <textarea type="text" name="libur" class="form-control"></textarea>
        </div>


    `;
    
                    }
                     if (selectedText === "[2008] Info Pengambilan Service") {
                        html = `         
        <div class="mb-3">
            <label>Customer Name</label>
            <input autocomplete="off" type="text" name="customer_name" class="form-control" required>
        </div>
        <div class="mb-3">
                    <label>Nomor Whastapp</label>
                    <input autocomplete="off" type="text" name="customer_phone" class="form-control" required>
                </div>
        
        <div class="mb-3">
        <label>Case ID</label>
        <input autocomplete="off" type="text" name="workorder" class="form-control" required>
        </div>

        <div class="mb-3">
        <label>Unit</label>
        <input autocomplete="off" type="text" name="unit" class="form-control" required>
        </div>
         <div class="mb-3">
        <label>Progress</label>
        <input autocomplete="off" type="text" name="progress" class="form-control" required>
        </div>
         <div class="mb-3">
        <label>Harga</label>
        <input autocomplete="off" type="text" name="harga" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Public Holiday</label>
            <textarea type="text" name="libur" class="form-control"></textarea>
        </div>


    `;
    
                    }
                    if (selectedText === "[2009] Info Pengambilan sudah DP") {
                        html = `         
        <div class="mb-3">
            <label>Customer Name</label>
            <input autocomplete="off" type="text" name="customer_name" class="form-control" required>
        </div>
        <div class="mb-3">
                    <label>Nomor Whastapp</label>
                    <input autocomplete="off" type="text" name="customer_phone" class="form-control" required>
                </div>
          
        <div class="mb-3">
                    <label>Case ID</label>
                    <input autocomplete="off" type="text" name="workorder" class="form-control" required>
                </div>

        <div class="mb-3">
            <label>Unit</label>
            <input autocomplete="off" type="text" name="unit" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Harga Part</label>
            <input autocomplete="off" type="text" name="harga_part" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Harga DP</label>
            <input autocomplete="off" type="text" name="harga_dp" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nominal Kurang</label>
            <input autocomplete="off" type="text" name="nominal_kurang" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Public Holiday</label>
            <textarea type="text" name="libur" class="form-control"></textarea>
        </div>

        
    `;
                    }
                     if (selectedText === "[2010] Info Failed Repair mb") {
                        html = `         
        <div class="mb-3">
            <label>Customer Name</label>
            <input autocomplete="off" type="text" name="customer_name" class="form-control" required>
        </div>
        <div class="mb-3">
                    <label>Nomor Whastapp</label>
                    <input autocomplete="off" type="text" name="customer_phone" class="form-control" required>
                </div>
          
        <div class="mb-3">
                    <label>Case ID</label>
                    <input autocomplete="off" type="text" name="workorder" class="form-control" required>
                </div>

        <div class="mb-3">
            <label>Unit</label>
            <input autocomplete="off" type="text" name="unit" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Sisa DP</label>
            <input autocomplete="off" type="text" name="sisa_dp" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Public Holiday</label>
            <textarea type="text" name="libur" class="form-control"></textarea>
        </div>

        
    `;
                    }

                    if (selectedText === "[2011] Part Order") {
                        html = `         
        <div class="mb-3">
            <label>Customer Name</label>
            <input autocomplete="off" type="text" name="customer_name" class="form-control" required>
        </div>
        <div class="mb-3">
                    <label>Nomor Whastapp</label>
                    <input autocomplete="off" type="text" name="customer_phone" class="form-control" required>
                </div>
          
        <div class="mb-3">
                    <label>Case ID</label>
                    <input autocomplete="off" type="text" name="workorder" class="form-control" required>
                </div>
        <div class="mb-3">
            <label>Public Holiday</label>
            <textarea type="text" name="libur" class="form-control"></textarea>
        </div>

        
    `;
                    }

                    if (selectedText === "[2012] Analisa") {
                        html = `         
        <div class="mb-3">
            <label>Customer Name</label>
            <input autocomplete="off" type="text" name="customer_name" class="form-control" required>
        </div>
        <div class="mb-3">
                    <label>Nomor Whastapp</label>
                    <input autocomplete="off" type="text" name="customer_phone" class="form-control" required>
                </div>
          
        <div class="mb-3">
                    <label>Case ID</label>
                    <input autocomplete="off" type="text" name="workorder" class="form-control" required>
                </div>
        <div class="mb-3">
            <label>Public Holiday</label>
            <textarea type="text" name="libur" class="form-control"></textarea>
        </div>

        
    `;
                    }

                    if (selectedText === "[2013] Stock Kosong") {
                        html = `         
        <div class="mb-3">
            <label>Customer Name</label>
            <input autocomplete="off" type="text" name="customer_name" class="form-control" required>
        </div>
        <div class="mb-3">
                    <label>Nomor Whastapp</label>
                    <input autocomplete="off" type="text" name="customer_phone" class="form-control" required>
                </div>
          
        <div class="mb-3">
                    <label>Case ID</label>
                    <input autocomplete="off" type="text" name="workorder" class="form-control" required>
                </div>
        <div class="mb-3">
            <label>Sparepart yang Kosong</label>
            <input autocomplete="off" type="text" name="part" class="form-control" required placeholder="topcover">
        </div>
        <div class="mb-3">
            <label>Public Holiday</label>
            <textarea type="text" name="libur" class="form-control"></textarea>
        </div>

        
    `;
                    }

                    if (selectedText === "[2014] Quotation Part Ready Stock") {
                        html = `         
        <div class="mb-3">
            <label>Customer Name</label>
            <input autocomplete="off" type="text" name="customer_name" class="form-control" required>
        </div>
        <div class="mb-3">
                    <label>Nomor Whastapp</label>
                    <input autocomplete="off" type="text" name="customer_phone" class="form-control" required>
                </div>
          
        <div class="mb-3">
                    <label>Case ID</label>
                    <input autocomplete="off" type="text" name="workorder" class="form-control" required>
                </div>
        <div class="mb-3">
            <label>Unit</label>
            <input autocomplete="off" type="text" name="unit" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Kendala Unit</label>
            <textarea name="problem" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Part yang Diganti</label>
            <input autocomplete="off" type="text" name="part" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Total Harga</label>
            <input autocomplete="off" type="text" name="total_harga" class="form-control" required placeholder="620.000">
        </div>
        <div class="mb-3">
            <label>Public Holiday</label>
            <textarea type="text" name="libur" class="form-control"></textarea>
        </div>

        
    `;
                    }

                    if (selectedText === "[2015] Reminder Pengambilan") {
                        html = `         
        <div class="mb-3">
            <label>Customer Name</label>
            <input autocomplete="off" type="text" name="customer_name" class="form-control" required>
        </div>
        <div class="mb-3">
                    <label>Nomor Whastapp</label>
                    <input autocomplete="off" type="text" name="customer_phone" class="form-control" required>
                </div>
          
        <div class="mb-3">
                    <label>Case ID</label>
                    <input autocomplete="off" type="text" name="workorder" class="form-control" required>
                </div>
        <div class="mb-3">
            <label>Unit</label>
            <input autocomplete="off" type="text" name="unit" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Public Holiday</label>
            <textarea type="text" name="libur" class="form-control"></textarea>
        </div>

        
    `;}
    if (selectedText === "[2016] Part Ready") {
                        html = `         
        <div class="mb-3">
            <label>Customer Name</label>
            <input autocomplete="off" type="text" name="customer_name" class="form-control" required>
        </div>
        <div class="mb-3">
                    <label>Nomor Whastapp</label>
                    <input autocomplete="off" type="text" name="customer_phone" class="form-control" required>
                </div>
          
        <div class="mb-3">
                    <label>Case ID</label>
                    <input autocomplete="off" type="text" name="workorder" class="form-control" required>
                </div>
        <div class="mb-3">
            <label>Part</label>
            <input autocomplete="off" type="text" name="part" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Public Holiday</label>
            <textarea type="text" name="libur" class="form-control"></textarea>
        </div>

        
    `;}
                    


                    dynamicFields.innerHTML = html;
                });

            });
        </script>

    </div>
    
</div>

@endsection