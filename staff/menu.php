<?php
if (isset($_GET['menu'])) {
    $menu = $_GET['menu'];
} else {
    $menu = "home";
}

if ($menu == "produk") {
    include "produk.php";
}

elseif ($menu == "tambah_produk") {
    include "tambah_produk.php";
} 

elseif ($menu == "edit_produk") {
    include "edit_produk.php";
}

 elseif ($menu == "staff") {
    include "staff.php";
}

elseif ($menu == "tambah_staff") {
    include "tambah_staff.php";
}

elseif ($menu == "edit_staff") {
    include "edit_staff.php";
}

elseif ($menu == "produk_masuk") {
    include "produk_masuk.php";
}

elseif ($menu == "laporan_pembelian") {
    include "laporan_pembelian.php";
}

elseif ($menu == "grafik_pembelian") {
    include "grafik_pembelian.php";
}

elseif ($menu == "grafik_pembelian") {
    include "grafik_pembelian.php";
}

else {
     include "home.php";
}
?>