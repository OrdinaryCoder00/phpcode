<?php 

session_start();

$conn = mysqli_connect("localhost","root","","smartprintdb");

//function tambah barang stock
if (isset($_POST['addnewbarang'])) {
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $width = $_POST['width'];
    $height = $_POST['height'];
    $qty = $_POST['quantity'];

    $addtotable = mysqli_query($conn,"insert into stock (namabarang, deskripsi, width, height, quantity) values('$namabarang','$deskripsi','$width','$height','$qty')");
    if ($addtotable){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}

//tambah barang masuk
if (isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $quantity = $_POST['quantity'];

    $cekstocksekarang = mysqli_query($conn,"select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);
   
    $stocksekarang = $ambildatanya['quantity'];
    $tambahstockbarangdenganquantity = $stocksekarang + $quantity;
    
    $addtomasuk = mysqli_query($conn,"insert into masuk (idbarang, keterangan, qty) values('$barangnya','$penerima','$quantity')");
    $updatestockmasuk = mysqli_query($conn, "update stock set quantity='$tambahstockbarangdenganquantity' where idbarang='$barangnya'");
    if ($addtomasuk && $updatestockmasuk){
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
}


if (isset($_POST['barangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $quantity = $_POST['quantity'];
    
    // awal bug{
    
    $cekstocksekarang = mysqli_query($conn,"select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);
   
    $stocksekarang = $ambildatanya['quantity'];
    $kurangstockbarangdenganquantity = $stocksekarang - $quantity;
    
    $addtokeluar = mysqli_query($conn,"insert into keluar (idbarang, penerima, qty) values('$barangnya','$penerima','$quantity')");
    $updatestockmasuk = mysqli_query($conn, "update stock set quantity='$kurangstockbarangdenganquantity' where idbarang='$barangnya'");
    if ($addtokeluar && $updatestockmasuk){
        header('location:keluar.php');
    } else {
        echo 'Gagal';
        header('location:keluar.php');
    }
}
    // } akhir bug


    #updatebarang
if (isset($_POST['updatebarang'])){
    $idb = $_POST['idb'];
    $namabarang = $_POST ['namabarang'];
    $deskripsi = $_POST ['deskripsi'];
    $width = $_POST ['width'];
    $height = $_POST ['height'];

    $update = mysqli_query($conn,"update stock set namabarang='$namabarang', deskripsi='$deskripsi', width='$width', height='$height' where idbarang = '$idb'");
    
    if($update){
        header('location:index.php');
        # code...
    }else {
        echo 'gagal';
        header('location:index.php');
    }
}

    #Hapus Barang
if (isset($_POST['hapusbarang'])){
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn, "delete from stock where idbarang='$idb'");
    
    if($hapus){
        header('location:index.php');
        # code...
    }else {
        echo 'gagal';
        header('location:index.php');
    }
}
?>
