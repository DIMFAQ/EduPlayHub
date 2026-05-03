<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduPlayHub - One-Stop Rental Platform</title>
    {{-- Three.js r158 sebagai module — BUKAN three.min.js karena GLTFLoader butuh module system --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;600;700;900&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Exo 2', sans-serif;
            background: #050a14;
            color: #e0e0e0;
            overflow-x: hidden;
        <!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width,initial-scale=1">
          <title>EduPlayHub — One‑Stop Rental Platform</title>
          <script src="https://unpkg.com/three@r158/build/three.min.js"></script>
          <script src="https://cdn.tailwindcss.com"></script>
          <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;600;700;900&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

          <style>
            :root{--bg:#050a14;--accent:#4DF0C5;--accent2:#7C50FF;--amber:#FFB450;--muted:rgba(224,224,224,0.65)}
            html,body{height:100%}
            body{margin:0;background:var(--bg);color:#e6eef8;font-family:'Exo 2',system-ui,Arial;font-size:16px}
            /* full-screen WebGL canvas */
            #three-canvas{position:fixed;inset:0;width:100%;height:100%;z-index:0;display:block}
            /* UI layer */
            .ui{position:relative;z-index:10}
            nav.bg-glass{position:fixed;top:16px;left:50%;transform:translateX(-50%);width:calc(100% - 48px);max-width:1200px;border-radius:14px;padding:12px 20px;backdrop-filter:blur(12px);background:rgba(255,255,255,0.03);border:1px solid rgba(77,240,197,0.06);display:flex;align-items:center;justify-content:space-between;gap:12px}
            .logo{font-weight:900;font-size:1.125rem;letter-spacing:-0.01em}
            .logo .play{color:var(--accent)}
            .nav-links{display:none;gap:20px}
            .nav-links a{color:var(--muted);text-decoration:none;font-weight:600}
            .nav-cta{display:flex;gap:10px}
            .btn-primary{background:linear-gradient(90deg,var(--accent),#2bd0b0);color:#041018;padding:10px 16px;border-radius:12px;font-weight:700}
            .btn-outline{border:1px solid rgba(77,240,197,0.12);padding:9px 14px;border-radius:12px;color:var(--accent);background:transparent}

            /* Hero */
            .hero{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:6rem 1.25rem 4rem;position:relative}
            .hero-inner{max-width:1100px;display:grid;grid-template-columns:1fr 540px;gap:40px;align-items:center}
            @media(max-width:980px){.hero-inner{grid-template-columns:1fr;gap:28px}.nav-links{display:none}}
            .tagline{font-family:'Space Mono',monospace;letter-spacing:0.28em;color:var(--accent);font-size:0.85rem}
            .title{font-weight:900;font-size:clamp(40px,8vw,86px);line-height:0.95;margin:8px 0}
            .title .play{color:var(--accent)}
            .subtitle{color:var(--muted);font-size:clamp(15px,2vw,18px);max-width:52rem}
            .pills{display:flex;gap:12px;margin-top:18px}
            .pill{padding:8px 14px;border-radius:999px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.04);color:var(--accent);font-weight:600}

            /* Features cards */
            .features{padding:60px 1.25rem 120px}
            .cards{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:1fr;gap:18px}
            @media(min-width:768px){.cards{grid-template-columns:repeat(3,1fr)}}
            .card{backdrop-filter:blur(12px);background:rgba(255,255,255,0.03);border:1px solid rgba(77,240,197,0.06);padding:28px;border-radius:14px;transition:transform .26s,box-shadow .26s}
            .card:hover{transform:translateY(-10px);box-shadow:0 20px 60px rgba(77,240,197,0.08),0 6px 20px rgba(7,11,20,0.6)}
            .icon-wrap{width:56px;height:56px;border-radius:12px;background:linear-gradient(135deg,rgba(77,240,197,0.06),rgba(124,80,255,0.06));display:flex;align-items:center;justify-content:center;margin-bottom:12px}
            .card h3{font-size:1.125rem;margin-bottom:8px}
            .card p{color:var(--muted);line-height:1.6}

            /* small animations */
            .fade-up{opacity:0;transform:translateY(18px);animation:fadeUp .8s forwards}
            .fade-up.delay-1{animation-delay:0.15s}
            .fade-up.delay-2{animation-delay:0.3s}
            .fade-up.delay-3{animation-delay:0.45s}
            @keyframes fadeUp{to{opacity:1;transform:none}}

            /* responsive nav menu */
            .menu-btn{display:flex;align-items:center;gap:8px;cursor:pointer}
            .menu-lines{width:22px;height:2px;background:#dfeff0;border-radius:2px}
            @media(min-width:768px){.nav-links{display:flex}}
          </style>
        </head>
        <body>

          <!-- Three.js canvas (full-screen) -->
          <canvas id="three-canvas"></canvas>
          <div class="page-overlay" style="position:fixed;inset:0;pointer-events:none;z-index:1;background:linear-gradient(180deg,rgba(7,10,18,0.0) 0%, rgba(5,8,14,0.6) 65%);"></div>

          <div class="ui">
            <nav class="bg-glass">
              <div style="display:flex;align-items:center;gap:14px">
                <div class="logo">Edu<span class="play">Play</span>Hub</div>
              </div>
              <div style="display:flex;align-items:center;gap:18px">
                <div class="nav-links" id="navLinks">
                  <a href="#academic">Academic Gear</a>
                  <a href="#fun">Fun Gear</a>
                  <a href="#market">Second Market</a>
                </div>
                <div class="nav-cta">
                  <a href="{{ route('login') }}" class="nav-login">Login</a>
                  <a href="{{ route('register') }}" class="btn-outline">Daftar</a>
                  <a href="{{ route('register') }}" class="btn-primary">Mulai Sewa</a>
                </div>
                <div class="menu-btn" id="menuBtn" style="display:none">
                  <div class="menu-lines"></div>
                </div>
              </div>
            </nav>

            <main class="hero">
              <div class="hero-inner" style="width:100%">
                <div class="hero-copy fade-up delay-1">
                  <div class="tagline">ONE‑STOP RENTAL PLATFORM</div>
                  <h1 class="title"><span>Edu</span><span class="play">Play</span><span>Hub</span></h1>
                  <p class="subtitle">Sewa alat akademis & hiburan dalam satu platform. Dari GoPro untuk riset dataset hingga PS4 untuk break time — semua tersedia dengan harga transparan.</p>
                  <div style="margin-top:20px" class="fade-up delay-2">
                    <a href="{{ route('register') }}" class="btn-primary" style="margin-right:10px">Mulai Sewa →</a>
                    <a href="{{ route('catalog') }}" class="btn-outline">Lihat Katalog</a>
                  </div>
                  <div class="pills fade-up delay-3" style="margin-top:18px">
                    <span class="pill">Academic Gear</span>
                    <span class="pill">Fun Gear</span>
                    <span class="pill">Second Market</span>
                  </div>
                </div>

                <div class="scene-panel" style="width:100%;max-width:560px;margin-left:auto">
                  <!-- placeholder; rays rendered by shader on canvas behind UI -->
                </div>
              </div>
            </main>

            <section class="features">
              <div class="cards">
                <div class="card fade-up delay-1">
                  <div class="icon-wrap">
                    <!-- camera / GoPro -->
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="28" height="28"><rect x="2" y="7" width="20" height="13" rx="2"/><circle cx="12" cy="13" r="3"/></svg>
                  </div>
                  <h3>Academic Gear</h3>
                  <p>Teknologi untuk riset & tugas kuliah — GoPro, kamera, alat ukur, dan peralatan lab berkualitas tinggi.</p>
                </div>

                <div class="card fade-up delay-2">
                  <div class="icon-wrap">
                    <!-- controller -->
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="28" height="28"><path d="M6 6h12v6a6 6 0 0 1-12 0z"/></svg>
                  </div>
                  <h3>Fun Gear</h3>
                  <p>Hiburan premium saat butuh rehat — PS4, Nintendo Switch, VR headset, dan konsol gaming lainnya.</p>
                </div>

                <div class="card fade-up delay-3">
                  <div class="icon-wrap">
                    <!-- tag/price -->
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="28" height="28"><path d="M20 10v8a2 2 0 0 1-2 2h-8l-8-8 8-8h8a2 2 0 0 1 2 2z"/></svg>
                  </div>
                  <h3>Second Market</h3>
                  <p>Beli second berkualitas dengan harga transparan — peralatan terverifikasi & aman.</p>
                </div>
              </div>
            </section>

            <footer style="text-align:center;padding:28px;color:rgba(255,255,255,0.45)">Built for EduPlayHub • <a href="#" style="color:var(--accent)">Learn more</a></footer>
          </div>

          <!-- Inline Three.js + shader code -->
          <script>
          // Setup three.js full-screen quad with raymarching shader
          const canvas = document.getElementById('three-canvas');
          const renderer = new THREE.WebGLRenderer({canvas: canvas, antialias: true});
          renderer.setPixelRatio(window.devicePixelRatio || 1);
          renderer.setSize(window.innerWidth, window.innerHeight);

          const camera = new THREE.OrthographicCamera(-1,1,1,-1,0,1);
          const scene = new THREE.Scene();

          const uniforms = {
            iTime: { value: 0 },
            iResolution: { value: new THREE.Vector3(window.innerWidth, window.innerHeight, 1) },
            iMouse: { value: new THREE.Vector2(0,0) }
          };

          const vertex = `
            varying vec2 vUv;
            void main(){ vUv = uv; gl_Position = vec4(position,1.0); }
          `;

          const fragment = `
            precision highp float;
            varying vec2 vUv;
            uniform vec3 iResolution;
            uniform float iTime;
            uniform vec2 iMouse;

            // ---------- Helpers ----------
            float sdSphere(vec3 p, float r){ return length(p)-r; }
            float sdBox(vec3 p, vec3 b){ vec3 q=abs(p)-b; return length(max(q,0.0))+min(max(q.x,max(q.y,q.z)),0.0); }
            float sdTorus(vec3 p, vec2 t){ vec2 q = vec2(length(p.xz)-t.x,p.y); return length(q)-t.y; }

            float opUnion(float d1, float d2){ return min(d1,d2); }
            float opSmoothUnion(float d1,float d2,float k){ float h = clamp(0.5+0.5*(d2-d1)/k,0.0,1.0); return mix(d2,d1,h)-k*h*(1.0-h); }

            mat3 rotY(float a){ float c=cos(a), s=sin(a); return mat3(c,0.,s, 0.,1.,0., -s,0.,c); }
            mat3 rotX(float a){ float c=cos(a), s=sin(a); return mat3(1.,0.,0., 0.,c,-s, 0.,s,c); }

            float hash(float n){ return fract(sin(n)*43758.5453123); }
            float noise(vec3 x){ return fract(sin(dot(x,vec3(12.989,78.233,45.164)))*43758.5453); }

            // Map SDF scene
            vec4 map(vec3 p){
              float t = iTime*0.6;
              vec3 sphP = p - vec3(0.0, 0.0, -6.0);
              float d = sdSphere(sphP, 2.2);
              float tor = sdTorus(p - vec3(0.0,0.0,-6.0), vec2(4.2,0.32));
              d = opSmoothUnion(d, tor, 0.6);
              vec3 bp = p - vec3(sin(t*0.6)*6.0, cos(t*0.4)*2.2, -8.0);
              float b1 = sdBox(bp, vec3(1.6,1.6,1.6));
              vec3 bp2 = p - vec3(cos(t*0.5)*-7.5, sin(t*0.3)*3.0, -10.0);
              float b2 = sdBox(bp2, vec3(1.2,1.2,1.2));
              d = opSmoothUnion(d, b1, 0.3);
              d = opSmoothUnion(d, b2, 0.4);
              for(int i=0;i<6;i++){
                float a = float(i)/6.0*6.28318 + t*0.8;
                vec3 op = vec3(cos(a)*9.0, sin(a*0.6)*3.2, -7.0 + sin(a*0.8)*1.6);
                float o = sdSphere(p - op, 0.35);
                d = min(d,o);
              }
              float floorDist = (p.y + 4.0);
              float sceneDist = min(d, floorDist);
              return vec4(sceneDist, d, 0.0, 0.0);
            }

            vec3 calcNormal(vec3 p){
              float e = 0.0008;
              vec3 n;
              n.x = map(p+vec3(e,0,0)).x - map(p-vec3(e,0,0)).x;
              n.y = map(p+vec3(0,e,0)).x - map(p-vec3(0,e,0)).x;
              n.z = map(p+vec3(0,0,e)).x - map(p-vec3(0,0,e)).x;
              return normalize(n);
            }

            float softShadow(vec3 ro, vec3 rd, float mint, float maxt, float k){
              float res=1.0; float t=mint;
              for(int i=0;i<32;i++){
                float h = map(ro+rd*t).x;
                if(h<0.001) return 0.0;
                res=min(res, k*h/t);
                t += clamp(h,0.02,0.2);
                if(t>maxt) break;
              }
              return clamp(res,0.0,1.0);
            }

            vec3 tonemap(vec3 c){ c = c / (c + vec3(1.0)); return pow(c, vec3(0.45)); }

            vec4 raymarch(vec3 ro, vec3 rd){
              float t=0.0; float d; vec3 col=vec3(0.0);
              for(int i=0;i<120;i++){
                vec3 pos = ro + rd * t;
                vec4 m = map(pos);
                d = m.x;
                if(d<0.001) {
                  vec3 n = calcNormal(pos);
                  vec3 lightDir = normalize(vec3(0.8,1.0,0.6));
                  float diff = max(dot(n,lightDir),0.0);
                  vec3 base = vec3(0.12,0.9,0.8);
                  if(length(pos - vec3(0.0,0.0,-6.0))<3.6) base = vec3(0.08,0.36,0.6);
                  float mixv = smoothstep(-6.0,6.0,pos.x);
                  base = mix(vec3(0.12,0.9,0.8), vec3(0.48,0.28,1.0), mixv);
                  float fres = pow(1.0 - max(dot(n, -rd), 0.0), 3.0);
                  float sh = softShadow(pos + n*0.01, lightDir, 0.01, 14.0, 32.0);
                  col = base * diff * sh + base * 0.08 * fres;
                  break;
                }
                t += clamp(d, 0.02, 0.6);
                if(t>60.0) break;
              }
              vec2 uv = vUv - 0.5;
              float neb = 0.2 * (0.5 + 0.5*sin(iTime*0.12 + uv.x*6.0));
              vec3 bg = mix(vec3(0.03,0.02,0.06), vec3(0.08,0.02,0.12), uv.y+0.5);
              float s = fract(sin(dot(vec2(vUv.x*1234.5,vUv.y*3456.7),vec2(12.9898,78.233))) * 43758.5453);
              bg += vec3(s*s*s)*0.6;
              vec3 final = tonemap(col + bg*neb);
              return vec4(final,1.0);
            }

            void main(){
              vec2 uv = (vUv * 2.0 - 1.0) * vec2(iResolution.x/iResolution.y, 1.0);
              vec3 ro = vec3(0.0,0.0,6.0);
              vec2 m = (iMouse.xy / iResolution.xy - 0.5) * 2.0;
              ro.x += m.x * 3.0; ro.y -= m.y * 2.0;
              vec3 rd = normalize(vec3(uv.x + m.x*0.35, uv.y + m.y*0.25, -1.8));
              vec4 color = raymarch(ro, rd);
              gl_FragColor = vec4(color.rgb,1.0);
            }
          `;

          const mat = new THREE.ShaderMaterial({
            vertexShader: vertex,
            fragmentShader: fragment,
            uniforms: uniforms
          });

          const quad = new THREE.Mesh(new THREE.PlaneGeometry(2,2), mat);
          scene.add(quad);

          window.addEventListener('mousemove', (e)=>{
            uniforms.iMouse.value.x = e.clientX;
            uniforms.iMouse.value.y = window.innerHeight - e.clientY;
          });

          window.addEventListener('resize', ()=>{
            renderer.setSize(window.innerWidth, window.innerHeight);
            uniforms.iResolution.value.set(window.innerWidth, window.innerHeight, 1);
          });

          const clock = new THREE.Clock();
          function render(){
            uniforms.iTime.value = clock.getElapsedTime();
            renderer.render(scene, camera);
            requestAnimationFrame(render);
          }
          render();

          const menuBtn = document.getElementById('menuBtn');
          const navLinksEl = document.getElementById('navLinks');
          menuBtn?.addEventListener('click', ()=> navLinksEl.classList.toggle('active'));
          </script>
        </body>
        </html>