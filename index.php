<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UMKM Ocean</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root{
            --ocean-1:#023e8a;
            --ocean-2:#0077b6;
            --ocean-3:#0096c7;
            --ocean-4:#48cae4;
            --ocean-5:#caf0f8;
            --bg-soft:#f4fbff;
            --card-shadow:0 10px 28px rgba(2,62,138,.08);
            --radius-xl:22px;
        }

        *{
            box-sizing:border-box;
        }

        body{
            margin:0;
            background:linear-gradient(180deg,#f7fcff 0%, #eef7fb 100%);
            color:#12344d;
            font-family:Arial, sans-serif;
        }

        a{
            text-decoration:none;
            color:inherit;
        }

        .topbar{
            background:linear-gradient(135deg,var(--ocean-1),var(--ocean-2));
            color:#fff;
            font-size:14px;
        }

        .topbar a{
            color:#fff;
            opacity:.95;
        }

        .main-header{
            background:linear-gradient(135deg,var(--ocean-2),var(--ocean-3));
            color:#fff;
            position:sticky;
            top:0;
            z-index:1000;
            box-shadow:0 6px 20px rgba(2,62,138,.12);
        }

        .brand{
            font-weight:800;
            font-size:2rem;
            letter-spacing:.3px;
            white-space:nowrap;
        }

        .search-wrap{
            background:#fff;
            border-radius:16px;
            padding:6px;
            box-shadow:var(--card-shadow);
        }

        .search-wrap .form-control{
            border:none;
            box-shadow:none;
            min-height:46px;
            border-radius:12px;
        }

        .search-btn{
            min-width:54px;
            border:none;
            border-radius:12px;
            background:linear-gradient(135deg,var(--ocean-2),var(--ocean-3));
            color:#fff;
        }

        .header-tags{
            font-size:14px;
            opacity:.95;
        }

        .hero{
            padding:20px 0 8px;
        }

        .hero-banner{
            background:
                radial-gradient(circle at top right, rgba(255,255,255,.28), transparent 26%),
                linear-gradient(135deg,var(--ocean-1),var(--ocean-2),var(--ocean-4));
            color:#fff;
            border-radius:28px;
            overflow:hidden;
            box-shadow:var(--card-shadow);
            min-height:210px;
        }

        .hero-banner h1{
            font-size:clamp(1.6rem, 3vw, 2.7rem);
            font-weight:800;
            line-height:1.2;
        }

        .hero-banner p{
            font-size:1rem;
            opacity:.95;
            max-width:560px;
        }

        .hero-chip{
            display:inline-flex;
            align-items:center;
            gap:8px;
            background:rgba(255,255,255,.16);
            border:1px solid rgba(255,255,255,.22);
            color:#fff;
            padding:10px 16px;
            border-radius:999px;
            font-size:.95rem;
            margin:6px 8px 0 0;
        }

        .section-card{
            background:#fff;
            border:none;
            border-radius:var(--radius-xl);
            box-shadow:var(--card-shadow);
        }

        .section-title{
            font-size:2rem;
            font-weight:800;
            color:var(--ocean-1);
            margin-bottom:0;
        }

        .section-subtitle{
            color:#5b7285;
            margin-bottom:0;
        }

        .feature-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:14px;
        }

        .feature-item{
            background:#fff;
            border-radius:20px;
            box-shadow:var(--card-shadow);
            padding:18px 12px;
            text-align:center;
            transition:.25s ease;
            min-height:138px;
        }

        .feature-item:hover,
        .category-item:hover,
        .product-card:hover{
            transform:translateY(-4px);
        }

        .feature-icon,
        .category-icon{
            width:64px;
            height:64px;
            border-radius:18px;
            margin:0 auto 12px;
            display:flex;
            align-items:center;
            justify-content:center;
            background:linear-gradient(135deg,var(--ocean-5), #ffffff);
            color:var(--ocean-2);
            font-size:1.8rem;
            box-shadow:inset 0 0 0 1px rgba(0,119,182,.08);
        }

        .feature-label{
            font-weight:700;
            color:#17324d;
            line-height:1.3;
        }

        .category-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            border:1px solid #e2eef6;
            border-radius:24px;
            overflow:hidden;
            background:#fff;
        }

        .category-item{
            border-right:1px solid #e2eef6;
            border-bottom:1px solid #e2eef6;
            padding:24px 12px;
            text-align:center;
            background:#fff;
            transition:.25s ease;
            min-height:180px;
            display:flex;
            flex-direction:column;
            justify-content:center;
        }

        .category-item:nth-child(2n){
            border-right:none;
        }

        .category-item:last-child,
        .category-item:nth-last-child(2){
            border-bottom:none;
        }

        .category-name{
            font-weight:700;
            color:#14324a;
            line-height:1.35;
        }

        .product-grid{
            display:grid;
            grid-template-columns:repeat(1,1fr);
            gap:18px;
        }

        .product-card{
            background:#fff;
            border-radius:22px;
            box-shadow:var(--card-shadow);
            overflow:hidden;
            transition:.25s ease;
        }

        .product-thumb{
            height:180px;
            background:linear-gradient(135deg,#dff3fb,#f7fdff);
            display:flex;
            align-items:center;
            justify-content:center;
            color:var(--ocean-2);
            font-size:3rem;
        }

        .product-body{
            padding:16px;
        }

        .product-title{
            font-weight:700;
            color:#17324d;
            margin-bottom:8px;
        }

        .product-price{
            font-weight:800;
            color:var(--ocean-2);
            font-size:1.1rem;
        }

        .badge-soft{
            background:#eaf7fc;
            color:#0a678f;
            border-radius:999px;
            padding:7px 12px;
            font-size:.82rem;
            font-weight:700;
        }

        .cta-banner{
            background:linear-gradient(135deg,var(--ocean-1),var(--ocean-3));
            color:#fff;
            border-radius:26px;
            box-shadow:var(--card-shadow);
        }

        .footer{
            margin-top:36px;
            background:linear-gradient(135deg,var(--ocean-1),var(--ocean-2));
            color:#fff;
        }

        .footer a{
            color:#fff;
            opacity:.95;
        }

        @media (min-width: 576px){
            .feature-grid{
                grid-template-columns:repeat(3,1fr);
            }

            .product-grid{
                grid-template-columns:repeat(2,1fr);
            }
        }

        @media (min-width: 768px){
            .feature-grid{
                grid-template-columns:repeat(4,1fr);
            }

            .category-grid{
                grid-template-columns:repeat(4,1fr);
            }

            .category-item{
                border-right:1px solid #e2eef6;
                border-bottom:1px solid #e2eef6;
            }

            .category-item:nth-child(2n){
                border-right:1px solid #e2eef6;
            }

            .category-item:nth-child(4n){
                border-right:none;
            }

            .category-item:nth-last-child(-n+4){
                border-bottom:none;
            }

            .product-grid{
                grid-template-columns:repeat(3,1fr);
            }
        }

        @media (min-width: 992px){
            .product-grid{
                grid-template-columns:repeat(4,1fr);
            }

            .brand{
                font-size:2.2rem;
            }
        }
    </style>
</head>
<body>

    <div class="topbar py-2">
        <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="d-flex flex-wrap gap-3">
                <a href="#"><i class="bi bi-shop me-1"></i> Seller Centre</a>
                <a href="#"><i class="bi bi-megaphone me-1"></i> Mulai Berjualan</a>
                <a href="#"><i class="bi bi-question-circle me-1"></i> Bantuan</a>
            </div>
            <div class="d-flex flex-wrap gap-3">
                <a href="#"><i class="bi bi-bell me-1"></i> Notifikasi</a>
                <a href="#"><i class="bi bi-person-plus me-1"></i> Daftar</a>
                <a href="#"><i class="bi bi-box-arrow-in-right me-1"></i> Log In</a>
            </div>
        </div>
    </div>

    <header class="main-header py-3">
        <div class="container">
            <div class="row align-items-center g-3">
                <div class="col-12 col-lg-3">
                    <div class="brand">UMKM Ocean</div>
                </div>
                <div class="col-12 col-lg-9">
                    <form class="search-wrap">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari produk UMKM favoritmu...">
                            <button class="search-btn" type="button">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                    <div class="header-tags mt-2 d-flex flex-wrap gap-3 ps-1">
                        <span>Makanan Lokal</span>
                        <span>Kerajinan Tangan</span>
                        <span>Fashion UMKM</span>
                        <span>Elektronik</span>
                        <span>Produk Rumah Tangga</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container">
                <div class="hero-banner p-4 p-md-5">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-7">
                            <h1>Temukan Produk UMKM Lokal dengan Tampilan Modern</h1>
                            <p class="mt-3 mb-3">
                                Dukung produk lokal Indonesia melalui platform UMKM bertema ocean blue yang responsif,
                                rapi, dan nyaman diakses dari mobile, tablet, maupun desktop.
                            </p>
                            <div>
                                <span class="hero-chip"><i class="bi bi-award"></i> Produk Unggulan Lokal</span>
                                <span class="hero-chip"><i class="bi bi-truck"></i> Pengiriman Cepat</span>
                                <span class="hero-chip"><i class="bi bi-shield-check"></i> Aman & Terpercaya</span>
                            </div>
                        </div>
                        <div class="col-lg-5 text-center">
                            <div class="p-4">
                                <i class="bi bi-shop-window" style="font-size:6rem; opacity:.95;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-3">
            <div class="container">
                <div class="feature-grid">
                    <a href="#" class="feature-item">
                        <div class="feature-icon"><i class="bi bi-heart"></i></div>
                        <div class="feature-label">UMKM Pilihan Lokal</div>
                    </a>
                    <a href="#" class="feature-item">
                        <div class="feature-icon"><i class="bi bi-bag-check"></i></div>
                        <div class="feature-label">Toko Resmi UMKM</div>
                    </a>
                    <a href="#" class="feature-item">
                        <div class="feature-icon"><i class="bi bi-lightning-charge"></i></div>
                        <div class="feature-label">Promo & Flash Sale</div>
                    </a>
                    <a href="#" class="feature-item">
                        <div class="feature-icon"><i class="bi bi-cart3"></i></div>
                        <div class="feature-label">Belanja Mudah</div>
                    </a>
                    <a href="#" class="feature-item">
                        <div class="feature-icon"><i class="bi bi-phone"></i></div>
                        <div class="feature-label">Pulsa & Tagihan</div>
                    </a>
                    <a href="#" class="feature-item">
                        <div class="feature-icon"><i class="bi bi-gift"></i></div>
                        <div class="feature-label">Voucher Menarik</div>
                    </a>
                </div>
            </div>
        </section>

        <section class="py-3">
            <div class="container">
                <div class="section-card p-4">
                    <div class="mb-4">
                        <h2 class="section-title">Kategori</h2>
                    </div>

                    <div class="category-grid">
                        <a href="#" class="category-item">
                            <div class="category-icon"><i class="bi bi-tv"></i></div>
                            <div class="category-name">Elektronik</div>
                        </a>
                        <a href="#" class="category-item">
                            <div class="category-icon"><i class="bi bi-laptop"></i></div>
                            <div class="category-name">Komputer & Aksesoris</div>
                        </a>
                        <a href="#" class="category-item">
                            <div class="category-icon"><i class="bi bi-phone"></i></div>
                            <div class="category-name">Handphone & Aksesoris</div>
                        </a>
                        <a href="#" class="category-item">
                            <div class="category-icon"><i class="bi bi-bag"></i></div>
                            <div class="category-name">Fashion Pria</div>
                        </a>
                        <a href="#" class="category-item">
                            <div class="category-icon"><i class="bi bi-cup-hot"></i></div>
                            <div class="category-name">Makanan & Minuman</div>
                        </a>
                        <a href="#" class="category-item">
                            <div class="category-icon"><i class="bi bi-droplet-half"></i></div>
                            <div class="category-name">Perawatan & Kecantikan</div>
                        </a>
                        <a href="#" class="category-item">
                            <div class="category-icon"><i class="bi bi-house-door"></i></div>
                            <div class="category-name">Perlengkapan Rumah</div>
                        </a>
                        <a href="#" class="category-item">
                            <div class="category-icon"><i class="bi bi-handbag"></i></div>
                            <div class="category-name">Fashion Wanita</div>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-3">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <div>
                        <h2 class="section-title">Produk Unggulan</h2>
                        <p class="section-subtitle">Pilihan produk terbaik untuk pengunjung UMKM Ocean</p>
                    </div>
                    <a href="#" class="badge-soft">Lihat Semua</a>
                </div>

                <div class="product-grid">
                    <div class="product-card">
                        <div class="product-thumb"><i class="bi bi-basket2"></i></div>
                        <div class="product-body">
                            <div class="product-title">Snack Keripik Pisang Premium</div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="product-price">Rp 25.000</div>
                                <span class="badge-soft">Terlaris</span>
                            </div>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="product-thumb"><i class="bi bi-watch"></i></div>
                        <div class="product-body">
                            <div class="product-title">Jam Tangan Handmade Lokal</div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="product-price">Rp 145.000</div>
                                <span class="badge-soft">Baru</span>
                            </div>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="product-thumb"><i class="bi bi-flower1"></i></div>
                        <div class="product-body">
                            <div class="product-title">Buket Bunga Dekorasi</div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="product-price">Rp 89.000</div>
                                <span class="badge-soft">Populer</span>
                            </div>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="product-thumb"><i class="bi bi-cup-straw"></i></div>
                        <div class="product-body">
                            <div class="product-title">Minuman Herbal Segar</div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="product-price">Rp 18.000</div>
                                <span class="badge-soft">UMKM</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-4">
            <div class="container">
                <div class="cta-banner p-4 p-md-5">
                    <div class="row align-items-center g-3">
                        <div class="col-lg-8">
                            <h3 class="fw-bold mb-2">Gabung dan Kembangkan UMKM-mu</h3>
                            <p class="mb-0 opacity-75">
                                Tampilkan produk terbaikmu dengan antarmuka modern, responsif, dan mudah digunakan.
                            </p>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <a href="#" class="btn btn-light px-4 py-2 rounded-pill fw-bold">Mulai Berjualan</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h4 class="fw-bold">UMKM Ocean</h4>
                    <p class="mb-0">
                        Platform UMKM bertema ocean blue yang responsif untuk mobile, tablet, dan desktop.
                    </p>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-bold">Navigasi</h5>
                    <div class="d-flex flex-column gap-2">
                        <a href="#">Beranda</a>
                        <a href="#">Kategori</a>
                        <a href="#">Produk Unggulan</a>
                        <a href="#">Mulai Berjualan</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-bold">Kontak</h5>
                    <div class="d-flex flex-column gap-2">
                        <span><i class="bi bi-envelope me-2"></i>support@umkmocean.id</span>
                        <span><i class="bi bi-telephone me-2"></i>+62 812 3456 7890</span>
                        <span><i class="bi bi-geo-alt me-2"></i>Indonesia</span>
                    </div>
                </div>
            </div>
            <hr class="border-light opacity-25 my-4">
            <div class="text-center">© 2026 UMKM Ocean. All rights reserved.</div>
        </div>
    </footer>

</body>
</html>