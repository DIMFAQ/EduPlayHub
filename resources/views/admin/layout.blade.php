<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduPlayHub Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #F4F9FF 0%, #EFF6FF 100%);
        }

        .glass {
            background: rgba(255,255,255,0.65);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(56,189,248,0.25);
        }

        .nav-item {
            transition: 0.2s;
        }

        .nav-item:hover {
            background: rgba(56,189,248,0.12);
        }

        .active {
            background: rgba(56,189,248,0.18);
            border-left: 4px solid #38BDF8;
        }
    </style>
</head>

<body>

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-72 glass p-6 border-r border-blue-200/40">

        <h1 class="text-2xl font-bold text-blue-600">EduPlayHub</h1>
        <p class="text-xs text-slate-500 mb-6">Admin Panel</p>

        <nav class="space-y-2 text-sm font-medium">

            <!-- DASHBOARD -->
            <a href="/admin/dashboard"
               class="nav-item block px-4 py-3 rounded-xl {{ request()->path() == 'admin/dashboard' ? 'active' : '' }}">
                📊 Dashboard
            </a>

            <!-- PRODUK -->
            <a href="{{ route('admin.products.index') }}"
               class="nav-item block px-4 py-3 rounded-xl {{ request()->path() == 'admin/products' ? 'active' : '' }}">
                📦 Produk
            </a>

            <!-- TAMBAH PRODUK -->
            <a href="{{ route('admin.products.create') }}"
               class="nav-item block px-4 py-3 rounded-xl {{ request()->path() == 'admin/products/create' ? 'active' : '' }}">
                ➕ Tambah Produk
            </a>

        </nav>

    </aside>

    <!-- CONTENT -->
    <main class="flex-1 p-8">
        @yield('content')
    </main>

</div>

</body>
</html>