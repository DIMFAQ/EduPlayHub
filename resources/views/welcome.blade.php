<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduPlayHub - One-Stop Rental Platform</title>
    <script src="https://unpkg.com/three@r158/build/three.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;600;700;900&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Exo 2', sans-serif;
            background: linear-gradient(135deg, #050a14 0%, #0a0f1f 100%);
            color: #e0e0e0;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* Canvas Background */
        canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: block;
            z-index: 0;
        }

        /* Overlay Gradient */
        .page-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(ellipse at center bottom, rgba(77, 240, 197, 0.05) 0%, rgba(5, 10, 20, 0.7) 70%);
            pointer-events: none;
            z-index: 1;
        }

        /* Content Layer */
        .content-layer {
            position: relative;
            z-index: 10;
            min-height: 100vh;
        }

        /* Navbar Styles */
        nav {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(77, 240, 197, 0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 100;
            animation: navFadeDown 0.8s ease-out;
        }

        @keyframes navFadeDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .nav-container {
            max-width: 7xl;
            margin: 0 auto;
            padding: 1.25rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 900;
            letter-spacing: -0.02em;
        }

        .logo span {
            color: #4DF0C5;
        }

        .nav-links {
            display: none;
            list-style: none;
            gap: 2rem;
        }

        .nav-links.active {
            display: flex;
            flex-direction: column;
            position: absolute;
            top: 70px;
            left: 0;
            right: 0;
            background: rgba(5, 10, 20, 0.95);
            backdrop-filter: blur(12px);
            padding: 2rem;
            gap: 1rem;
            border-bottom: 1px solid rgba(77, 240, 197, 0.1);
        }

        .nav-links a {
            color: #e0e0e0;
            text-decoration: none;
            font-size: 0.95rem;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: #4DF0C5;
        }

        .nav-auth {
            display: none;
            gap: 1rem;
            align-items: center;
        }

        .nav-auth.active {
            display: flex;
            flex-direction: column;
            width: 100%;
            position: absolute;
            top: 300px;
            left: 0;
            right: 0;
            padding: 0 2rem;
            gap: 0.5rem;
        }

        .nav-login {
            color: #e0e0e0;
            text-decoration: none;
            font-size: 0.95rem;
            transition: color 0.3s ease;
        }

        .nav-login:hover {
            color: #4DF0C5;
        }

        .nav-register {
            background: rgba(77, 240, 197, 0.1);
            border: 1px solid rgba(77, 240, 197, 0.3);
            color: #4DF0C5;
            padding: 0.5rem 1.25rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            text-align: center;
        }

        .nav-register:hover {
            background: rgba(77, 240, 197, 0.2);
            border-color: rgba(77, 240, 197, 0.5);
        }

        .hamburger {
            display: flex;
            flex-direction: column;
            gap: 0.375rem;
            cursor: pointer;
        }

        .hamburger span {
            width: 1.5rem;
            height: 0.125rem;
            background: #e0e0e0;
            border-radius: 0.0625rem;
            transition: all 0.3s ease;
        }

        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(0.5rem, 0.5rem);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(0.375rem, -0.375rem);
        }

        @media (min-width: 768px) {
            .nav-links {
                display: flex !important;
                position: static !important;
                flex-direction: row !important;
                background: none !important;
                backdrop-filter: none !important;
                padding: 0 !important;
                border: none !important;
                top: auto !important;
                left: auto !important;
            }

            .nav-auth {
                display: flex !important;
                position: static !important;
                flex-direction: row !important;
                padding: 0 !important;
                top: auto !important;
                left: auto !important;
                width: auto !important;
            }

            .hamburger {
                display: none;
            }

            .nav-login, .nav-register {
                font-size: 0.95rem;
            }
        }

        /* Hero Section */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 6rem 2rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            text-align: center;
            max-width: 800px;
            z-index: 20;
            animation: heroFadeUp 1s ease-out;
        }

        @keyframes heroFadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .tagline {
            font-family: 'Space Mono', monospace;
            font-size: clamp(0.75rem, 2vw, 0.95rem);
            letter-spacing: 0.2em;
            color: rgba(77, 240, 197, 0.8);
            text-transform: uppercase;
            margin-bottom: 1rem;
            animation: taglineFadeIn 1s ease-out 0.2s both;
        }

        @keyframes taglineFadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .heading {
            font-size: clamp(2.5rem, 8vw, 4.5rem);
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #e0e0e0 0%, #ffffff 50%, #4DF0C5 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: headingFadeIn 1s ease-out 0.4s both;
        }

        @keyframes headingFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .heading .cyan-word {
            color: #4DF0C5;
            -webkit-text-fill-color: #4DF0C5;
        }

        .subheading {
            font-size: clamp(0.95rem, 2.5vw, 1.15rem);
            color: rgba(224, 224, 224, 0.7);
            line-height: 1.6;
            margin-bottom: 2.5rem;
            font-weight: 400;
            animation: subheadingFadeIn 1s ease-out 0.6s both;
        }

        @keyframes subheadingFadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .cta-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 2rem;
            animation: buttonsFadeIn 1s ease-out 0.8s both;
        }

        @keyframes buttonsFadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (min-width: 640px) {
            .cta-buttons {
                flex-direction: row;
                justify-content: center;
                gap: 1.5rem;
            }
        }

        .btn {
            padding: 1rem 2.5rem;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            font-family: 'Exo 2', sans-serif;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4DF0C5 0%, #2ac9a3 100%);
            color: #050a14;
            box-shadow: 0 0 30px rgba(77, 240, 197, 0.3);
        }

        .btn-primary:hover {
            box-shadow: 0 0 50px rgba(77, 240, 197, 0.6);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: transparent;
            border: 2px solid rgba(77, 240, 197, 0.5);
            color: #4DF0C5;
        }

        .btn-secondary:hover {
            background: rgba(77, 240, 197, 0.1);
            border-color: #4DF0C5;
            box-shadow: 0 0 20px rgba(77, 240, 197, 0.2);
        }

        .badges {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
            animation: badgesFadeIn 1s ease-out 1s both;
        }

        @keyframes badgesFadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .badge {
            backdrop-filter: blur(8px);
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(77, 240, 197, 0.3);
            color: #4DF0C5;
            padding: 0.5rem 1.25rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .badge:hover {
            background: rgba(77, 240, 197, 0.1);
            border-color: #4DF0C5;
            box-shadow: 0 0 20px rgba(77, 240, 197, 0.2);
        }

        /* Features Section */
        .features-section {
            padding: 6rem 2rem;
            position: relative;
            z-index: 20;
        }

        .features-container {
            max-width: 7xl;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            margin-top: 3rem;
        }

        @media (min-width: 768px) {
            .features-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .feature-card {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(77, 240, 197, 0.15);
            padding: 2rem;
            border-radius: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
            animation: cardFadeUp 0.8s ease-out forwards;
        }

        .feature-card:nth-child(1) {
            animation-delay: 0s;
        }

        .feature-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .feature-card:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes cardFadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .feature-card:hover {
            transform: translateY(-8px);
            border-color: rgba(77, 240, 197, 0.5);
            box-shadow: 0 0 30px rgba(77, 240, 197, 0.2), 0 20px 40px rgba(77, 240, 197, 0.1);
            background: rgba(77, 240, 197, 0.05);
        }

        .feature-icon {
            width: 4rem;
            height: 4rem;
            background: linear-gradient(135deg, rgba(77, 240, 197, 0.2), rgba(124, 80, 255, 0.2));
            border: 1px solid rgba(77, 240, 197, 0.3);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .feature-icon svg {
            width: 2rem;
            height: 2rem;
            color: #4DF0C5;
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: #ffffff;
        }

        .feature-desc {
            font-size: 0.95rem;
            color: rgba(224, 224, 224, 0.7);
            line-height: 1.6;
        }

        /* Footer hint */
        .footer-hint {
            text-align: center;
            padding: 2rem;
            color: rgba(224, 224, 224, 0.5);
            font-size: 0.85rem;
            position: relative;
            z-index: 20;
        }

        .footer-hint a {
            color: #4DF0C5;
            text-decoration: none;
        }

        .footer-hint a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Canvas Background -->
    <canvas id="three-canvas"></canvas>
    
    <!-- Page Overlay -->
    <div class="page-overlay"></div>
    
    <!-- Content Layer -->
    <div class="content-layer">
        <!-- Navbar -->
        <nav>
            <div class="nav-container">
                <div class="logo">
                    Edu<span>Play</span>Hub
                </div>
                
                <div class="hamburger" id="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

                <ul class="nav-links" id="navLinks">
                    <li><a href="#academic">Academic Gear</a></li>
                    <li><a href="#fun">Fun Gear</a></li>
                    <li><a href="#market">Second Market</a></li>
                </ul>

                <div class="nav-auth" id="navAuth">
                    <a href="{{ route('login') }}" class="nav-login">Login</a>
                    <a href="{{ route('register') }}" class="nav-register">Daftar</a>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-content">
                <div class="tagline">ONE-STOP RENTAL PLATFORM</div>
                <h1 class="heading">Edu<span class="cyan-word">Play</span>Hub</h1>
                <p class="subheading">
                    Sewa alat akademis & hiburan dalam satu platform. 
                    Dari GoPro untuk riset dataset hingga PS4 untuk break time 
                    — semua tersedia dengan harga transparan.
                </p>
                <div class="cta-buttons">
                    <a href="{{ route('register') }}" class="btn btn-primary">Mulai Sewa →</a>
                    <a href="{{ route('catalog') }}" class="btn btn-secondary">Lihat Katalog</a>
                </div>
                <div class="badges">
                    <span class="badge">Academic Gear</span>
                    <span class="badge">Fun Gear</span>
                    <span class="badge">Second Market</span>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features-section" id="features">
            <div class="features-container">
                <div class="features-grid">
                    <!-- Academic Gear Card -->
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                                <circle cx="12" cy="13" r="4"></circle>
                            </svg>
                        </div>
                        <h3 class="feature-title">Academic Gear</h3>
                        <p class="feature-desc">Teknologi untuk riset & tugas kuliah. GoPro, kamera profesional, alat ukur, dan peralatan lab berkualitas tinggi.</p>
                    </div>

                    <!-- Fun Gear Card -->
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M6 3h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"></path>
                                <line x1="9" y1="15" x2="15" y2="15"></line>
                                <line x1="12" y1="12" x2="12" y2="18"></line>
                            </svg>
                        </div>
                        <h3 class="feature-title">Fun Gear</h3>
                        <p class="feature-desc">Hiburan premium saat butuh rehat. PS4, Nintendo Switch, VR headsets, dan konsol gaming terbaru lainnya.</p>
                    </div>

                    <!-- Second Market Card -->
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 4H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h4"></path>
                                <path d="M15 4h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                <line x1="9" y1="7" x2="15" y2="7"></line>
                                <line x1="9" y1="11" x2="15" y2="11"></line>
                                <line x1="9" y1="15" x2="15" y2="15"></line>
                            </svg>
                        </div>
                        <h3 class="feature-title">Second Market</h3>
                        <p class="feature-desc">Beli second berkualitas, harga transparan. Peralatan bekas terverifikasi dengan garansi kepuasan pembeli.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer Hint -->
        <div class="footer-hint">
            <p>Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a> untuk memulai perjalanan rental Anda.</p>
        </div>
    </div>

    <script>
        // Mobile Menu Toggle
        const hamburger = document.getElementById('hamburger');
        const navLinks = document.getElementById('navLinks');
        const navAuth = document.getElementById('navAuth');

        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navLinks.classList.toggle('active');
            navAuth.classList.toggle('active');
        });

        // Three.js Setup
        const canvas = document.getElementById('three-canvas');
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: true });

        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(window.devicePixelRatio);
        renderer.setClearColor(0x050a14, 1);

        camera.position.z = 30;

        // GLSL Vertex Shader
        const vertexShader = `
            varying vec3 vPosition;
            varying vec3 vNormal;

            void main() {
                vPosition = position;
                vNormal = normalize(normalMatrix * normal);
                gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
            }
        `;

        // GLSL Fragment Shader with Raymarching
        const fragmentShader = `
            precision highp float;
            varying vec3 vPosition;
            varying vec3 vNormal;

            uniform float uTime;
            uniform vec3 uMousePos;

            // Signed Distance Functions
            float sdBox(vec3 p, vec3 b) {
                vec3 q = abs(p) - b;
                return length(max(q, 0.0)) + min(max(q.x, max(q.y, q.z)), 0.0);
            }

            float sdSphere(vec3 p, float r) {
                return length(p) - r;
            }

            float sdTorus(vec3 p, vec2 t) {
                vec2 q = vec2(length(p.xz) - t.x, p.y);
                return length(q) - t.y;
            }

            // Noise function
            float noise(vec3 p) {
                return sin(p.x * 12.9898 + p.y * 78.233 + p.z * 45.164) * 43758.5453;
            }

            void main() {
                vec3 rayDir = normalize(vPosition);
                vec3 rayOrigin = vec3(0.0, 0.0, 0.0);
                
                float dist = 100.0;
                vec3 color = vec3(0.0);
                float alpha = 0.3;

                // Academic Gear - Teal Box
                vec3 box1Pos = vec3(sin(uTime * 0.5) * 8.0, cos(uTime * 0.3) * 6.0, -10.0);
                float d1 = sdBox(vPosition - box1Pos, vec3(2.5, 2.5, 2.5));
                if (d1 < dist) {
                    dist = d1;
                    color = vec3(0.3, 0.9, 0.8);
                    alpha = 0.6;
                }

                // Fun Gear - Purple Box
                vec3 box2Pos = vec3(cos(uTime * 0.4) * -10.0, sin(uTime * 0.35) * 7.0, -12.0);
                float d2 = sdBox(vPosition - box2Pos, vec3(2.0, 2.0, 2.0));
                if (d2 < dist) {
                    dist = d2;
                    color = vec3(0.6, 0.3, 1.0);
                    alpha = 0.6;
                }

                // Central Sphere
                vec3 spherePos = vec3(0.0, 0.0, -15.0);
                float d3 = sdSphere(vPosition - spherePos, 3.0);
                if (d3 < dist) {
                    dist = d3;
                    color = vec3(0.0, 0.7, 1.0);
                    alpha = 0.5;
                }

                // Torus around sphere
                float d4 = sdTorus(vPosition - spherePos, vec2(5.0, 0.8));
                if (d4 < dist * 1.5) {
                    color = mix(color, vec3(0.3, 1.0, 0.8), 0.5);
                }

                // Orbiting small objects
                for (int i = 0; i < 6; i++) {
                    float angle = float(i) * 6.28 / 6.0 + uTime * 0.2;
                    vec3 orbitPos = vec3(
                        cos(angle) * 12.0,
                        sin(angle * 0.5) * 8.0,
                        sin(angle) * -10.0
                    );
                    float orbitDist = sdBox(vPosition - orbitPos, vec3(1.0));
                    if (orbitDist < dist) {
                        dist = orbitDist;
                        color = mix(vec3(0.3, 0.9, 0.8), vec3(0.6, 0.3, 1.0), float(i) / 6.0);
                        alpha = 0.4;
                    }
                }

                // Stars/noise background
                float stars = noise(vPosition * 0.1);
                if (stars > 0.99) {
                    color = mix(color, vec3(1.0), 0.3);
                }

                // Glow effect based on distance
                float glow = exp(-dist * 0.2) * 0.5;
                color += vec3(0.2, 0.8, 1.0) * glow;

                // Apply gamma correction
                color = pow(color, vec3(0.45));

                gl_FragColor = vec4(color, alpha);
            }
        `;

        // Create shader material
        const material = new THREE.ShaderMaterial({
            vertexShader,
            fragmentShader,
            uniforms: {
                uTime: { value: 0 },
                uMousePos: { value: new THREE.Vector3(0, 0, 0) }
            },
            blending: THREE.AdditiveBlending,
            transparent: true
        });

        // Create mesh
        const geometry = new THREE.IcosahedronGeometry(50, 16);
        const mesh = new THREE.Mesh(geometry, material);
        scene.add(mesh);

        // Lighting
        const light = new THREE.PointLight(0x4DF0C5, 1.5, 100);
        light.position.set(20, 20, 20);
        scene.add(light);

        const ambientLight = new THREE.AmbientLight(0x333333, 0.5);
        scene.add(ambientLight);

        // Mouse tracking for parallax
        let mouseX = 0;
        let mouseY = 0;

        document.addEventListener('mousemove', (e) => {
            mouseX = (e.clientX / window.innerWidth) * 2 - 1;
            mouseY = -(e.clientY / window.innerHeight) * 2 + 1;
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });

        // Animation loop
        function animate() {
            requestAnimationFrame(animate);

            // Update shader uniforms
            material.uniforms.uTime.value += 0.016;
            material.uniforms.uMousePos.value.set(mouseX * 10, mouseY * 10, 0);

            // Parallax camera
            camera.position.x = mouseX * 5;
            camera.position.y = mouseY * 5;
            camera.lookAt(0, 0, 0);

            // Mesh rotation
            mesh.rotation.x += 0.0002;
            mesh.rotation.y += 0.0003;

            renderer.render(scene, camera);
        }

        animate();
    </script>
</body>
</html>