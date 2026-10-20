<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nayzzu AI - Smart IoT, Telemetry & Voice Interface</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
:root{
  --bg:#06030f;
  --bg-2:#0c0620;
  --card:rgba(24,14,48,.55);
  --card-solid:#120a26;
  --border:rgba(196,160,255,.12);
  --border-strong:rgba(196,160,255,.28);

  --p-50:#f5f0ff;
  --p-200:#ddd0ff;
  --p-300:#c4b0ff;
  --p-400:#a78bfa;
  --p-500:#8b5cf6;
  --p-600:#7c3aed;
  --p-700:#6d28d9;
  --p-900:#2e1065;
  --fuchsia:#e879f9;
  --pink:#f472b6;
  --indigo:#818cf8;

  --glow:rgba(139,92,246,.45);
  --glow-soft:rgba(167,139,250,.18);

  --text:#f4efff;
  --muted:#9d8fc2;
}

*{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{
  background:var(--bg);
  color:var(--text);
  font-family:'Plus Jakarta Sans',sans-serif;
  min-height:100vh;
  overflow-x:hidden;
  position:relative;
  padding-bottom:120px;
}
.mono{font-family:'JetBrains Mono',monospace}
button{font-family:inherit}
#ai-response, #ai-response *{user-select:text}

/* ---------- Background ---------- */
.ambient{position:fixed;inset:0;z-index:0;pointer-events:none;overflow:hidden}
.blob{position:absolute;border-radius:50%;filter:blur(130px);opacity:.38;animation:drift 22s infinite ease-in-out alternate}
.blob.b1{top:-15%;left:-10%;width:55vw;height:55vw;background:radial-gradient(circle,var(--p-600),transparent 70%)}
.blob.b2{bottom:-20%;right:-12%;width:60vw;height:60vw;background:radial-gradient(circle,var(--fuchsia),transparent 70%);opacity:.25;animation-delay:-8s}
.blob.b3{top:35%;left:40%;width:35vw;height:35vw;background:radial-gradient(circle,var(--indigo),transparent 70%);opacity:.22;animation-delay:-14s}
@keyframes drift{0%{transform:translate(0,0) scale(1)}50%{transform:translate(60px,40px) scale(1.12)}100%{transform:translate(-40px,80px) scale(.95)}}
.grid-bg{
  position:fixed;inset:0;z-index:0;pointer-events:none;
  background-image:
    linear-gradient(rgba(167,139,250,.05) 1px,transparent 1px),
    linear-gradient(90deg,rgba(167,139,250,.05) 1px,transparent 1px);
  background-size:48px 48px;
  mask-image:radial-gradient(ellipse at 50% 30%,#000 20%,transparent 75%);
  -webkit-mask-image:radial-gradient(ellipse at 50% 30%,#000 20%,transparent 75%);
}

/* ---------- BOOT SCREEN ---------- */
#boot-screen{
  position:fixed;inset:0;z-index:9999;background:radial-gradient(ellipse at 50% 40%,#1a0b3d 0%,#07030f 70%);
  display:flex;align-items:center;justify-content:center;
  transition:opacity .9s cubic-bezier(.16,1,.3,1),transform .9s cubic-bezier(.16,1,.3,1),filter .9s;
  overflow:hidden;
}
#boot-screen.leaving{opacity:0;transform:scale(1.08);filter:blur(12px);pointer-events:none}
#boot-canvas{position:absolute;inset:0;width:100%;height:100%}
.boot-scan{
  position:absolute;left:0;right:0;height:140px;top:-140px;
  background:linear-gradient(180deg,transparent,rgba(167,139,250,.12),transparent);
  animation:scan 5s linear infinite;pointer-events:none;
}
@keyframes scan{to{top:100%}}
.boot-vignette{position:absolute;inset:0;background:radial-gradient(circle at center,transparent 40%,rgba(0,0,0,.65));pointer-events:none}

.boot-content{
  position:relative;z-index:2;display:flex;flex-direction:column;align-items:center;gap:26px;
  width:min(520px,92vw);text-align:center;
}
.boot-orb-wrap{position:relative;width:190px;height:190px;display:flex;align-items:center;justify-content:center}
.ring{position:absolute;border-radius:50%;border:1.5px solid transparent}
.ring.r1{inset:0;border-top-color:var(--p-400);border-right-color:rgba(167,139,250,.3);animation:spin 3.2s linear infinite}
.ring.r2{inset:16px;border-bottom-color:var(--fuchsia);border-left-color:rgba(232,121,249,.3);animation:spin 2.4s linear infinite reverse}
.ring.r3{inset:32px;border-top-color:var(--indigo);border-left-color:rgba(129,140,248,.3);animation:spin 4.5s linear infinite}
.ring.dash{inset:-12px;border:1px dashed rgba(167,139,250,.3);animation:spin 18s linear infinite reverse}
@keyframes spin{to{transform:rotate(360deg)}}
.boot-orb{
  width:96px;height:96px;border-radius:50%;
  background:radial-gradient(circle at 35% 30%,#fff 0%,#e9d5ff 14%,#a78bfa 42%,#6d28d9 74%,#2e1065 100%);
  box-shadow:0 0 60px var(--glow),0 0 120px rgba(139,92,246,.35),inset 0 0 25px rgba(255,255,255,.25);
  display:flex;align-items:center;justify-content:center;
  animation:breathe 3s ease-in-out infinite;
}
@keyframes breathe{0%,100%{transform:scale(1)}50%{transform:scale(1.08)}}
.boot-orb svg{filter:drop-shadow(0 2px 8px rgba(46,16,101,.6))}

.boot-title{
  font-size:clamp(2.4em,7vw,3.4em);font-weight:800;letter-spacing:-1.5px;line-height:1;
  background:linear-gradient(120deg,#fff 10%,var(--p-300) 50%,var(--fuchsia) 90%);
  -webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;
}
.boot-sub{color:var(--muted);font-size:.95em;margin-top:8px;letter-spacing:.5px}

.boot-console{
  width:100%;background:rgba(12,6,32,.65);border:1px solid var(--border);border-radius:16px;
  padding:14px 18px;text-align:left;font-family:'JetBrains Mono',monospace;font-size:.74em;line-height:1.85;
  height:150px;overflow:hidden;backdrop-filter:blur(10px);
  box-shadow:inset 0 0 30px rgba(139,92,246,.08);
  display:flex;flex-direction:column;justify-content:flex-end;
}
.boot-line{color:var(--muted);opacity:0;animation:lineIn .3s forwards}
.boot-line .ok{color:var(--p-400);font-weight:700}
.boot-line .tag{color:var(--fuchsia)}
@keyframes lineIn{to{opacity:1}}

.boot-progress{width:100%;display:flex;flex-direction:column;gap:8px}
.progress-meta{display:flex;justify-content:space-between;font-family:'JetBrains Mono',monospace;font-size:.72em;color:var(--muted);letter-spacing:1px}
.progress-track{height:6px;background:rgba(167,139,250,.12);border-radius:99px;overflow:hidden;position:relative}
.progress-fill{
  height:100%;width:0%;border-radius:99px;
  background:linear-gradient(90deg,var(--p-600),var(--p-400),var(--fuchsia));
  box-shadow:0 0 18px var(--glow);transition:width .25s ease-out;position:relative;
}
.progress-fill::after{
  content:"";position:absolute;inset:0;
  background:linear-gradient(90deg,transparent,rgba(255,255,255,.5),transparent);
  animation:shine 1.4s infinite;
}
@keyframes shine{from{transform:translateX(-100%)}to{transform:translateX(100%)}}

.boot-btn{
  position:relative;padding:16px 40px;border-radius:99px;border:none;cursor:pointer;
  color:#fff;font-weight:700;font-size:1em;letter-spacing:.5px;
  background:linear-gradient(135deg,var(--p-600),var(--fuchsia));
  box-shadow:0 12px 40px var(--glow),inset 0 1px 0 rgba(255,255,255,.35);
  opacity:0;transform:translateY(14px) scale(.96);pointer-events:none;
  transition:opacity .6s,transform .6s cubic-bezier(.16,1,.3,1),box-shadow .3s;
  display:flex;align-items:center;gap:10px;
}
.boot-btn.ready{opacity:1;transform:none;pointer-events:auto;animation:btnPulse 2.2s infinite}
.boot-btn:hover{transform:translateY(-3px) scale(1.03);box-shadow:0 16px 50px rgba(232,121,249,.5)}
@keyframes btnPulse{0%,100%{box-shadow:0 12px 40px var(--glow),0 0 0 0 rgba(167,139,250,.5)}50%{box-shadow:0 12px 40px var(--glow),0 0 0 14px rgba(167,139,250,0)}}
.boot-hint{font-size:.72em;color:var(--muted);font-family:'JetBrains Mono',monospace;letter-spacing:1px;min-height:1.2em}

/* ---------- APP ---------- */
.app{position:relative;z-index:5;width:94%;max-width:1240px;margin:0 auto;padding-top:20px;display:flex;flex-direction:column;gap:22px}

header{
  display:flex;justify-content:space-between;align-items:center;gap:12px;
  padding:14px 22px;background:var(--card);border:1px solid var(--border);border-radius:22px;
  backdrop-filter:blur(24px);
  position:sticky;top:12px;z-index:50;
  box-shadow:0 10px 40px rgba(0,0,0,.35);
}
.brand{display:flex;align-items:center;gap:14px}
.brand-icon{
  width:42px;
  height:42px;
  border-radius:50%;
  overflow:hidden;
  display:flex;
  align-items:center;
  justify-content:center;
  background:rgba(255,255,255,.05);
  border:1px solid var(--border-strong);
  box-shadow:0 0 15px var(--glow);
}
.brand-icon img{
  width:100%;
  height:100%;
  object-fit:cover;
}
.brand-name{font-weight:800;font-size:1.2em;letter-spacing:-.3px}
.header-right{display:flex;align-items:center;gap:12px}
.clock{font-family:'JetBrains Mono',monospace;font-size:.82em;color:var(--muted);padding:8px 14px;border-radius:99px;border:1px solid var(--border);background:rgba(255,255,255,.03)}
.status-pill{
  display:flex;align-items:center;gap:9px;padding:8px 16px;border-radius:99px;
  border:1px solid var(--border-strong);background:rgba(139,92,246,.1);
  font-size:.78em;font-weight:700;letter-spacing:1px;color:var(--p-200);
}
.status-dot{width:8px;height:8px;border-radius:50%;background:var(--p-500);box-shadow:0 0 12px var(--p-400);animation:blink 2s infinite}
@keyframes blink{50%{opacity:.4}}

/* Cards */
.card{
  background:var(--card);border:1px solid var(--border);border-radius:26px;
  backdrop-filter:blur(24px);position:relative;overflow:hidden;
  box-shadow:0 20px 60px rgba(0,0,0,.35);
}
.card::before{
  content:"";position:absolute;inset:0;border-radius:inherit;padding:1px;
  background:linear-gradient(145deg,rgba(196,160,255,.3),transparent 40%,transparent 60%,rgba(232,121,249,.18));
  -webkit-mask:linear-gradient(#000 0 0) content-box,linear-gradient(#000 0 0);
  -webkit-mask-composite:xor;mask-composite:exclude;pointer-events:none;
}

.section-title{
  display:flex;justify-content:space-between;align-items:center;gap:10px;
  font-family:'JetBrains Mono',monospace;font-size:.74em;font-weight:700;letter-spacing:1.5px;color:var(--muted);
  margin-bottom:14px;
}
.section-title .l{display:flex;align-items:center;gap:10px}
.section-title .l::before{content:"";width:22px;height:2px;border-radius:2px;background:linear-gradient(90deg,var(--p-500),var(--fuchsia))}
.section-title .r{color:var(--p-400)}

/* Hero */
.hero{display:grid;grid-template-columns:420px 1fr;gap:22px}
.orb-card{padding:28px 24px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:18px;min-height:380px}
.visualizer-wrapper{position:relative;width:190px;height:190px;display:flex;align-items:center;justify-content:center}
#visualizer-canvas{position:absolute;inset:-60px;width:calc(100% + 120px);height:calc(100% + 120px);pointer-events:none}
.orb-core{
  position:relative;z-index:2;width:112px;height:112px;border-radius:50%;
  background:radial-gradient(circle at 35% 30%,#fff 0%,#e9d5ff 14%,#a78bfa 42%,#6d28d9 74%,#2e1065 100%);
  box-shadow:0 0 60px var(--glow),0 0 120px rgba(139,92,246,.3),inset 0 0 25px rgba(255,255,255,.2);
  display:flex;align-items:center;justify-content:center;
  transition:transform .35s cubic-bezier(.175,.885,.32,1.275),background .4s;
}
.orb-ring{width:86%;height:86%;border-radius:50%;border:1px solid rgba(255,255,255,.4);display:flex;align-items:center;justify-content:center}
.orb-logo{font-size:.78em;font-weight:800;letter-spacing:3px;color:#fff;text-shadow:0 2px 10px rgba(46,16,101,.7)}
.state-listening .orb-core{background:radial-gradient(circle at 35% 30%,#fff 0%,#fbcfe8 18%,#e879f9 52%,#86198f 100%);transform:scale(1.12);box-shadow:0 0 70px rgba(232,121,249,.55),0 0 140px rgba(232,121,249,.3)}
.state-thinking .orb-core{background:radial-gradient(circle at 35% 30%,#fff 0%,#c7d2fe 18%,#818cf8 52%,#3730a3 100%);animation:pulseRapid .6s infinite alternate}
.state-responding .orb-core{background:radial-gradient(circle at 35% 30%,#fff 0%,#ddd6fe 16%,#8b5cf6 52%,#4c1d95 100%);animation:breathe 1.6s infinite}
@keyframes pulseRapid{from{transform:scale(.94)}to{transform:scale(1.13)}}

.orb-state-text{font-weight:800;font-size:1.15em;letter-spacing:.5px}
.orb-state-sub{font-size:.82em;color:var(--muted);text-align:center;max-width:280px;line-height:1.5}

.terminal{padding:22px 26px;display:flex;flex-direction:column;min-height:380px}
.terminal-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px}
.dots{display:flex;gap:7px}
.dots i{width:11px;height:11px;border-radius:50%;background:rgba(196,160,255,.25)}
.dots i:nth-child(1){background:#f472b6}
.dots i:nth-child(2){background:#a78bfa}
.dots i:nth-child(3){background:#818cf8}
.tts-badge{font-family:'JetBrains Mono',monospace;font-size:.72em;color:var(--p-400);padding:4px 12px;border:1px solid var(--border-strong);border-radius:99px;background:rgba(139,92,246,.1)}
.response-area{
  flex:1;overflow-y:auto;font-size:1em;line-height:1.7;color:#e9e1ff;
  background:rgba(8,4,20,.55);border:1px solid var(--border);border-radius:18px;padding:18px 20px;
  min-height:260px;max-height:300px;
}
.response-area::-webkit-scrollbar{width:6px}
.response-area::-webkit-scrollbar-thumb{background:rgba(167,139,250,.3);border-radius:99px}
.msg-label{font-family:'JetBrains Mono',monospace;font-size:.72em;font-weight:700;letter-spacing:1px}
.msg-user{color:var(--muted)}
.msg-ai{color:var(--fuchsia)}
.msg-err{color:var(--pink)}

/* Telemetry */
.telemetry-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
.tele-card{padding:20px 22px;display:flex;flex-direction:column;gap:14px}
.tele-top{display:flex;align-items:center;gap:16px}
.tele-icon{
  width:50px;height:50px;border-radius:16px;display:flex;align-items:center;justify-content:center;flex-shrink:0;
  background:linear-gradient(135deg,rgba(139,92,246,.28),rgba(232,121,249,.16));
  border:1px solid var(--border-strong);color:var(--p-300);
}
.tele-label{font-size:.72em;color:var(--muted);font-weight:700;letter-spacing:1px}
.tele-value{font-family:'JetBrains Mono',monospace;font-size:2em;font-weight:700;line-height:1.1;color:#fff}
.tele-value small{font-size:.42em;color:var(--p-400);margin-left:5px;font-weight:600}
.meter{height:6px;background:rgba(167,139,250,.12);border-radius:99px;overflow:hidden}
.meter>span{display:block;height:100%;width:0%;border-radius:99px;background:linear-gradient(90deg,var(--p-600),var(--fuchsia));box-shadow:0 0 12px var(--glow);transition:width .6s cubic-bezier(.16,1,.3,1)}
.meter-scale{display:flex;justify-content:space-between;font-family:'JetBrains Mono',monospace;font-size:.62em;color:var(--muted);margin-top:-6px}

/* Charts */
.charts-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:16px}
.chart-card{padding:20px 20px 16px;display:flex;flex-direction:column}
.chart-title{font-family:'JetBrains Mono',monospace;font-size:.72em;font-weight:700;letter-spacing:1px;color:var(--muted);margin-bottom:12px;display:flex;justify-content:space-between}
.chart-title b{color:var(--p-300);font-weight:700}
.chart-wrap{position:relative;height:230px}

/* Devices */
.devices-grid{display:grid;grid-template-columns:repeat(6,1fr);gap:14px}
.device-card{
  padding:16px;display:flex;flex-direction:column;justify-content:space-between;gap:20px;
  transition:all .35s ease;
}
.device-card.active{
  background:linear-gradient(160deg,rgba(139,92,246,.28),rgba(232,121,249,.1));
  border-color:var(--border-strong);box-shadow:0 14px 40px rgba(139,92,246,.28);transform:translateY(-3px);
}
.device-head{display:flex;justify-content:space-between;align-items:center}
.device-icon{width:38px;height:38px;border-radius:12px;background:rgba(255,255,255,.06);display:flex;align-items:center;justify-content:center;color:var(--muted);transition:all .3s}
.device-card.active .device-icon{background:linear-gradient(135deg,var(--p-500),var(--fuchsia));color:#fff;box-shadow:0 6px 18px var(--glow)}
.device-name{font-weight:700;font-size:.92em}
.device-status{font-family:'JetBrains Mono',monospace;font-size:.7em;color:var(--muted);margin-top:2px}
.device-card.active .device-status{color:var(--p-300)}

.switch{position:relative;display:inline-block;width:42px;height:24px}
.switch input{opacity:0;width:0;height:0}
.slider{position:absolute;cursor:pointer;inset:0;background:rgba(255,255,255,.14);transition:.3s;border-radius:30px}
.slider::before{content:"";position:absolute;height:18px;width:18px;left:3px;bottom:3px;background:#fff;transition:.3s;border-radius:50%}
input:checked+.slider{background:linear-gradient(135deg,var(--p-500),var(--fuchsia))}
input:checked+.slider::before{transform:translateX(18px)}

/* Dock */
.dock{
  position:fixed;left:50%;bottom:22px;transform:translateX(-50%);z-index:100;
  display:flex;align-items:center;gap:12px;padding:10px;border-radius:99px;
  background:rgba(14,7,34,.78);border:1px solid var(--border-strong);backdrop-filter:blur(26px);
  box-shadow:0 20px 60px rgba(0,0,0,.55),0 0 40px rgba(139,92,246,.2);
}
.btn-talk{
  display:flex;align-items:center;gap:12px;padding:15px 34px;border-radius:99px;border:none;cursor:pointer;
  color:#fff;font-weight:700;font-size:.98em;letter-spacing:.4px;
  background:linear-gradient(135deg,var(--p-600),var(--fuchsia));
  box-shadow:0 8px 28px var(--glow),inset 0 1px 0 rgba(255,255,255,.3);
  transition:all .3s;
}
.btn-talk:hover{transform:translateY(-2px);box-shadow:0 12px 36px rgba(232,121,249,.5)}
.btn-talk.recording{background:linear-gradient(135deg,#c026d3,#f472b6);animation:recPulse 1.2s infinite}
@keyframes recPulse{0%,100%{box-shadow:0 8px 28px rgba(232,121,249,.5),0 0 0 0 rgba(244,114,182,.5)}50%{box-shadow:0 8px 28px rgba(232,121,249,.5),0 0 0 14px rgba(244,114,182,0)}}
.btn-interrupt{
  display:none;padding:15px 22px;border-radius:99px;cursor:pointer;font-weight:700;font-size:.85em;
  border:1px solid var(--border-strong);background:rgba(139,92,246,.15);color:var(--p-200);
}
.btn-interrupt:hover{background:rgba(139,92,246,.3)}

/* Reveal animation */
.reveal{opacity:0;transform:translateY(24px);animation:rise .8s cubic-bezier(.16,1,.3,1) forwards}
@keyframes rise{to{opacity:1;transform:none}}

/* Responsive */
@media(max-width:1100px){
  .hero{grid-template-columns:1fr}
  .charts-grid{grid-template-columns:1fr}
  .devices-grid{grid-template-columns:repeat(3,1fr)}
}
@media(max-width:700px){
  .telemetry-grid{grid-template-columns:1fr}
  .devices-grid{grid-template-columns:repeat(2,1fr)}
  .clock{display:none}
  header{padding:12px 16px}
  .btn-talk{padding:14px 24px}
}
</style>
</head>
<body>

<div class="ambient"><div class="blob b1"></div><div class="blob b2"></div><div class="blob b3"></div></div>
<div class="grid-bg"></div>

<!-- ================= BOOT SCREEN ================= -->
<div id="boot-screen">
  <canvas id="boot-canvas"></canvas>
  <div class="boot-scan"></div>
  <div class="boot-vignette"></div>

  <div class="boot-content">
    <div class="boot-orb-wrap">
      <div class="ring dash"></div>
      <div class="ring r1"></div>
      <div class="ring r2"></div>
      <div class="ring r3"></div>
      <div class="boot-orb">
        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
          <path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3z"/>
          <path d="M19 10v2a7 7 0 0 1-14 0v-2"/>
          <line x1="12" y1="19" x2="12" y2="22"/>
        </svg>
      </div>
    </div>

    <div>
      <div class="boot-title">Nayzzu AI</div>
      <div class="boot-sub">Asisten Suara · Telemetri IoT</div>
    </div>

    <div class="boot-console" id="boot-console"></div>

    <div class="boot-progress">
      <div class="progress-meta"><span id="boot-phase">INISIALISASI</span><span id="boot-percent">0%</span></div>
      <div class="progress-track"><div class="progress-fill" id="boot-fill"></div></div>
    </div>

    <button class="boot-btn" id="boot-btn">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><polygon points="6 3 20 12 6 21 6 3"/></svg>
      Aktifkan Sistem Suara
    </button>
    <div class="boot-hint" id="boot-hint">MEMUAT MODUL SISTEM...</div>
  </div>
</div>

<!-- ================= APP ================= -->
<div class="app" id="app" style="visibility:hidden">

 <header class="reveal">
  <div class="brand">
    <div class="brand-icon">
      <img src="logo-nayzzu.png" alt="Nayzzu AI Logo">
    </div>
    <div class="brand-name">Nayzzu AI</div>
  </div>
  <div class="header-right">
    <div class="clock" id="clock">--:--:--</div>
    <div class="status-pill"><div class="status-dot" id="status-dot"></div><span id="ai-status">STANDBY</span></div>
  </div>
</header>

  <!-- HERO -->
  <section class="hero reveal" style="animation-delay:.1s">
    <div class="card orb-card">
      <div class="visualizer-wrapper" id="visualizer-wrapper">
        <canvas id="visualizer-canvas"></canvas>
        <div class="orb-core"><div class="orb-ring"><span class="orb-logo">NAYZZU</span></div></div>
      </div>
      <div class="orb-state-text" id="orb-state-text">Siap Mendengarkan</div>
      <div class="orb-state-sub" id="orb-state-sub">Tekan tombol mikrofon di bawah lalu ucapkan perintah untuk mengontrol perangkat.</div>
    </div>

    <div class="card terminal">
      <div class="terminal-head">
        <div class="dots"><i></i><i></i><i></i></div>
        <span class="section-title mono" style="margin:0"><span class="l">TERMINAL RESPONS</span></span>
        <span class="tts-badge" id="tts-status">TTS: READY</span>
      </div>
      <div class="response-area" id="ai-response">
        Tekan <strong style="color:var(--p-300)">Bicara</strong> di bawah untuk memberi perintah ke Nayzzu AI.
      </div>
    </div>
  </section>

  <!-- TELEMETRY -->
  <section class="reveal" style="animation-delay:.2s">
    <div class="section-title"><span class="l">MONITORING SENSOR IOT</span><span class="r" id="sensor-iot-status">LIVE FEED</span></div>
    <div class="telemetry-grid">
      <div class="card tele-card">
        <div class="tele-top">
          <div class="tele-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14 14.76V3.5a2.5 2.5 0 0 0-5 0v11.26a4.5 4.5 0 1 0 5 0z"/></svg></div>
          <div><div class="tele-label">SUHU RUANGAN</div><div class="tele-value"><span id="val-suhu">--</span><small>°C</small></div></div>
        </div>
        <div class="meter"><span id="meter-suhu"></span></div>
        <div class="meter-scale"><span>0°</span><span>50°</span></div>
      </div>
      <div class="card tele-card">
        <div class="tele-top">
          <div class="tele-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg></div>
          <div><div class="tele-label">KELEMBAPAN</div><div class="tele-value"><span id="val-kelembapan">--</span><small>%</small></div></div>
        </div>
        <div class="meter"><span id="meter-hum"></span></div>
        <div class="meter-scale"><span>0%</span><span>100%</span></div>
      </div>
      <div class="card tele-card">
        <div class="tele-top">
          <div class="tele-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="4"/><path d="M12 2v4M12 18v4M2 12h4M18 12h4"/></svg></div>
          <div><div class="tele-label">JARAK DETEKSI</div><div class="tele-value"><span id="val-jarak">--</span><small>cm</small></div></div>
        </div>
        <div class="meter"><span id="meter-jarak"></span></div>
        <div class="meter-scale"><span>0</span><span>400 cm</span></div>
      </div>
    </div>
  </section>

  <!-- CHARTS -->
  <section class="reveal" style="animation-delay:.3s">
    <div class="section-title"><span class="l">GRAFIK ANALITIK LIVE</span><span class="r">15 DATA TERAKHIR</span></div>
    <div class="charts-grid">
      <div class="card chart-card">
        <div class="chart-title"><span>SUHU & KELEMBAPAN</span><b>°C / %</b></div>
        <div class="chart-wrap"><canvas id="chartSuhuHum"></canvas></div>
      </div>
      <div class="card chart-card">
        <div class="chart-title"><span>JARAK DETEKSI</span><b>cm</b></div>
        <div class="chart-wrap"><canvas id="chartJarak"></canvas></div>
      </div>
    </div>
  </section>

  <!-- DEVICES -->
  <section class="reveal" style="animation-delay:.5s">
    <div class="section-title"><span class="l">KONTROL PERANGKAT ELEKTRONIK</span><span class="r" id="active-devices-count">0/6 AKTIF</span></div>
    <div class="devices-grid">
      <div class="card device-card" id="card-lampu">
        <div class="device-head">
          <div class="device-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18h6"/><path d="M10 22h4"/><path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1.55.62 2.96 1.63 4 .73.74 1.2 1.5 1.37 2.5"/></svg></div>
          <label class="switch"><input type="checkbox" id="toggle-lampu" onchange="toggleDeviceManual('lampu', this.checked)"><span class="slider"></span></label>
        </div>
        <div><div class="device-name">Lampu</div><div class="device-status" id="status-lampu">OFF</div></div>
      </div>
      <div class="card device-card" id="card-tv">
        <div class="device-head">
          <div class="device-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="13" rx="2"/><polyline points="17 2 12 7 7 2"/></svg></div>
          <label class="switch"><input type="checkbox" id="toggle-tv" onchange="toggleDeviceManual('tv', this.checked)"><span class="slider"></span></label>
        </div>
        <div><div class="device-name">Smart TV</div><div class="device-status" id="status-tv">OFF</div></div>
      </div>
      <div class="card device-card" id="card-kulkas">
        <div class="device-head">
          <div class="device-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="5" y1="10" x2="19" y2="10"/></svg></div>
          <label class="switch"><input type="checkbox" id="toggle-kulkas" onchange="toggleDeviceManual('kulkas', this.checked)"><span class="slider"></span></label>
        </div>
        <div><div class="device-name">Kulkas</div><div class="device-status" id="status-kulkas">OFF</div></div>
      </div>
      <div class="card device-card" id="card-ac">
        <div class="device-head">
          <div class="device-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 6h20v6H2z"/><path d="M6 12v3"/><path d="M10 12v3"/><path d="M14 12v3"/><path d="M18 12v3"/></svg></div>
          <label class="switch"><input type="checkbox" id="toggle-ac" onchange="toggleDeviceManual('ac', this.checked)"><span class="slider"></span></label>
        </div>
        <div><div class="device-name">AC Utama</div><div class="device-status" id="status-ac">OFF</div></div>
      </div>
      <div class="card device-card" id="card-mesin_cuci">
        <div class="device-head">
          <div class="device-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="2" width="18" height="20" rx="2"/><circle cx="12" cy="13" r="5"/></svg></div>
          <label class="switch"><input type="checkbox" id="toggle-mesin_cuci" onchange="toggleDeviceManual('mesin_cuci', this.checked)"><span class="slider"></span></label>
        </div>
        <div><div class="device-name">Mesin Cuci</div><div class="device-status" id="status-mesin_cuci">OFF</div></div>
      </div>
      <div class="card device-card" id="card-radio">
        <div class="device-head">
          <div class="device-icon"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="8" width="20" height="14" rx="2"/><path d="M6 8l10-6"/><circle cx="8" cy="15" r="2"/><circle cx="16" cy="15" r="2"/></svg></div>
          <label class="switch"><input type="checkbox" id="toggle-radio" onchange="toggleDeviceManual('radio', this.checked)"><span class="slider"></span></label>
        </div>
        <div><div class="device-name">Radio FM</div><div class="device-status" id="status-radio">OFF</div></div>
      </div>
    </div>
  </section>
</div>

<!-- Floating Dock -->
<div class="dock" id="dock" style="visibility:hidden">
  <button class="btn-talk" id="talk-btn">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" y1="19" x2="12" y2="22"/></svg>
    <span id="talk-btn-text">TEKAN UNTUK BICARA</span>
  </button>
  <button class="btn-interrupt" id="interrupt-btn">⏹ STOP AI</button>
</div>

<script>
/* ================= DOM ================= */
const $ = id => document.getElementById(id);
const bootScreen=$('boot-screen'), bootBtn=$('boot-btn');
const aiResponse=$('ai-response'), aiStatus=$('ai-status'), statusDot=$('status-dot');
const talkBtn=$('talk-btn'), talkBtnText=$('talk-btn-text'), interruptBtn=$('interrupt-btn');
const ttsStatus=$('tts-status'), visualizerWrapper=$('visualizer-wrapper');
const canvas=$('visualizer-canvas'), ctx=canvas.getContext('2d');
const activeDevicesCount=$('active-devices-count');
const orbStateText=$('orb-state-text'), orbStateSub=$('orb-state-sub');
const sensorStatus=$('sensor-iot-status');

const valSuhu=$('val-suhu'), valKelembapan=$('val-kelembapan'), valJarak=$('val-jarak');

/* ================= State & Endpoints ================= */
let isSystemActive=false, isAiSpeaking=false, currentState='STANDBY';

const URL_PERANGKAT='http://localhost:5000/status_perangkat';
const URL_LINGKUNGAN='http://localhost:5000/status_lingkungan';
const n8nWebhookUrl='http://localhost:2345/webhook-test/nayzzu-control';

const deviceStates={lampu:false,tv:false,kulkas:false,ac:false,mesin_cuci:false,radio:false};

function esc(s){return String(s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));}

function getSessionId(){
  let sid=sessionStorage.getItem('nayzzu_session_id');
  if(!sid){sid='nayzzu_'+Math.random().toString(36).substring(2,9)+'_'+Date.now();sessionStorage.setItem('nayzzu_session_id',sid);}
  return sid;
}

/* Clock */
setInterval(()=>{$('clock').innerText=new Date().toLocaleTimeString('id-ID',{hour12:false});},1000);

/* ================= BOOT SEQUENCE ================= */
(function bootSequence(){
  const bc=$('boot-canvas'), bctx=bc.getContext('2d');
  let W,H,pts=[],raf;
  function size(){W=bc.width=innerWidth;H=bc.height=innerHeight;
    pts=Array.from({length:Math.min(90,Math.floor(W*H/16000))},()=>({x:Math.random()*W,y:Math.random()*H,vx:(Math.random()-.5)*.4,vy:(Math.random()-.5)*.4,r:Math.random()*1.8+.6}));}
  size(); addEventListener('resize',size);
  function draw(){
    raf=requestAnimationFrame(draw);
    bctx.clearRect(0,0,W,H);
    for(const p of pts){
      p.x+=p.vx;p.y+=p.vy;
      if(p.x<0||p.x>W)p.vx*=-1; if(p.y<0||p.y>H)p.vy*=-1;
      bctx.beginPath();bctx.arc(p.x,p.y,p.r,0,Math.PI*2);bctx.fillStyle='rgba(196,160,255,.75)';bctx.fill();
    }
    for(let i=0;i<pts.length;i++)for(let j=i+1;j<pts.length;j++){
      const dx=pts[i].x-pts[j].x,dy=pts[i].y-pts[j].y,d=Math.hypot(dx,dy);
      if(d<130){bctx.beginPath();bctx.moveTo(pts[i].x,pts[i].y);bctx.lineTo(pts[j].x,pts[j].y);
        bctx.strokeStyle=`rgba(167,139,250,${.22*(1-d/130)})`;bctx.lineWidth=1;bctx.stroke();}
    }
  }
  draw();
  window.stopBootCanvas=()=>cancelAnimationFrame(raf);

  const steps=[
    ['Memuat inti Nayzzu AI','CORE'],
    ['Menghubungkan sensor suhu & kelembapan','SENSOR'],
    ['Kalibrasi sensor jarak ultrasonik','SENSOR'],
    ['Menyiapkan modul pengenalan suara (id-ID)','VOICE'],
    ['Menyiapkan mesin text-to-speech','TTS'],
    ['Menghubungkan webhook n8n','AI-CORE'],
    ['Memuat panel kontrol perangkat','DEVICE'],
    ['Semua sistem siap','READY']
  ];
  const consoleEl=$('boot-console'), fill=$('boot-fill'), pct=$('boot-percent'), phase=$('boot-phase'), hint=$('boot-hint');
  let i=0;
  function next(){
    if(i>=steps.length){
      phase.innerText='SISTEM SIAP';hint.innerText='KLIK TOMBOL UNTUK MEMULAI';
      bootBtn.classList.add('ready');return;
    }
    const [msg,tag]=steps[i];
    const line=document.createElement('div');line.className='boot-line';
    line.innerHTML=`<span class="tag">[${tag}]</span> ${msg} <span class="ok">✓</span>`;
    consoleEl.appendChild(line);
    while(consoleEl.children.length>6)consoleEl.removeChild(consoleEl.firstChild);
    i++;
    const p=Math.round(i/steps.length*100);
    fill.style.width=p+'%';pct.innerText=p+'%';phase.innerText=tag;
    setTimeout(next,260+Math.random()*320);
  }
  setTimeout(next,500);
})();

/* ================= CHARTS ================= */
Chart.defaults.color='#9d8fc2';
Chart.defaults.font.family="'JetBrains Mono', monospace";

function gradient(ctxEl,color){
  const g=ctxEl.createLinearGradient(0,0,0,230);
  g.addColorStop(0,color+'66');g.addColorStop(1,color+'00');return g;
}
function makeDataset(label,color,fill){
  return {label,data:[],borderColor:color,borderWidth:2.2,tension:.4,pointRadius:0,pointHoverRadius:5,
    pointBackgroundColor:color,fill:!!fill,
    backgroundColor:fill?(c)=>gradient(c.chart.ctx,color):'transparent'};
}
const chartOptions={
  responsive:true,maintainAspectRatio:false,animation:false,
  interaction:{mode:'index',intersect:false},
  scales:{
    x:{ticks:{color:'#7d6fa3',font:{size:9},maxRotation:0,autoSkip:true,maxTicksLimit:5},grid:{display:false},border:{display:false}},
    y:{ticks:{color:'#7d6fa3',font:{size:10}},grid:{color:'rgba(167,139,250,.08)'},border:{display:false}}
  },
  plugins:{
    legend:{labels:{color:'#c4b0ff',font:{size:10},boxWidth:10,boxHeight:10,usePointStyle:true,pointStyle:'circle'}},
    tooltip:{backgroundColor:'rgba(18,10,38,.95)',borderColor:'rgba(167,139,250,.4)',borderWidth:1,titleColor:'#fff',bodyColor:'#ddd0ff',padding:10,cornerRadius:10}
  }
};
const chartSuhuHum=new Chart($('chartSuhuHum'),{type:'line',data:{labels:[],datasets:[makeDataset('Suhu (°C)','#e879f9',true),makeDataset('Kelembapan (%)','#818cf8',false)]},options:chartOptions});
const chartJarak=new Chart($('chartJarak'),{type:'line',data:{labels:[],datasets:[makeDataset('Jarak (cm)','#a78bfa',true)]},options:chartOptions});

function addChartData(chart,label,arr){
  chart.data.labels.push(label);
  if(chart.data.labels.length>15)chart.data.labels.shift();
  arr.forEach((v,i)=>{
    chart.data.datasets[i].data.push(v);
    if(chart.data.datasets[i].data.length>15)chart.data.datasets[i].data.shift();
  });
  chart.update();
}

/* ================= DATA FETCH ================= */
function setMeter(id,val,max){$(id).style.width=Math.max(0,Math.min(100,val/max*100))+'%';}

async function fetchTelemetryData(){
  try{
    const r=await fetch(URL_LINGKUNGAN);
    if(!r.ok)throw 0;
    const data=await r.json();
    const s=typeof data.suhu==='number'?data.suhu:parseFloat(data.suhu||0);
    const h=typeof data.kelembapan==='number'?data.kelembapan:parseFloat(data.kelembapan||0);
    const j=typeof data.jarak==='number'?data.jarak:parseFloat(data.jarak||0);
    valSuhu.innerText=s.toFixed(1);valKelembapan.innerText=h.toFixed(1);valJarak.innerText=j.toFixed(1);
    setMeter('meter-suhu',s,50);setMeter('meter-hum',h,100);setMeter('meter-jarak',j,400);
    sensorStatus.innerText='LIVE FEED';
    const t=new Date().toLocaleTimeString('id-ID',{hour12:false});
    addChartData(chartSuhuHum,t,[s,h]);addChartData(chartJarak,t,[j]);
  }catch(err){sensorStatus.innerText='OFFLINE';}
}

async function fetchPerangkatData(){
  try{
    const r=await fetch(URL_PERANGKAT);
    if(!r.ok)return;
    const devices=await r.json();
    if(devices&&typeof devices==='object'){
      Object.keys(devices).forEach(k=>{
        setDeviceState(k,(devices[k]==="on"||devices[k]===true||devices[k]===1));
      });
    }
  }catch(err){}
}

setInterval(fetchTelemetryData,1000);
setInterval(fetchPerangkatData,1000);

/* ================= DEVICES ================= */
function setDeviceState(id,state){
  if(!deviceStates.hasOwnProperty(id))return;
  deviceStates[id]=Boolean(state);
  const card=$(`card-${id}`),tog=$(`toggle-${id}`),st=$(`status-${id}`);
  if(card&&tog&&st){
    tog.checked=deviceStates[id];
    card.classList.toggle('active',deviceStates[id]);
    st.innerText=deviceStates[id]?'ON':'OFF';
  }
  updateActiveDevicesCounter();
}
function toggleDeviceManual(id,checked){
  setDeviceState(id,checked);
  fetch(URL_PERANGKAT,{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({device:id,state:checked})}).catch(()=>{});
}
function updateActiveDevicesCounter(){
  activeDevicesCount.innerText=`${Object.values(deviceStates).filter(Boolean).length}/6 AKTIF`;
}

function processN8nOutputCommands(data){
  if(!data)return;
  if(Array.isArray(data)){data.forEach(processN8nOutputCommands);return;}
  if(typeof data!=='object')return;
  if(data.device&&typeof data.state!=='undefined'){
    const id=String(data.device).toLowerCase().trim();
    setDeviceState(id,(data.state===true||data.state==="true"||data.state===1||String(data.state).toLowerCase()==="on"));
  }
  if(data.devices&&typeof data.devices==='object'){
    Object.keys(data.devices).forEach(k=>{
      const v=data.devices[k];
      setDeviceState(String(k).toLowerCase().trim(),(v===true||v==="true"||v===1||String(v).toLowerCase()==="on"));
    });
  }
}
function deepParseN8nResponse(input){
  let cur=input;
  for(let i=0;i<3;i++){
    if(typeof cur==='string'){
      try{cur=JSON.parse(cur.replace(/```json/gi,'').replace(/```/g,'').trim());}catch(e){break;}
    }else if(cur&&typeof cur==='object'&&!Array.isArray(cur)){
      const inner=cur.output||cur.message||cur.text||cur.body||cur.reply;
      if(typeof inner==='string'&&(inner.trim().startsWith('{')||inner.trim().startsWith('['))){
        try{cur=JSON.parse(inner.replace(/```json/gi,'').replace(/```/g,'').trim());}catch(e){}
      }
      break;
    }
  }
  return cur;
}

/* ================= ORB VISUALIZER ================= */
function resizeCanvas(){canvas.width=visualizerWrapper.clientWidth+120;canvas.height=visualizerWrapper.clientHeight+120;}
addEventListener('resize',resizeCanvas);resizeCanvas();

let ringAngle=0;
function renderVisualizer(){
  requestAnimationFrame(renderVisualizer);
  ctx.clearRect(0,0,canvas.width,canvas.height);
  const cx=canvas.width/2,cy=canvas.height/2;
  ringAngle+=.015;
  const waveCount=currentState==='LISTENING'?5:currentState==='THINKING'?8:currentState==='RESPONDING'?6:3;
  const amp=currentState==='STANDBY'?5:15;
  for(let i=0;i<waveCount;i++){
    ctx.beginPath();
    const off=(i*Math.PI*2)/waveCount;
    const r=62+Math.sin(ringAngle*2+off)*amp;
    ctx.arc(cx,cy,r+i*8,0,Math.PI*2);
    ctx.lineWidth=1.5;
    const a=.5-i*.07;
    ctx.strokeStyle=currentState==='LISTENING'?`rgba(232,121,249,${a})`:
                    currentState==='THINKING'?`rgba(129,140,248,${a})`:
                    currentState==='RESPONDING'?`rgba(167,139,250,${a+.05})`:
                    `rgba(139,92,246,${Math.max(.06,.3-i*.06)})`;
    ctx.stroke();
  }
}
renderVisualizer();

/* ================= SPEECH ================= */
const SR=window.SpeechRecognition||window.webkitSpeechRecognition;
let recognition=SR?new SR():null;
if(recognition){recognition.lang='id-ID';recognition.interimResults=false;}

const synth=window.speechSynthesis;
function getBestVoice(){
  const v=synth.getVoices();
  return v.find(x=>x.lang.includes('id')&&(x.name.includes('Online')||x.name.includes('Natural')||x.name.includes('Google')))||v.find(x=>x.lang.includes('id'))||v[0];
}

const STATE_COPY={
  STANDBY:['Siap Mendengarkan','Tekan tombol mikrofon di bawah lalu ucapkan perintah untuk mengontrol perangkat.'],
  LISTENING:['Mendengarkan...','Silakan ucapkan perintah Anda sekarang.'],
  THINKING:['Memproses...','Nayzzu AI sedang menganalisis perintah Anda.'],
  RESPONDING:['Menjawab','Nayzzu AI sedang berbicara. Tekan Stop untuk menghentikan.']
};

function updateState(state){
  currentState=state;
  aiStatus.innerText=state;
  visualizerWrapper.className='visualizer-wrapper';
  const copy=STATE_COPY[state]||STATE_COPY.STANDBY;
  orbStateText.innerText=copy[0];orbStateSub.innerText=copy[1];
  talkBtn.classList.remove('recording');
  interruptBtn.style.display='none';
  talkBtnText.innerText='TEKAN UNTUK BICARA';
  if(state==='LISTENING'){
    visualizerWrapper.classList.add('state-listening');
    statusDot.style.background='#e879f9';statusDot.style.boxShadow='0 0 12px #e879f9';
    talkBtnText.innerText='MENDENGARKAN...';talkBtn.classList.add('recording');
  }else if(state==='THINKING'){
    visualizerWrapper.classList.add('state-thinking');
    statusDot.style.background='#818cf8';statusDot.style.boxShadow='0 0 12px #818cf8';
    talkBtnText.innerText='MEMPROSES AI...';
  }else if(state==='RESPONDING'){
    visualizerWrapper.classList.add('state-responding');
    statusDot.style.background='#a78bfa';statusDot.style.boxShadow='0 0 12px #a78bfa';
    interruptBtn.style.display='block';
  }else{
    statusDot.style.background='#8b5cf6';statusDot.style.boxShadow='0 0 12px #a78bfa';
  }
}

/* Boot button -> enter app */
bootBtn.addEventListener('click',()=>{
  bootScreen.classList.add('leaving');
  setTimeout(()=>{bootScreen.style.display='none';if(window.stopBootCanvas)window.stopBootCanvas();},900);
  $('app').style.visibility='visible';
  $('dock').style.visibility='visible';
  isSystemActive=true;
  synth.resume();synth.cancel();
  const u=new SpeechSynthesisUtterance('Nayzzu AI Siap.');
  const v=getBestVoice();if(v)u.voice=v;
  synth.speak(u);
  aiResponse.innerHTML="<span style='color:var(--p-300)'>Nayzzu AI Siap. Berikan perintah suara atau gunakan kontrol sakelar.</span>";
  updateState('STANDBY');
  resizeCanvas();
});

talkBtn.addEventListener('click',()=>{
  if(!isSystemActive||currentState==='THINKING'||!recognition)return;
  if(isAiSpeaking){synth.cancel();isAiSpeaking=false;}
  try{
    recognition.stop();
    setTimeout(()=>{recognition.start();updateState('LISTENING');},100);
  }catch(e){}
});

interruptBtn.addEventListener('click',()=>{
  if(isAiSpeaking){
    synth.cancel();isAiSpeaking=false;
    ttsStatus.innerText='TTS: DIHENTIKAN';
    updateState('STANDBY');
  }
});

if(recognition){
  recognition.onresult=async(event)=>{
    const transcript=event.results[0][0].transcript;
    updateState('THINKING');
    aiResponse.innerHTML=`<span class="msg-label msg-user">USER</span><br>${esc(transcript)}<br><br><span style="color:var(--p-400)">Mengirim perintah ke AI Core...</span>`;
    try{
      const response=await fetch(n8nWebhookUrl,{
        method:'POST',headers:{'Content-Type':'application/json'},
        body:JSON.stringify({message:transcript,chatInput:transcript,session_id:getSessionId(),current_device_states:deviceStates})
      });
      if(!response.ok)throw new Error("Gagal terhubung ke n8n.");
      const data=await response.json();
      await handleAiResponse(transcript,data);
    }catch(error){
      aiResponse.innerHTML+=`<br><br><span class="msg-err">Error: ${esc(error.message)}</span>`;
      updateState('STANDBY');
    }
  };
  recognition.onerror=()=>updateState('STANDBY');
}

async function handleAiResponse(userText,rawData){
  const parsed=deepParseN8nResponse(rawData);
  processN8nOutputCommands(parsed);

  if(parsed&&typeof parsed==='object'&&(parsed.device||parsed.devices)){
    try{
      await fetch(URL_PERANGKAT,{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(parsed)});
      await fetchPerangkatData();
    }catch(err){}
  }

  let aiText="Perintah berhasil diproses.";
  if(parsed&&typeof parsed==='object'){
    aiText=parsed.reply||parsed.message||parsed.output||parsed.text||aiText;
  }else if(typeof parsed==='string'){aiText=parsed;}

  const cleanText=String(aiText).replace(/[*#_`~()><\-]/g,' ');
  updateState('RESPONDING');
  aiResponse.innerHTML=`<span class="msg-label msg-user">USER</span><br>${esc(userText)}<br><br><span class="msg-label msg-ai">NAYZZU AI</span><br>${esc(cleanText)}`;
  aiResponse.scrollTop=aiResponse.scrollHeight;
  speakText(cleanText);
}

function speakText(text){
  isAiSpeaking=true;
  synth.resume();synth.cancel();
  const chunks=text.match(/[^.!?]+[.!?]+|\s*[^.!?]+$/g)||[text];
  let index=0;
  function next(){
    if(index>=chunks.length){
      isAiSpeaking=false;ttsStatus.innerText='TTS: IDLE';updateState('STANDBY');return;
    }
    const u=new SpeechSynthesisUtterance(chunks[index]);
    const v=getBestVoice();if(v)u.voice=v;
    u.rate=.95;
    u.onstart=()=>{ttsStatus.innerText=`TTS: READING (${index+1}/${chunks.length})`;};
    u.onend=()=>{index++;next();};
    u.onerror=()=>{index++;next();};
    synth.speak(u);
  }
  next();
}
</script>
</body>
</html>