<?php 

$conn = mysqli_connect("localhost","root","","suratsmw");

    function tambah($data) {
      global $conn;
    
      $no_surat = htmlspecialchars($data["no_surat"]);
      $tanggal_surat = htmlspecialchars($data["tanggal_surat"]);
      $perihal = htmlspecialchars($data["perihal"]);
      $tanggal_terima = htmlspecialchars($data["tanggal_terima"]);
      $followup = htmlspecialchars($data["followup"]);
      $nama_paraf = htmlspecialchars($data["nama_paraf"]);

      $query = "INSERT INTO surat_masuk
                  VALUES
                ('','$no_surat', '$tanggal_surat', '$perihal', '$tanggal_terima', '$followup', '$nama_paraf')  
                ";
      mysqli_query($conn, $query);

      return mysqli_affected_rows($conn);
    }
    

    function delete ($no) {
      global $conn;
      mysqli_query($conn, "DELETE FROM surat_masuk WHERE no = $no");

      return mysqli_affected_rows($conn);
    }
?>