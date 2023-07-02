<?php 
$conn = mysqli_connect("localhost","root","","suratsmw");

function tambah($data) {
  global $conn;

  $no_surat = htmlspecialchars($data["no_surat"]);
  $tanggal_surat = htmlspecialchars($data["tanggal_surat"]);
  $perihal = htmlspecialchars($data["perihal"]);
  $tujuan = htmlspecialchars($data["tujuan"]);
  $tanggal_followup = htmlspecialchars($data["tanggal_followup"]);
  $nama_paraf = htmlspecialchars($data["nama_paraf"]);

  $query = "INSERT INTO surat_keluar
          VALUES
          ('','$no_surat','$tanggal_surat','$perihal','$tujuan','$tanggal_followup','$nama_paraf')  
        ";

mysqli_query($conn,$query);

return mysqli_affected_rows($conn);
}

?>