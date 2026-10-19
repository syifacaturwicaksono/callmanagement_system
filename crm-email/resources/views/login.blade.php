<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login - HP CRM Call Management</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    :root {
        --navy: #081633;
        --blue-1: #0b1f6b;
        --blue-2: #1e5bff;
        --cyan: #0096d6;
        --ink: #0f172a;
        --muted: #64748b;
        --ease: cubic-bezier(.22, .8, .24, 1);
    }

    html,
    body {
        margin: 0;
        min-height: 100%;
    }

    body {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, Arial, sans-serif;
        color: var(--ink);
        background: var(--navy);
        position: relative;
        overflow-x: hidden;
    }

    /* ===== LATAR: orb cahaya yang melayang pelan ===== */
    .bg {
        position: fixed;
        inset: 0;
        overflow: hidden;
        pointer-events: none;
    }

    .orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(90px);
        opacity: .55;
        will-change: transform;
    }

    .orb.o1 {
        width: 560px; height: 560px;
        left: -140px; top: -120px;
        background: #1e5bff;
        animation: float1 18s ease-in-out infinite alternate;
    }

    .orb.o2 {
        width: 480px; height: 480px;
        right: -120px; bottom: -140px;
        background: #0096d6;
        opacity: .42;
        animation: float2 22s ease-in-out infinite alternate;
    }

    .orb.o3 {
        width: 360px; height: 360px;
        left: 45%; top: 55%;
        background: #4338ca;
        opacity: .28;
        animation: float3 26s ease-in-out infinite alternate;
    }

    @keyframes float1 { to { transform: translate(140px, 90px) scale(1.15); } }
    @keyframes float2 { to { transform: translate(-130px, -80px) scale(1.2); } }
    @keyframes float3 { to { transform: translate(-160px, -120px) scale(.85); } }

    /* pola titik halus di latar */
    .bg::after {
        content: "";
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255, 255, 255, .08) 1px, transparent 1px);
        background-size: 22px 22px;
        animation: dotsDrift 40s linear infinite;
    }

    @keyframes dotsDrift { to { background-position: 22px 44px; } }

    /* ===== KARTU ===== */
    .login-shell {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 940px;
        min-height: 540px;
        display: grid;
        grid-template-columns: 1.05fr 1fr;
        border-radius: 24px;
        overflow: hidden;
        background: #fff;
        box-shadow:
            0 0 0 1px rgba(255, 255, 255, .06),
            0 40px 90px rgba(0, 0, 0, .55),
            0 0 120px rgba(30, 91, 255, .18);
        animation: cardIn .9s var(--ease) both;
    }

    @keyframes cardIn {
        from { opacity: 0; transform: translateY(28px) scale(.97); }
        to   { opacity: 1; transform: none; }
    }

    /* ===== PANEL KIRI ===== */
    .side {
        position: relative;
        padding: 48px 44px 36px;
        color: #fff;
        display: flex;
        flex-direction: column;
        background: linear-gradient(150deg, var(--blue-1) 0%, #1237b8 55%, var(--blue-2) 100%);
        background-size: 160% 160%;
        animation: sideShift 14s ease-in-out infinite alternate;
        overflow: hidden;
    }

    @keyframes sideShift {
        from { background-position: 0% 0%; }
        to   { background-position: 100% 100%; }
    }

    #net {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
    }

    .side > *:not(#net) {
        position: relative;
        z-index: 1;
        pointer-events: none;
    }

    .side .dots,
    .side .dots * {
        pointer-events: auto;
    }

    .greeting {
        font-size: 14px;
        color: rgba(255, 255, 255, .85);
        margin-top: 44px;
        animation: rise .7s .35s var(--ease) both;
    }

    .side-title {
        font-size: 40px;
        line-height: 1.05;
        font-weight: 800;
        letter-spacing: -.8px;
        margin: 12px 0 28px;
        animation: rise .8s .45s var(--ease) both;
    }

    @keyframes rise {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: none; }
    }

    .slide-area {
        position: relative;
        min-height: 92px;
        animation: rise .8s .6s var(--ease) both;
    }

    .slide {
        position: absolute;
        inset: 0 auto auto 0;
        display: flex;
        gap: 14px;
        align-items: flex-start;
        opacity: 0;
        transform: translateY(10px);
        transition: opacity .5s ease, transform .5s var(--ease);
    }

    .slide.active {
        opacity: 1;
        transform: translateY(0);
    }

    .slide-icon {
        position: relative;
        flex: 0 0 42px;
        height: 42px;
        border-radius: 12px;
        background: rgba(255, 255, 255, .16);
        border: 1px solid rgba(255, 255, 255, .25);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* cincin denyut pada ikon slide aktif */
    .slide.active .slide-icon::after {
        content: "";
        position: absolute;
        inset: -1px;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, .55);
        animation: ping 2.4s ease-out infinite;
    }

    @keyframes ping {
        from { opacity: .8; transform: scale(1); }
        to   { opacity: 0; transform: scale(1.5); }
    }

    .slide-icon svg {
        width: 20px;
        height: 20px;
    }

    .slide h3 {
        margin: 0 0 4px;
        font-size: 16px;
        font-weight: 700;
    }

    .slide p {
        margin: 0;
        max-width: 260px;
        font-size: 13.5px;
        line-height: 1.5;
        color: rgba(255, 255, 255, .8);
    }

    .dots {
        display: flex;
        gap: 6px;
        margin-top: 22px;
    }

    .dot {
        position: relative;
        width: 8px;
        height: 8px;
        border: 0;
        padding: 0;
        border-radius: 999px;
        background: rgba(255, 255, 255, .35);
        cursor: pointer;
        overflow: hidden;
        transition: width .35s var(--ease), background .3s ease;
    }

    .dot.active {
        width: 26px;
    }

    /* isi progres: mengisi selama 4,5 detik lalu pindah slide */
    .dot::after {
        content: "";
        position: absolute;
        inset: 0;
        background: #fff;
        transform: scaleX(0);
        transform-origin: left;
    }

    .dot.active::after {
        animation: fill 4.5s linear forwards;
    }

    @keyframes fill { to { transform: scaleX(1); } }

    .side-foot {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        font-size: 13px;
        color: rgba(255, 255, 255, .8);
        animation: rise .8s .75s var(--ease) both;
    }

    .clock {
        text-align: right;
    }

    .clock strong {
        display: block;
        font-size: 24px;
        font-weight: 700;
        color: #fff;
        letter-spacing: .5px;
        font-variant-numeric: tabular-nums;
    }

    /* ===== PANEL KANAN ===== */
    .form-side {
        background: #f6f8fd;
        padding: 48px 46px 32px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* urutan masuk form: satu rangkaian, dari atas ke bawah */
    .form-side > *,
    #loginForm > * {
        animation: rise .7s var(--ease) both;
    }

    .logo-wrap      { animation-delay: .35s; }
    .form-title     { animation-delay: .45s; }
    .form-sub       { animation-delay: .52s; }
    #loginForm > .field:nth-child(2) { animation-delay: .6s; }
    #loginForm > .field:nth-child(3) { animation-delay: .68s; }
    #loginForm > .btn-login          { animation-delay: .76s; }
    .form-foot      { animation-delay: .85s; }

    .logo-wrap {
        position: relative;
        width: 58px;
        height: 58px;
        border-radius: 50%;
        background: #fff;
        box-shadow: 0 8px 22px rgba(0, 150, 214, .35);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 22px;
    }

    .logo-wrap::before {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 50%;
        border: 2px solid rgba(0, 150, 214, .5);
        animation: logoRing 3s ease-out infinite;
    }

    @keyframes logoRing {
        0%   { opacity: .9; transform: scale(1); }
        70%, 100% { opacity: 0; transform: scale(1.65); }
    }

    .logo-wrap img {
        width: 46px;
        height: 46px;
        display: block;
    }

    .form-title {
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -.5px;
        margin: 0 0 6px;
    }

    .form-sub {
        font-size: 13.5px;
        color: var(--muted);
        margin: 0 0 22px;
    }

    .alert-error {
        background: #fee2e2;
        border: 1px solid #fecaca;
        color: #b91c1c;
        border-radius: 12px;
        padding: 11px 14px;
        font-size: 13.5px;
        font-weight: 500;
        margin-bottom: 16px;
        animation: shake .5s .5s both;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        20% { transform: translateX(-7px); }
        40% { transform: translateX(6px); }
        60% { transform: translateX(-4px); }
        80% { transform: translateX(3px); }
    }

    .field {
        position: relative;
        margin-bottom: 14px;
    }

    .field > svg.lead {
        position: absolute;
        left: 16px;
        top: 50%;
        width: 18px;
        height: 18px;
        transform: translateY(-50%);
        color: #94a3b8;
        pointer-events: none;
        transition: color .2s ease, transform .3s var(--ease);
        z-index: 1;
    }

    .field input {
        width: 100%;
        height: 50px;
        padding: 0 46px 0 46px;
        font: inherit;
        font-size: 14.5px;
        color: var(--ink);
        background: #eaf0fc;
        border: 1px solid #dbe5f7;
        border-radius: 14px;
        outline: none;
        transition: border-color .2s ease, box-shadow .25s ease, background .2s ease, transform .25s var(--ease);
    }

    .field input::placeholder {
        color: #94a3b8;
    }

    .field input:focus {
        background: #fff;
        border-color: var(--blue-2);
        box-shadow: 0 0 0 4px rgba(30, 91, 255, .16), 0 8px 20px rgba(30, 91, 255, .12);
        transform: translateY(-1px);
    }

    .field:focus-within > svg.lead {
        color: var(--blue-2);
        transform: translateY(-50%) scale(1.12);
    }

    .toggle-pass {
        position: absolute;
        right: 10px;
        top: 50%;
        width: 34px;
        height: 34px;
        transform: translateY(-50%);
        border: 0;
        background: transparent;
        color: #64748b;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
    }

    .toggle-pass:hover {
        background: rgba(15, 23, 42, .06);
        color: var(--ink);
    }

    .toggle-pass:focus-visible,
    .dot:focus-visible,
    .form-foot a:focus-visible {
        outline: 2px solid var(--blue-2);
        outline-offset: 2px;
    }

    .toggle-pass svg {
        width: 18px;
        height: 18px;
    }

    .btn-login {
        position: relative;
        overflow: hidden;
        width: 100%;
        height: 50px;
        margin-top: 8px;
        border: 0;
        border-radius: 14px;
        font: inherit;
        font-size: 15px;
        font-weight: 600;
        color: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: linear-gradient(90deg, #0a1a5c 0%, #0b4fb3 55%, #0096d6 100%);
        background-size: 200% 100%;
        box-shadow: 0 12px 26px rgba(11, 79, 179, .35);
        transition: transform .15s ease, box-shadow .2s ease, background-position .5s ease;
    }

    /* kilau yang menyapu saat hover */
    .btn-login::before {
        content: "";
        position: absolute;
        top: 0;
        bottom: 0;
        left: -60%;
        width: 40%;
        background: linear-gradient(100deg, transparent, rgba(255, 255, 255, .35), transparent);
        transform: skewX(-20deg);
    }

    .btn-login:hover {
        transform: translateY(-2px);
        background-position: 100% 0;
        box-shadow: 0 16px 32px rgba(11, 79, 179, .45);
    }

    .btn-login:hover::before {
        animation: sheen .9s ease;
    }

    @keyframes sheen { to { left: 130%; } }

    .btn-login:active {
        transform: translateY(0) scale(.99);
    }

    .btn-login:focus-visible {
        outline: 3px solid rgba(30, 91, 255, .45);
        outline-offset: 2px;
    }

    .btn-login:disabled {
        opacity: .85;
        cursor: wait;
        transform: none;
    }

    .btn-login svg {
        width: 18px;
        height: 18px;
        transition: transform .25s var(--ease);
    }

    .btn-login:hover svg {
        transform: translateX(3px);
    }

    .btn-login.loading svg {
        display: none;
    }

    .btn-login.loading::after {
        content: "";
        order: -1;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, .4);
        border-top-color: #fff;
        animation: spin .7s linear infinite;
    }

    @keyframes spin { to { transform: rotate(360deg); } }

    .form-foot {
        margin-top: 24px;
        padding-top: 16px;
        border-top: 1px solid #e5eaf4;
        text-align: center;
        font-size: 12.5px;
        color: #94a3b8;
    }

    .form-foot a {
        display: inline-block;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 500;
        color: var(--blue-2);
        text-decoration: none;
    }

    .form-foot a:hover {
        text-decoration: underline;
    }

    /* ===== RESPONSIF ===== */
    @media (max-width: 820px) {
        .login-shell {
            grid-template-columns: 1fr;
            max-width: 460px;
            min-height: 0;
        }

        .side {
            display: none;
        }

        .form-side {
            padding: 36px 28px 26px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        *,
        *::before,
        *::after {
            animation: none !important;
            transition: none !important;
        }

        .dot.active::after {
            transform: scaleX(1);
        }
    }

</style>

</head>

<body>

<div class="bg" aria-hidden="true">
    <span class="orb o1"></span>
    <span class="orb o2"></span>
    <span class="orb o3"></span>
</div>

<div class="login-shell">

    <!-- ===== PANEL KIRI ===== -->
    <section class="side" id="side" aria-hidden="true">

        <canvas id="net"></canvas>

        <div class="greeting" id="greeting">Selamat datang, silakan masuk</div>

        <h2 class="side-title">Call Management<br>System</h2>

        <div class="slide-area">

            <div class="slide active">
                <div class="slide-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg>
                </div>
                <div>
                    <h3>Call tercatat rapi</h3>
                    <p>Setiap call customer terdokumentasi dan mudah ditelusuri kembali.</p>
                </div>
            </div>

            <div class="slide">
                <div class="slide-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8v4l3 2"/><circle cx="12" cy="12" r="9"/></svg>
                </div>
                <div>
                    <h3>Pantau tindak lanjut</h3>
                    <p>Status case dan follow up terlihat dalam satu tampilan, tanpa terlewat.</p>
                </div>
            </div>

            <div class="slide">
                <div class="slide-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20V10M10 20V4M16 20v-7M22 20H2"/></svg>
                </div>
                <div>
                    <h3>Laporan yang jelas</h3>
                    <p>Data operasional tersaji ringkas untuk keputusan yang lebih cepat.</p>
                </div>
            </div>

        </div>

        <div class="dots" id="dots">
            <button type="button" class="dot active" aria-label="Slide 1"></button>
            <button type="button" class="dot" aria-label="Slide 2"></button>
            <button type="button" class="dot" aria-label="Slide 3"></button>
        </div>

        <div class="side-foot">
            <span>HP Service Center Semarang</span>
            <div class="clock">
                <strong id="clockTime">--:--</strong>
                <span id="clockDate"></span>
            </div>
        </div>

    </section>

    <!-- ===== PANEL KANAN ===== -->
    <section class="form-side">

        <div class="logo-wrap">
            <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/HP_logo_2012.svg" alt="HP">
        </div>

        <h1 class="form-title">Masuk ke akun Anda</h1>
        <p class="form-sub">Gunakan username dan password yang terdaftar.</p>

        @if(session('error'))
        <div class="alert-error" role="alert">
            {{ session('error') }}
        </div>
        @endif

        <form method="POST" action="/login" id="loginForm">
            @csrf

            <div class="field">
                <svg class="lead" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10zm0 2c-4.4 0-8 2.2-8 5v1a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-1c0-2.8-3.6-5-8-5z"/></svg>
                <input type="text" name="username" placeholder="Username" autocomplete="username" aria-label="Username" required autofocus>
            </div>

            <div class="field">
                <svg class="lead" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17 9h-1V7a4 4 0 0 0-8 0v2H7a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2zm-7-2a2 2 0 0 1 4 0v2h-4V7z"/></svg>
                <input type="password" name="password" id="password" placeholder="Password" autocomplete="current-password" aria-label="Password" required>
                <button type="button" class="toggle-pass" id="togglePass" aria-label="Tampilkan password">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
            </div>

            <button type="submit" class="btn-login" id="btnLogin">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg>
                <span id="btnText">Login System</span>
            </button>
        </form>

        <div class="form-foot">
            <a href="https://hpssemarang.great-site.net/">Kembali ke website</a>
            <div>HP Customer Service System &copy;2026</div>
        </div>

    </section>

</div>

<script>
    (function () {

        // ---------- sapaan & jam ----------
        var hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        var bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        function pad(n) { return String(n).padStart(2, '0'); }

        function updateClock() {
            var d = new Date();
            var h = d.getHours();

            var waktu = h >= 4 && h < 11 ? 'pagi'
                : h >= 11 && h < 15 ? 'siang'
                : h >= 15 && h < 18 ? 'sore'
                : 'malam';

            document.getElementById('greeting').textContent = 'Selamat ' + waktu + ', silakan masuk';
            document.getElementById('clockTime').textContent = pad(h) + ':' + pad(d.getMinutes());
            document.getElementById('clockDate').textContent =
                hari[d.getDay()] + ', ' + d.getDate() + ' ' + bulan[d.getMonth()] + ' ' + d.getFullYear();
        }

        updateClock();
        setInterval(updateClock, 15000);

        // ---------- slide ----------
        var slides = document.querySelectorAll('.slide');
        var dots = document.querySelectorAll('.dot');
        var current = 0;
        var timer = null;

        function show(i) {
            current = i;
            slides.forEach(function (s, idx) { s.classList.toggle('active', idx === i); });
            dots.forEach(function (d, idx) { d.classList.toggle('active', idx === i); });
        }

        function start() {
            clearInterval(timer);
            timer = setInterval(function () { show((current + 1) % slides.length); }, 4500);
        }

        dots.forEach(function (d, idx) {
            d.addEventListener('click', function () {
                show(idx);
                start();
            });
        });

        start();

        // ---------- jaringan titik bergerak (panel kiri) ----------
        var side = document.getElementById('side');
        var canvas = document.getElementById('net');
        var ctx = canvas.getContext('2d');
        var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        var W = 0, H = 0, dpr = 1;
        var nodes = [];
        var mouse = { x: -999, y: -999 };
        var LINK = 120;     // jarak maksimal garis antar titik
        var MOUSE_R = 150;  // jangkauan kursor
        var running = false;

        function makeNodes() {
            var count = Math.max(28, Math.min(60, Math.round(W * H / 9000)));
            nodes = [];
            for (var i = 0; i < count; i++) {
                nodes.push({
                    x: Math.random() * W,
                    y: Math.random() * H,
                    vx: (Math.random() - .5) * .35,
                    vy: (Math.random() - .5) * .35,
                    r: Math.random() * 1.6 + 1.2,
                    p: Math.random() * Math.PI * 2   // fase kedip
                });
            }
        }

        function resize() {
            var rect = side.getBoundingClientRect();
            if (!rect.width) return;
            dpr = Math.min(window.devicePixelRatio || 1, 2);
            W = rect.width;
            H = rect.height;
            canvas.width = W * dpr;
            canvas.height = H * dpr;
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
            makeNodes();
            if (reduce) draw(0);
        }

        function draw(t) {
            ctx.clearRect(0, 0, W, H);

            for (var i = 0; i < nodes.length; i++) {
                var a = nodes[i];

                if (!reduce) {
                    a.x += a.vx;
                    a.y += a.vy;
                    if (a.x < 0 || a.x > W) a.vx *= -1;
                    if (a.y < 0 || a.y > H) a.vy *= -1;
                }

                // garis antar titik
                for (var j = i + 1; j < nodes.length; j++) {
                    var b = nodes[j];
                    var dx = a.x - b.x, dy = a.y - b.y;
                    var d = Math.sqrt(dx * dx + dy * dy);
                    if (d < LINK) {
                        ctx.strokeStyle = 'rgba(255,255,255,' + (0.28 * (1 - d / LINK)).toFixed(3) + ')';
                        ctx.lineWidth = 1;
                        ctx.beginPath();
                        ctx.moveTo(a.x, a.y);
                        ctx.lineTo(b.x, b.y);
                        ctx.stroke();
                    }
                }

                // garis ke kursor
                var mx = a.x - mouse.x, my = a.y - mouse.y;
                var md = Math.sqrt(mx * mx + my * my);
                var near = md < MOUSE_R;
                if (near) {
                    ctx.strokeStyle = 'rgba(140,200,255,' + (0.55 * (1 - md / MOUSE_R)).toFixed(3) + ')';
                    ctx.lineWidth = 1;
                    ctx.beginPath();
                    ctx.moveTo(a.x, a.y);
                    ctx.lineTo(mouse.x, mouse.y);
                    ctx.stroke();
                }

                // titik (berkedip pelan)
                var glow = .55 + .35 * Math.sin(t / 900 + a.p);
                ctx.fillStyle = 'rgba(255,255,255,' + (near ? 0.95 : glow).toFixed(3) + ')';
                ctx.beginPath();
                ctx.arc(a.x, a.y, near ? a.r + 1 : a.r, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        function loop(t) {
            if (!running) return;
            draw(t);
            requestAnimationFrame(loop);
        }

        function startNet() {
            if (reduce || running) return;
            running = true;
            requestAnimationFrame(loop);
        }

        // kursor dibaca dari seluruh kartu karena panel kiri tidak menerima event mouse
        document.querySelector('.login-shell').addEventListener('mousemove', function (e) {
            var r = side.getBoundingClientRect();
            mouse.x = e.clientX - r.left;
            mouse.y = e.clientY - r.top;
        });

        document.querySelector('.login-shell').addEventListener('mouseleave', function () {
            mouse.x = mouse.y = -999;
        });

        document.addEventListener('visibilitychange', function () {
            if (document.hidden) { running = false; }
            else { startNet(); }
        });

        window.addEventListener('resize', resize);
        resize();
        startNet();

        // ---------- tampilkan / sembunyikan password ----------
        var pass = document.getElementById('password');
        var toggle = document.getElementById('togglePass');

        toggle.addEventListener('click', function () {
            var hidden = pass.type === 'password';
            pass.type = hidden ? 'text' : 'password';
            toggle.setAttribute('aria-label', hidden ? 'Sembunyikan password' : 'Tampilkan password');
        });

        // ---------- cegah klik ganda saat login ----------
        document.getElementById('loginForm').addEventListener('submit', function () {
            var btn = document.getElementById('btnLogin');
            document.getElementById('btnText').textContent = 'Memproses...';
            btn.classList.add('loading');
            setTimeout(function () { btn.disabled = true; }, 0);
        });

    })();
</script>

</body>
</html>