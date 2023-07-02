<?php 
    require'function.php';

    $no = $_GET["no"];

    if(delete($no) > 0 ) {
        echo"
            <script>
                alert('Data Berhasil Dihapus');
                document.location.href = 'suratkeluar.php';
            <script>
        ";
    } else {
        echo"
            <script>
                alert('Data Gagal Dihapus');
                document.location.href = 'suratkeluar.php';
            <script>
        ";
    }
?>