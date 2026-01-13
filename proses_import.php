<?php
include 'koneksi.php';

if(isset($_POST['import'])){
    $filename = $_FILES['file_excel']['tmp_name'];

    if($_FILES['file_excel']['size'] > 0){
        $file = fopen($filename, "r");
        
        // Lewati baris pertama jika ada header
        fgetcsv($file);

        while (($column = fgetcsv($file, 1000, ",")) !== FALSE) {
            $item_code = $column[0];
            $item_name = $column[1];
            $qty       = $column[2];
            $harga     = $column[3];

            $query = "INSERT INTO daftar_barang (item_code, item_name, qty, harga) 
                      VALUES ('$item_code', '$item_name', '$qty', '$harga') 
                      ON DUPLICATE KEY UPDATE item_name='$item_name', qty='$qty', harga='$harga'";
            mysqli_query($koneksi, $query);
        }
        fclose($file);
        header("location:index.php?import=success");
    }
}
?>