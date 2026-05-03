<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EduPlayHub</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700|fraunces:600" rel="stylesheet" />
    <style>
        :root {
            --bg: #0a0b12;
            --panel: rgba(14, 17, 27, 0.6);
            --panel-strong: rgba(14, 17, 27, 0.92);
            --stroke: rgba(255, 255, 255, 0.12);
            --text: #eef2ff;
            --muted: #a1a8cc;
            --blue: #4da3ff;
            --purple: #8b5bff;
            --orange: #ff7a3c;
            --glow: 0 0 70px rgba(77, 163, 255, 0.4);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Space Grotesk", "Segoe UI", sans-serif;
            background:
                radial-gradient(circle at 15% 12%, rgba(77, 163, 255, 0.3), transparent 42%),
                radial-gradient(circle at 88% 8%, rgba(255, 122, 60, 0.25), transparent 40%),
                radial-gradient(circle at 70% 70%, rgba(139, 91, 255, 0.3), transparent 45%),
                var(--bg);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .page {
            max-width: 1220px;
            margin: 0 auto;
            padding: 32px 20px 90px;
        }

        .nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 26px;
            border-radius: 999px;
            background: var(--panel);
            border: 1px solid var(--stroke);
            backdrop-filter: blur(22px);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: "Fraunces", serif;
            font-size: 20px;
        }

        .brand-mark {
            width: 38px;
            height: 38px;
            border-radius: 14px;
            background: linear-gradient(145deg, var(--blue), var(--purple));
            box-shadow: var(--glow);
        }

        .nav-links {
            display: flex;
            gap: 18px;
            font-size: 14px;
            color: var(--muted);
        }

        .nav-links a {
            color: inherit;
            text-decoration: none;
            padding: 6px 10px;
            border-radius: 999px;
            transition: color 0.2s ease, background 0.2s ease;
        }

        .nav-links a:hover {
            color: var(--text);
            background: rgba(255, 255, 255, 0.08);
        }

        .nav-cta {
            display: flex;
            gap: 12px;
        }

        .btn {
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 14px;
        }

        .btn-outline {
            color: var(--text);
            border: 1px solid var(--stroke);
            background: transparent;
        }

        .btn-primary {
            color: #0b0d14;
            background: linear-gradient(135deg, var(--blue), var(--orange));
            box-shadow: 0 18px 40px rgba(77, 163, 255, 0.25);
        }

        .hero {
            margin-top: 56px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 36px;
            align-items: center;
        }

        .hero-copy {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 16px;
            border-radius: 999px;
            background: rgba(77, 163, 255, 0.15);
            color: #cfe6ff;
            font-size: 12px;
            letter-spacing: 0.6px;
            text-transform: uppercase;
        }

        .title {
            font-size: clamp(34px, 4vw, 54px);
            line-height: 1.1;
            font-weight: 700;
        }

        .subtitle {
            font-size: 18px;
            color: var(--muted);
            max-width: 520px;
            line-height: 1.6;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            align-items: center;
        }

        .meta {
            display: flex;
            gap: 20px;
            color: var(--muted);
            font-size: 14px;
        }

        .scene-wrap {
            position: relative;
            height: 480px;
            border-radius: 32px;
            background: var(--panel-strong);
            border: 1px solid var(--stroke);
            overflow: hidden;
            backdrop-filter: blur(30px);
            perspective: 1000px;
        }

        .scene {
            position: absolute;
            inset: 0;
            transform-style: preserve-3d;
            transition: transform 0.25s ease;
        }

        .scene::before {
            content: "";
            position: absolute;
            inset: -20% 55% -20% -20%;
            background: radial-gradient(circle, rgba(77, 163, 255, 0.45), transparent 70%);
            filter: blur(12px);
        }

        .scene::after {
            content: "";
            position: absolute;
            inset: -20% -20% -20% 45%;
            background: radial-gradient(circle, rgba(255, 122, 60, 0.45), transparent 70%);
            filter: blur(14px);
        }

        .core {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 170px;
            height: 170px;
            transform: translate(-50%, -50%) translateZ(70px);
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.45), rgba(139, 91, 255, 0.15));
            border: 1px solid rgba(255, 255, 255, 0.22);
            box-shadow: 0 0 90px rgba(139, 91, 255, 0.55), inset 0 0 40px rgba(255, 255, 255, 0.2);
        }

        .core::after {
            content: "";
            position: absolute;
            inset: 18px;
            border-radius: 50%;
            border: 1px dashed rgba(255, 255, 255, 0.3);
            animation: spin 18s linear infinite;
        }

        .orbit {
            position: absolute;
            inset: 12% 8%;
            border-radius: 40%;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transform-style: preserve-3d;
        }

        .orbit.left {
            transform: rotateY(24deg) rotateZ(-6deg);
            border-color: rgba(77, 163, 255, 0.2);
        }

        .orbit.right {
            transform: rotateY(-24deg) rotateZ(6deg);
            border-color: rgba(255, 122, 60, 0.2);
        }

        .orbit-anim {
            position: absolute;
            inset: 0;
            animation: orbit 18s linear infinite;
            transform-style: preserve-3d;
        }

        .object {
            position: absolute;
            padding: 12px 16px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.16);
            background: rgba(255, 255, 255, 0.08);
            color: #e8edff;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.35);
            transform-style: preserve-3d;
            transition: transform 0.3s ease;
        }

        .object:hover {
            transform: translateZ(30px) translateY(-4px);
        }

        .badge {
            width: 28px;
            height: 28px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: #0b0d14;
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.9), rgba(196, 210, 255, 0.8));
        }

        .object.academic {
            box-shadow: 0 20px 35px rgba(77, 163, 255, 0.2);
        }

        .object.entertain {
            box-shadow: 0 20px 35px rgba(255, 122, 60, 0.2);
        }

        .trail {
            position: absolute;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            filter: blur(25px);
            opacity: 0.7;
            animation: pulse 7s ease-in-out infinite;
        }

        .trail.blue { left: 18%; bottom: 12%; background: rgba(77, 163, 255, 0.55); }
        .trail.purple { right: 15%; top: 12%; background: rgba(139, 91, 255, 0.55); }
        .trail.orange { right: 25%; bottom: 16%; background: rgba(255, 122, 60, 0.5); }

        .particles {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0.4;
            animation: drift 10s linear infinite;
        }

        .particle:nth-child(odd) { background: rgba(77, 163, 255, 0.7); }
        .particle:nth-child(3n) { background: rgba(255, 122, 60, 0.6); }

        @keyframes orbit {
            from { transform: rotateZ(0deg); }
            to { transform: rotateZ(360deg); }
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.6; }
            50% { transform: scale(1.15); opacity: 0.9; }
        }

        @keyframes drift {
            0% { transform: translateY(0) translateX(0); opacity: 0.3; }
            50% { transform: translateY(-40px) translateX(20px); opacity: 0.7; }
            100% { transform: translateY(-80px) translateX(0); opacity: 0.1; }
        }

        @media (max-width: 820px) {
            .nav {
                flex-direction: column;
                gap: 14px;
                border-radius: 24px;
            }

            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }

            .meta {
                flex-direction: column;
                gap: 6px;
            }

            .scene-wrap {
                height: 380px;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <nav class="nav">
            <div class="brand">
                <div class="brand-mark"></div>
                EduPlayHub
            </div>
            <div class="nav-links">
                <a href="{{ route('welcome') }}">Home</a>
                <a href="{{ route('catalog') }}">Rentals</a>
                <a href="{{ route('catalog') }}">Categories</a>
                <a href="{{ route('welcome') }}#about">About</a>
                <a href="{{ route('login') }}">Login</a>
            </div>
            <div class="nav-cta">
                <a class="btn btn-outline" href="{{ route('register') }}">Get Started</a>
                <a class="btn btn-primary" href="{{ route('catalog') }}">Explore Rentals</a>
            </div>
        </nav>

        <section class="hero">
            <div class="hero-copy">
                <div class="kicker">Study meets fun</div>
                <h1 class="title">Study Smart. Play Hard. All in One Place.</h1>
                <p class="subtitle">Rent academic and entertainment gear easily with flexible plans. From lab-ready tech to immersive play, EduPlayHub keeps everything in one cinematic ecosystem.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="{{ route('catalog') }}">Explore Rentals</a>
                    <a class="btn btn-outline" href="{{ route('register') }}">Get Started</a>
                </div>
                <div class="meta">
                    <span>Flexible rental plans</span>
                    <span>Verified equipment</span>
                    <span>Fast delivery in campus cities</span>
                </div>
            </div>

            <div class="scene-wrap" id="sceneWrap">
                <div class="trail blue"></div>
                <div class="trail purple"></div>
                <div class="trail orange"></div>
                <div class="particles">
                    <span class="particle" style="left:12%;top:18%;animation-delay:-2s"></span>
                    <span class="particle" style="left:24%;top:60%;animation-delay:-4s"></span>
                    <span class="particle" style="left:45%;top:30%;animation-delay:-6s"></span>
                    <span class="particle" style="left:62%;top:70%;animation-delay:-3s"></span>
                    <span class="particle" style="left:78%;top:40%;animation-delay:-5s"></span>
                    <span class="particle" style="left:86%;top:20%;animation-delay:-1s"></span>
                </div>
                <div class="scene" id="scene">
                    <div class="core"></div>
                    <div class="orbit left">
                        <div class="orbit-anim">
                            <div class="object academic" style="left:8%;top:18%;transform:translateZ(40px);">
                                <span class="badge">GP</span> GoPro Camera
                            </div>
                            <div class="object academic" style="left:12%;bottom:18%;transform:translateZ(30px);">
                                <span class="badge">LT</span> Laptop Lab
                            </div>
                            <div class="object academic" style="left:32%;top:55%;transform:translateZ(20px);">
                                <span class="badge">DT</span> Data Charts
                            </div>
                        </div>
                    </div>
                    <div class="orbit right">
                        <div class="orbit-anim" style="animation-direction:reverse;">
                            <div class="object entertain" style="right:10%;top:18%;transform:translateZ(40px);">
                                <span class="badge">PS</span> PlayStation Controller
                            </div>
                            <div class="object entertain" style="right:18%;bottom:18%;transform:translateZ(30px);">
                                <span class="badge">VR</span> VR Headset
                            </div>
                            <div class="object entertain" style="right:30%;top:56%;transform:translateZ(20px);">
                                <span class="badge">GX</span> Gaming Console
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        const sceneWrap = document.getElementById('sceneWrap');
        const scene = document.getElementById('scene');

        if (sceneWrap && scene) {
            sceneWrap.addEventListener('mousemove', (event) => {
                const rect = sceneWrap.getBoundingClientRect();
                const x = (event.clientX - rect.left) / rect.width - 0.5;
                const y = (event.clientY - rect.top) / rect.height - 0.5;
                const rotateX = (-y * 8).toFixed(2);
                const rotateY = (x * 10).toFixed(2);
                scene.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
            });

            sceneWrap.addEventListener('mouseleave', () => {
                scene.style.transform = 'rotateX(0deg) rotateY(0deg)';
            });
        }
    </script>
</body>
</html>