<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>EduPlayHub — Admin Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: linear-gradient(135deg, #F4F9FF 0%, #EFF6FF 100%);
            font-family: 'Inter', sans-serif;
            color: #0F172A;
        }
        .glass-holo {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(56, 189, 248, 0.3);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.02), 0 0 0 1px rgba(56, 189, 248, 0.1) inset;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.55);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(56, 189, 248, 0.25);
            border-radius: 1.5rem;
        }
        .badge-neon {
            background: linear-gradient(135deg, #38BDF8, #00F0FF);
            box-shadow: 0 0 8px rgba(0,200,255,0.35);
        }
        .sidebar-link:hover {
            background: rgba(56, 189, 248, 0.10);
            border-color: rgba(56, 189, 248, 0.35);
        }
        .sidebar-link.active {
            background: rgba(56, 189, 248, 0.14);
            border-color: rgba(0, 240, 255, 0.55);
            box-shadow: 0 0 0 1px rgba(0, 240, 255, 0.25);
        }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #D9EAFB; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #38BDF8; border-radius: 10px; }
    </style>
</head>
<body>

<div class="max-w-[1500px] mx-auto px-5 md:px-10 py-7">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-7">
        <div>
            <div class="inline-flex items-center gap-2 text-xs text-slate-500">
                <span class="badge-neon text-white px-3 py-1 rounded-full font-semibold">ADMIN</span>
                <span>EduPlayHub Management System</span>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold mt-2 tracking-tight bg-gradient-to-r from-slate-800 to-blue-600 bg-clip-text text-transparent">
                Dashboard Admin
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Kelola booking PS, sewa dataset, produk, dan transaksi pembayaran.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <button class="glass-holo px-4 py-2 rounded-full text-sm font-semibold text-slate-700 hover:text-blue-600 transition flex items-center gap-2">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Export Report
            </button>

            <div class="flex items-center gap-3 glass-holo px-4 py-2 rounded-full">
                <div class="w-9 h-9 rounded-full bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center text-white font-bold text-sm">
                    AD
                </div>
                <div class="leading-tight">
                    <div class="text-sm font-semibold text-slate-800">Admin</div>
                    <div class="text-[11px] text-slate-500">admin@eduplayhub.com</div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- SIDEBAR -->
        <aside class="lg:col-span-3 glass-card p-5 h-fit sticky top-6">
            <h2 class="font-bold text-slate-800 text-lg mb-4">Menu Admin</h2>

            <div class="space-y-2">
                <a href="/admin/dashboard" class="sidebar-link active border border-blue-200/40 rounded-xl px-4 py-3 flex items-center gap-3 text-sm font-semibold text-slate-700 transition">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M3 13h8V3H3v10zM13 21h8v-6h-8v6zM13 3h8v10h-8V3zM3 21h8v-6H3v6z"/>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.products.index') }}" class="sidebar-link border border-blue-200/40 rounded-xl px-4 py-3 flex items-center gap-3 text-sm font-semibold text-slate-700 transition">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M20 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                        <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
                    </svg>
                    Manage Produk
                </a>

                <a href="#" class="sidebar-link border border-blue-200/40 rounded-xl px-4 py-3 flex items-center gap-3 text-sm font-semibold text-slate-700 transition">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M9 11l3 3L22 4"/>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                    </svg>
                    Manage Booking
                </a>

                <a href="#" class="sidebar-link border border-blue-200/40 rounded-xl px-4 py-3 flex items-center gap-3 text-sm font-semibold text-slate-700 transition">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M12 1v22"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7H14a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                    Pembayaran
                </a>

                <a href="#" class="sidebar-link border border-blue-200/40 rounded-xl px-4 py-3 flex items-center gap-3 text-sm font-semibold text-slate-700 transition">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    Users
                </a>

                <a href="#" class="sidebar-link border border-blue-200/40 rounded-xl px-4 py-3 flex items-center gap-3 text-sm font-semibold text-slate-700 transition">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M21 15a4 4 0 0 1-4 4H7l-4 4V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4z"/>
                    </svg>
                    Chat Inbox
                </a>
            </div>

            <div class="mt-6 pt-5 border-t border-blue-200/40">
                <a href="/" class="w-full flex items-center justify-center gap-2 bg-white border border-blue-200/60 text-slate-700 py-3 rounded-xl font-semibold hover:bg-blue-50 transition">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M15 18l-6-6 6-6"/>
                    </svg>
                    Kembali ke Website
                </a>
            </div>
        </aside>

        <!-- CONTENT -->
        <main class="lg:col-span-9 space-y-6">

            <!-- STATS -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
                <div class="glass-card p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-xs text-slate-500">Total Produk</div>
                            <div class="text-2xl font-bold text-slate-800 mt-1">48</div>
                        </div>
                        <div class="w-11 h-11 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600">
                            📦
                        </div>
                    </div>
                    <div class="text-xs text-green-600 mt-3">+5 minggu ini</div>
                </div>

                <div class="glass-card p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-xs text-slate-500">Booking Aktif</div>
                            <div class="text-2xl font-bold text-slate-800 mt-1">17</div>
                        </div>
                        <div class="w-11 h-11 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600">
                            🎮
                        </div>
                    </div>
                    <div class="text-xs text-blue-600 mt-3">12 PS Rental • 5 Dataset</div>
                </div>

                <div class="glass-card p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-xs text-slate-500">Pending Payment</div>
                            <div class="text-2xl font-bold text-slate-800 mt-1">6</div>
                        </div>
                        <div class="w-11 h-11 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600">
                            💳
                        </div>
                    </div>
                    <div class="text-xs text-amber-600 mt-3">Perlu verifikasi admin</div>
                </div>

                <div class="glass-card p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-xs text-slate-500">Pendapatan</div>
                            <div class="text-2xl font-bold text-blue-600 mt-1">Rp 12.8jt</div>
                        </div>
                        <div class="w-11 h-11 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600">
                            📈
                        </div>
                    </div>
                    <div class="text-xs text-green-600 mt-3">+18% bulan ini</div>
                </div>
            </div>

            <!-- RECENT ORDERS TABLE -->
            <div class="glass-card p-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-5">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Transaksi Terbaru</h2>
                        <p class="text-sm text-slate-500">Daftar booking dan sewa dataset terbaru.</p>
                    </div>

                    <a href="{{ route('admin.products.create') }}"
                      class="bg-gradient-to-r from-blue-600 to-cyan-500 text-white px-5 py-2.5 rounded-xl font-semibold hover:shadow-lg transition flex items-center justify-center gap-2">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14M5 12h14"/>
                        </svg>
                        Tambah Produk
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-slate-500 border-b border-blue-200/40">
                                <th class="py-3 pr-4">Order ID</th>
                                <th class="py-3 pr-4">Customer</th>
                                <th class="py-3 pr-4">Produk</th>
                                <th class="py-3 pr-4">Tipe</th>
                                <th class="py-3 pr-4">Total</th>
                                <th class="py-3 pr-4">Status</th>
                                <th class="py-3 pr-4 text-right">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="text-slate-700">
                            <tr class="border-b border-blue-100/40">
                                <td class="py-4 pr-4 font-semibold">#EPH-1021</td>
                                <td class="py-4 pr-4">Dara Ayu</td>
                                <td class="py-4 pr-4">PS5 + 2 Controller</td>
                                <td class="py-4 pr-4">
                                    <span class="px-3 py-1 rounded-full text-xs bg-blue-50 text-blue-600 font-semibold">Rental</span>
                                </td>
                                <td class="py-4 pr-4 font-semibold text-blue-600">Rp 450.000</td>
                                <td class="py-4 pr-4">
                                    <span class="px-3 py-1 rounded-full text-xs bg-amber-50 text-amber-700 font-semibold">Pending</span>
                                </td>
                                <td class="py-4 pr-1 text-right">
                                    <button class="px-4 py-2 rounded-xl border border-blue-200 hover:bg-blue-50 transition text-xs font-semibold">
                                        Detail
                                    </button>
                                </td>
                            </tr>

                            <tr class="border-b border-blue-100/40">
                                <td class="py-4 pr-4 font-semibold">#EPH-1020</td>
                                <td class="py-4 pr-4">Rheno Putra</td>
                                <td class="py-4 pr-4">Dataset AI Healthcare</td>
                                <td class="py-4 pr-4">
                                    <span class="px-3 py-1 rounded-full text-xs bg-purple-50 text-purple-700 font-semibold">Dataset</span>
                                </td>
                                <td class="py-4 pr-4 font-semibold text-blue-600">Rp 1.250.000</td>
                                <td class="py-4 pr-4">
                                    <span class="px-3 py-1 rounded-full text-xs bg-green-50 text-green-700 font-semibold">Paid</span>
                                </td>
                                <td class="py-4 pr-1 text-right">
                                    <button class="px-4 py-2 rounded-xl border border-blue-200 hover:bg-blue-50 transition text-xs font-semibold">
                                        Detail
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td class="py-4 pr-4 font-semibold">#EPH-1019</td>
                                <td class="py-4 pr-4">Milena</td>
                                <td class="py-4 pr-4">PS4 Pro + VR Set</td>
                                <td class="py-4 pr-4">
                                    <span class="px-3 py-1 rounded-full text-xs bg-blue-50 text-blue-600 font-semibold">Rental</span>
                                </td>
                                <td class="py-4 pr-4 font-semibold text-blue-600">Rp 780.000</td>
                                <td class="py-4 pr-4">
                                    <span class="px-3 py-1 rounded-full text-xs bg-red-50 text-red-700 font-semibold">Cancelled</span>
                                </td>
                                <td class="py-4 pr-1 text-right">
                                    <button class="px-4 py-2 rounded-xl border border-blue-200 hover:bg-blue-50 transition text-xs font-semibold">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- QUICK ACTIONS -->
            <div class="grid md:grid-cols-2 gap-6">
                <div class="glass-card p-6">
                    <h2 class="text-lg font-bold text-slate-800">Quick Actions</h2>
                    <p class="text-sm text-slate-500 mt-1">Akses cepat fitur admin penting.</p>

                    <div class="grid grid-cols-2 gap-4 mt-5">
                        <button class="bg-gradient-to-r from-blue-600 to-cyan-500 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition">
                            Verifikasi Pembayaran
                        </button>
                        <button class="bg-white border border-blue-200 text-slate-700 py-3 rounded-xl font-semibold hover:bg-blue-50 transition">
                            Kelola Produk
                        </button>
                        <button class="bg-white border border-blue-200 text-slate-700 py-3 rounded-xl font-semibold hover:bg-blue-50 transition">
                            Kelola Booking
                        </button>
                        <button class="bg-white border border-blue-200 text-slate-700 py-3 rounded-xl font-semibold hover:bg-blue-50 transition">
                            Kelola User
                        </button>
                    </div>
                </div>

                <div class="glass-card p-6">
                    <h2 class="text-lg font-bold text-slate-800">System Info</h2>
                    <p class="text-sm text-slate-500 mt-1">Status aplikasi dan server.</p>

                    <div class="mt-5 space-y-3 text-sm">
                        <div class="flex justify-between items-center border-b border-blue-100/40 pb-2">
                            <span class="text-slate-500">Server Status</span>
                            <span class="text-green-600 font-semibold">Online</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-blue-100/40 pb-2">
                            <span class="text-slate-500">Database</span>
                            <span class="text-blue-600 font-semibold">Connected</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-blue-100/40 pb-2">
                            <span class="text-slate-500">Version</span>
                            <span class="text-slate-700 font-semibold">EduPlayHub v1.0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500">Last Backup</span>
                            <span class="text-amber-600 font-semibold">2 hari lalu</span>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

</body>
</html>