<?php
$namaAdmin = $_SESSION['admin_nama'] ?? 'Administrator';
$menuAktif = $_GET['menu'] ?? 'home';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard UMKM</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
        :root{
            --ocean-1:#023e8a;
            --ocean-2:#0077b6;
            --ocean-3:#0096c7;
            --ocean-4:#48cae4;
            --ocean-5:#caf0f8;
            --soft:#f4fbff;
        }

        body{
            background: linear-gradient(180deg, #f7fcff 0%, #eef8fd 100%);
            color:#12344d;
        }

        .navbar-ocean{
            background: linear-gradient(135deg, var(--ocean-1), var(--ocean-2));
        }

        .navbar-brand{
            font-weight:800;
            letter-spacing:.3px;
        }

        .hero-box{
            background:
                radial-gradient(circle at top right, rgba(255,255,255,.22), transparent 26%),
                linear-gradient(135deg, var(--ocean-1), var(--ocean-2), var(--ocean-3));
            color:#fff;
            border-radius:24px;
            padding:32px;
            box-shadow:0 14px 34px rgba(2,62,138,.18);
        }

        .content-card{
            border:none;
            border-radius:22px;
            box-shadow:0 10px 30px rgba(2,62,138,.08);
        }

        .stat-card{
            border:none;
            border-radius:20px;
            box-shadow:0 10px 25px rgba(2,62,138,.08);
            transition:.25s ease;
        }

        .stat-card:hover,
        .quick-card:hover{
            transform:translateY(-4px);
        }

        .icon-bubble{
            width:56px;
            height:56px;
            border-radius:16px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:800;
            color:#fff;
            background:linear-gradient(135deg, var(--ocean-2), var(--ocean-4));
        }

        .quick-card{
            border:none;
            border-radius:20px;
            box-shadow:0 10px 25px rgba(2,62,138,.08);
            transition:.25s ease;
        }

        .section-title{
            font-weight:800;
            color:var(--ocean-1);
        }

        .table-img{
            width:72px;
            height:72px;
            object-fit:cover;
            border-radius:14px;
            border:1px solid #d7e7f3;
        }

        .table thead th{
            background:#dff3fb !important;
            color:#0c4a6e;
            vertical-align:middle;
        }

        .btn-primary{
            background:linear-gradient(135deg, var(--ocean-2), var(--ocean-3));
            border:none;
        }

        .btn-primary:hover{
            opacity:.95;
        }

        .form-control,
        .form-select{
            border-radius:14px;
            padding:.75rem .9rem;
            border:1px solid #d7e7f3;
        }

        .form-control:focus,
        .form-select:focus{
            border-color:var(--ocean-3);
            box-shadow:0 0 0 .2rem rgba(0,150,199,.16);
        }

        footer{
            margin-top:48px;
        }
    </style>
</head>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-ocean shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="index.php">UMKM | Admin</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarAdmin">
            <ul class="navbar-nav me-auto ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link <?= $menuAktif == 'home' ? 'active' : ''; ?>" href="index.php?menu=home">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $menuAktif == 'produk' ? 'active' : ''; ?>" href="index.php?menu=produk">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $menuAktif == 'staff' ? 'active' : ''; ?>" href="index.php?menu=staff">Staff</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <span class="text-white small">
                    Halo, <strong><?= htmlspecialchars($namaAdmin); ?></strong>
                </span>
                <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
            </div>
        </div>
    </div>
</nav>

<?php include 'menu.php'; ?>

<?php include 'footer.php'; ?>

</body>
</html>