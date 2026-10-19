@extends('layouts.admin')

@section('content')

@php
    // ganti nama di sini kalau perlu
    $namaUser = 'Maulida';
@endphp

<style>
    .welcome-banner {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 14px 22px;
        margin-bottom: 16px;
        border-radius: 14px;
        color: #fff;
        background: linear-gradient(135deg, #0b1f6b 0%, #1237b8 55%, #1e5bff 100%);
        background-size: 160% 160%;
        box-shadow: 0 8px 20px rgba(18, 55, 184, .22);
        animation: wbShift 12s ease-in-out infinite alternate, wbIn .7s cubic-bezier(.22,.8,.24,1) both;
    }

    @keyframes wbShift { from { background-position: 0 0; } to { background-position: 100% 100%; } }
    @keyframes wbIn { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }

    /* lingkaran cahaya yang melayang */
    .welcome-banner::before,
    .welcome-banner::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        background: rgba(255, 255, 255, .12);
        filter: blur(2px);
    }

    .welcome-banner::before {
        width: 130px; height: 130px;
        right: -30px; top: -60px;
        animation: wbFloat 9s ease-in-out infinite alternate;
    }

    .welcome-banner::after {
        width: 80px; height: 80px;
        right: 130px; bottom: -45px;
        background: rgba(0, 150, 214, .35);
        animation: wbFloat 11s ease-in-out infinite alternate-reverse;
    }

    @keyframes wbFloat { to { transform: translate(-24px, 18px) scale(1.12); } }

    .wb-text,
    .wb-clock { position: relative; z-index: 1; }

    .wb-title {
        margin: 0 0 2px;
        font-size: 19px;
        font-weight: 800;
        letter-spacing: -.4px;
    }

    .wb-sub {
        margin: 0;
        min-height: 18px;
        font-size: 13px;
        color: rgba(255, 255, 255, .85);
    }

    /* teks bergantian: keluar ke atas, masuk dari bawah */
    .wb-swap {
        display: inline-block;
        transition: opacity .45s ease, transform .45s ease;
    }

    .wb-swap.out {
        opacity: 0;
        transform: translateY(-8px);
    }

    .wb-clock { text-align: right; flex-shrink: 0; }

    .wb-clock strong {
        display: block;
        font-size: 21px;
        font-weight: 700;
        letter-spacing: .5px;
        font-variant-numeric: tabular-nums;
    }

    .wb-clock span {
        font-size: 12px;
        color: rgba(255, 255, 255, .8);
    }

    /* ===== game kucing + indikator jaringan ===== */
    .wb-game {
        position: relative;
        z-index: 1;
        display: block;
        flex: 1 1 auto;
        min-width: 0;
        max-width: 560px;
        width: 100%;
        height: 48px;
        border-radius: 10px;
        background: rgba(255, 255, 255, .08);
        border: 1px solid rgba(255, 255, 255, .14);
        cursor: pointer;
        touch-action: manipulation;
        user-select: none;
        -webkit-tap-highlight-color: transparent;
    }

    .wb-game:hover { background: rgba(255, 255, 255, .12); }
    .wb-game:focus-visible { outline: 2px solid #fff; outline-offset: 2px; }

    .wb-right {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 16px;
        flex-shrink: 0;
    }

    .wb-net {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        padding-right: 16px;
        border-right: 1px solid rgba(255, 255, 255, .2);
    }

    .wb-net strong {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 15px;
        line-height: 1.25;
        font-variant-numeric: tabular-nums;
    }

    .wb-net span {
        font-size: 11px;
        color: rgba(255, 255, 255, .75);
    }

    .wb-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #94a3b8;
        transition: background .3s ease;
    }

    .wb-dot.good { background: #34d399; }
    .wb-dot.mid  { background: #fbbf24; }
    .wb-dot.bad  { background: #f87171; }

    @media (max-width: 768px) {
        .wb-game { display: none; }
    }

    @media (max-width: 576px) {
        .welcome-banner { flex-direction: column; align-items: flex-start; padding: 14px 18px; gap: 6px; }
        .wb-clock { text-align: left; }
        .wb-net { align-items: flex-start; padding-right: 12px; }
        .wb-right { gap: 12px; }
        .wb-title { font-size: 18px; }
    }

    @media (prefers-reduced-motion: reduce) {
        .welcome-banner,
        .welcome-banner::before,
        .welcome-banner::after { animation: none !important; }
        .wb-swap { transition: none; }
    }
</style>

<div class="welcome-banner">
    <div class="wb-text">
        <h2 class="wb-title"><span class="wb-swap" id="wbTitle">Selamat datang, {{ $namaUser }}</span></h2>
        <p class="wb-sub"><span class="wb-swap" id="wbSub">Semoga harimu menyenangkan.</span></p>
    </div>
    <canvas class="wb-game" id="wbGame" tabindex="0" role="button"
            aria-label="Permainan kucing melompat. Klik atau tekan spasi untuk melompat"></canvas>

    <div class="wb-right">
        <div class="wb-net" title="Ping ke server dan perkiraan kecepatan jaringan">
            <strong><i class="wb-dot" id="wbNetDot"></i><b id="wbPing" style="font-weight:700">-- ms</b></strong>
            <span id="wbNetSub">Mengukur...</span>
        </div>
        <div class="wb-clock">
            <strong id="wbTime">--:--</strong>
            <span id="wbDate"></span>
        </div>
    </div>
</div>

<script>
    (function () {
        var nama = @json($namaUser);

        var hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        var bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        var titleEl = document.getElementById('wbTitle');
        var subEl = document.getElementById('wbSub');

        var subs = [
            'Semoga harimu menyenangkan.',
            'Pantau email yang sudah terkirim di sini.',
            'Pastikan setiap case ter-follow up dengan baik.',
            'Gunakan filter tanggal untuk melihat data per periode.',
            'Export Excel tersedia kapan pun kamu butuh laporan.'
        ];

        function pad(n) { return String(n).padStart(2, '0'); }

        function waktu() {
            var h = new Date().getHours();
            return h >= 4 && h < 11 ? 'pagi'
                : h >= 11 && h < 15 ? 'siang'
                : h >= 15 && h < 18 ? 'sore'
                : 'malam';
        }

        function titles() {
            return [
                'Selamat datang, ' + nama,
                'Selamat ' + waktu() + ', ' + nama
            ];
        }

        function updateClock() {
            var d = new Date();
            document.getElementById('wbTime').textContent = pad(d.getHours()) + ':' + pad(d.getMinutes());
            document.getElementById('wbDate').textContent =
                hari[d.getDay()] + ', ' + d.getDate() + ' ' + bulan[d.getMonth()] + ' ' + d.getFullYear();
        }

        updateClock();
        setInterval(updateClock, 15000);

        // ganti teks dengan efek keluar-masuk
        function swap(el, text) {
            el.classList.add('out');
            setTimeout(function () {
                el.textContent = text;
                el.classList.remove('out');
            }, 450);
        }

        var iTitle = 0, iSub = 0;

        // mulai dengan sapaan sesuai jam, lalu bergantian
        titleEl.textContent = titles()[1];
        iTitle = 1;

        setInterval(function () {
            iTitle = (iTitle + 1) % 2;
            swap(titleEl, titles()[iTitle]);
        }, 5000);

        setInterval(function () {
            iSub = (iSub + 1) % subs.length;
            swap(subEl, subs[iSub]);
        }, 5000);
    })();
</script>

<script>
    // ===== indikator jaringan =====
    (function () {
        // Isi dengan '/speedtest' kalau route uji kecepatan sudah dibuat (lihat catatan).
        var SPEED_URL = null;

        var pingEl = document.getElementById('wbPing');
        var dotEl = document.getElementById('wbNetDot');
        var subEl = document.getElementById('wbNetSub');
        var samples = [];
        var mbps = null;

        function offline() {
            samples = [];
            pingEl.textContent = 'Offline';
            dotEl.className = 'wb-dot bad';
            subEl.textContent = 'Tidak terhubung';
        }

        function show() {
            if (!samples.length) return;
            var sum = 0;
            samples.forEach(function (v) { sum += v; });
            var avg = Math.round(sum / samples.length);

            pingEl.textContent = avg + ' ms';
            dotEl.className = 'wb-dot ' + (avg < 60 ? 'good' : avg < 150 ? 'mid' : 'bad');

            var conn = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
            if (mbps !== null) {
                subEl.textContent = '\u2193 ' + (mbps < 10 ? mbps.toFixed(1) : Math.round(mbps)) + ' Mbps';
            } else if (conn && conn.downlink) {
                subEl.textContent = '\u2248 ' + conn.downlink + ' Mbps';
            } else {
                subEl.textContent = 'Ping server';
            }
        }

        function pingOnce() {
            if (document.hidden) return;
            if (!navigator.onLine) { offline(); return; }

            var t0 = performance.now();
            fetch('/favicon.ico?_=' + Date.now(), { cache: 'no-store' })
                .then(function () {
                    samples.push(Math.max(1, Math.round(performance.now() - t0)));
                    if (samples.length > 3) samples.shift();
                    show();
                })
                .catch(offline);
        }

        function speedOnce() {
            if (!SPEED_URL || document.hidden || !navigator.onLine) return;

            var t0 = performance.now();
            fetch(SPEED_URL + '?_=' + Date.now(), { cache: 'no-store' })
                .then(function (r) { return r.arrayBuffer(); })
                .then(function (buf) {
                    var sec = (performance.now() - t0) / 1000;
                    mbps = (buf.byteLength * 8) / sec / 1e6;
                    show();
                })
                .catch(function () {});
        }

        pingOnce();
        setInterval(pingOnce, 4000);
        setTimeout(speedOnce, 1500);
        setInterval(speedOnce, 30000);

        window.addEventListener('online', pingOnce);
        window.addEventListener('offline', offline);
    })();

    // ===== game kucing melompat =====
    (function () {
        var cv = document.getElementById('wbGame');
        if (!cv) return;
        var c = cv.getContext('2d');

        var W = 0, H = 0, G = 0;
        var state = 'idle';          // idle | run | over
        var cat, obstacles, speed, dist, spawnIn, runT, last, raf;
        var hi = 0;

        try { hi = parseInt(localStorage.getItem('cmCatHi'), 10) || 0; } catch (e) {}

        var JUMP_V = 225, GRAVITY = 1100;

        function reset() {
            cat = { x: 34, y: 0, vy: 0 };
            obstacles = [];
            speed = 230;
            dist = 0;
            runT = 0;
            spawnIn = 260;
        }

        function size() {
            var r = cv.getBoundingClientRect();
            if (!r.width) return;
            var dpr = Math.min(window.devicePixelRatio || 1, 2);
            W = r.width;
            H = r.height;
            G = H - 6;
            cv.width = W * dpr;
            cv.height = H * dpr;
            c.setTransform(dpr, 0, 0, dpr, 0, 0);
            render();
        }

        function jump() {
            if (state === 'idle') { reset(); state = 'run'; start(); }
            else if (state === 'over') { reset(); state = 'run'; start(); }
            if (state === 'run' && cat.y === 0) cat.vy = JUMP_V;
        }

        function start() {
            last = performance.now();
            cancelAnimationFrame(raf);
            raf = requestAnimationFrame(tick);
        }

        function tick(now) {
            if (state !== 'run') return;
            var dt = Math.min(.033, (now - last) / 1000);
            last = now;
            update(dt);
            render();
            if (state === 'run') raf = requestAnimationFrame(tick);
        }

        function update(dt) {
            var score = dist / 12;
            speed = Math.min(400, 230 + score * 0.5);
            dist += speed * dt;
            runT += speed * dt;

            // fisika lompat
            cat.vy -= GRAVITY * dt;
            cat.y += cat.vy * dt;
            if (cat.y <= 0) { cat.y = 0; cat.vy = 0; }

            // rintangan (kardus)
            for (var i = obstacles.length - 1; i >= 0; i--) {
                obstacles[i].x -= speed * dt;
                if (obstacles[i].x < -40) obstacles.splice(i, 1);
            }

            spawnIn -= speed * dt;
            if (spawnIn <= 0) {
                var w = 12 + Math.floor(Math.random() * 5);
                var h = 10 + Math.floor(Math.random() * 4);
                var twin = Math.random() < .25;
                obstacles.push({ x: W + 10, w: twin ? w * 2 - 2 : w, h: h, twin: twin });
                spawnIn = Math.max(180, speed * (0.8 + Math.random() * 0.9));
            }

            // tabrakan (sedikit dilonggarkan agar adil)
            var cl = cat.x + 3, cr = cat.x + 19, ct = G - cat.y - 13, cb = G - cat.y;
            for (var k = 0; k < obstacles.length; k++) {
                var o = obstacles[k];
                if (cr > o.x + 2 && cl < o.x + o.w - 2 && cb > G - o.h + 2 && ct < G) {
                    gameOver();
                    return;
                }
            }
        }

        function gameOver() {
            state = 'over';
            var sc = Math.floor(dist / 12);
            if (sc > hi) {
                hi = sc;
                try { localStorage.setItem('cmCatHi', String(hi)); } catch (e) {}
            }
            render();
        }

        function pad5(n) { return String(n).padStart(5, '0'); }

        function drawCat() {
            var x = cat.x, y = G - cat.y;      // y = telapak kaki
            var step = cat.y > 0 ? 0 : (Math.floor(runT / 8) % 2);
            var tail = Math.sin(runT / 10) * 3;

            c.fillStyle = '#ffb454';

            // ekor
            c.strokeStyle = '#ffb454';
            c.lineWidth = 2.5;
            c.lineCap = 'round';
            c.beginPath();
            c.moveTo(x + 1, y - 9);
            c.quadraticCurveTo(x - 7, y - 10 + tail, x - 5, y - 16 + tail);
            c.stroke();

            // badan & kepala
            c.fillRect(x, y - 11, 15, 7);
            c.fillRect(x + 11, y - 15, 9, 8);

            // telinga
            c.beginPath();
            c.moveTo(x + 12, y - 15); c.lineTo(x + 14, y - 19); c.lineTo(x + 16, y - 15);
            c.moveTo(x + 16, y - 15); c.lineTo(x + 18, y - 19); c.lineTo(x + 20, y - 15);
            c.fill();

            // mata & hidung
            c.fillStyle = '#1b2a5a';
            c.fillRect(x + 16, y - 12, 2, 2);
            c.fillStyle = '#ff7a8a';
            c.fillRect(x + 19, y - 10, 2, 1.5);

            // kaki
            c.fillStyle = '#e89a3c';
            if (cat.y > 0) {
                c.fillRect(x - 1, y - 5, 5, 3);
                c.fillRect(x + 12, y - 5, 5, 3);
            } else {
                c.fillRect(x + 1, y - 5 + (step ? 0 : -1), 3, step ? 5 : 4);
                c.fillRect(x + 5, y - 5 + (step ? -1 : 0), 3, step ? 4 : 5);
                c.fillRect(x + 10, y - 5 + (step ? -1 : 0), 3, step ? 4 : 5);
                c.fillRect(x + 14, y - 5 + (step ? 0 : -1), 3, step ? 5 : 4);
            }
        }

        function drawBox(o) {
            var unit = o.twin ? (o.w + 2) / 2 : o.w;
            var count = o.twin ? 2 : 1;
            for (var i = 0; i < count; i++) {
                var bx = o.x + i * (unit - 2);
                c.fillStyle = '#e0b27a';
                c.fillRect(bx, G - o.h, unit, o.h);
                c.fillStyle = '#b98547';
                c.fillRect(bx + unit / 2 - 1, G - o.h, 2, o.h);
                c.fillRect(bx, G - o.h, unit, 2);
            }
        }

        function render() {
            if (!W) return;
            c.clearRect(0, 0, W, H);

            // tanah
            c.fillStyle = 'rgba(255,255,255,.55)';
            c.fillRect(0, G + 1, W, 1);
            c.fillStyle = 'rgba(255,255,255,.3)';
            var off = state === 'run' ? (dist % 40) : 0;
            for (var gx = -off; gx < W; gx += 40) {
                c.fillRect(gx + 8, G + 4, 6, 1);
                c.fillRect(gx + 27, G + 3, 3, 1);
            }

            if (!cat) reset();
            obstacles.forEach(drawBox);
            drawCat();

            c.fillStyle = 'rgba(255,255,255,.85)';
            c.font = '600 11px Inter, Segoe UI, Arial, sans-serif';
            c.textBaseline = 'top';
            c.textAlign = 'right';
            c.fillText('HI ' + pad5(hi) + '   ' + pad5(Math.floor(dist / 12)), W - 8, 6);

            c.textAlign = 'center';
            if (state === 'idle') c.fillText('Klik di sini untuk main', W / 2, 14);
            if (state === 'over') c.fillText('Game over \u00b7 klik untuk ulang', W / 2, 14);
        }

        cv.addEventListener('pointerdown', function (e) { e.preventDefault(); jump(); });
        cv.addEventListener('keydown', function (e) {
            if (e.code === 'Space' || e.code === 'ArrowUp') { e.preventDefault(); jump(); }
        });

        document.addEventListener('visibilitychange', function () {
            if (document.hidden && state === 'run') { state = 'over'; render(); }
        });

        reset();
        window.addEventListener('resize', size);
        size();
    })();
</script>


<h2 class="mb-4">CRM Message Dashboard</h2>

<div class="row">

<div class="card mb-4 shadow-sm border-0">
    <div class="card-body">

        <form method="GET" action="/dashboard" class="row g-3 align-items-end">

            <div class="col-md-4">
                <label class="form-label">From Date</label>
                <input type="date" name="from" class="form-control" value="{{ request('from') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">To Date</label>
                <input type="date" name="to" class="form-control" value="{{ request('to') }}">
            </div>

            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">
                    🔍 Filter
                </button>

                <a href="/dashboard" class="btn btn-secondary">
                    Reset
                </a>
                 <a href="{{ route('dashboard.export', request()->query()) }}"
                   class="btn btn-success">
                    Export Excel
                </a>
            </div>

        </form>

    </div>
</div>

<div class="col-md-6">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5>Total Email Terkirim</h5>
            <h2 class="fw-bold text-primary">
                {{ $totalEmails }}
            </h2>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5>Total Jenis Pesan</h5>
            <h2 class="fw-bold text-success">
                {{ $totalTemplates }}
            </h2>
        </div>
    </div>
</div>

</div>

<div class="card mt-4 shadow-sm border-0">
    <div class="card-body">
        <h5 class="mb-3">📨 Email Terakhir</h5>

        <table class="table table-striped table-sm align-middle">
            <thead>
                <tr>
                    <th>No</th>    
                    <th>Case ID</th>
                    <th>PIC</th>        
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Tanggal</th>
                    <th>Attachment</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentEmails as $email)
                    <tr>
                        <td>{{ $recentEmails->firstItem() + $loop->index }}</td>

                        <td>{{ $email->case_id }}</td>
                        <td>{{ $email->pic }}</td>
                        <td>{{ $email->customer_name }}</td>

                        {{-- ✅ EMAIL --}}
                        <td>{{ $email->customer_email }}</td>

                        <td>{{ $email->subject }}</td>
                        <td>{{ $email->created_at->format('d M Y H:i') }}</td>

                        {{-- ✅ ATTACHMENT --}}
                        <td>
                            @if($email->attachment)
                                <a href="{{ asset('storage/'.$email->attachment) }}" 
                                   class="btn btn-sm btn-success"
                                   target="_blank">
                                   📎 {{ basename($email->attachment) }}
                                </a>
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            Belum ada email terkirim
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- PAGINATION --}}
        <div class="mt-3">
            {{ $recentEmails->links() }}
        </div>

    </div>
</div>

@endsection