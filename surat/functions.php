<?php 
    // koneksi ke database

    //$server="localhost";
    //$user="root";
    //$pass="";
    //$database="suratsmw";

    //$conn = mysqli_connect("$server,$user,$pass,$database");




    $conn = mysqli_connect("localhost","root","","suratsmw");

    function query($query) {
         global $conn;
         $result = mysqli_query($conn, $query);
         $rows = [];
         while ($row = mysqli_fetch_assoc($result) ) {
             $rows[] = $row;
         }
        return $rows;
    }

    function keyword ($keyword) {
        $query = "SELECT * FROM surat_keluar
                WHERE
                no_surat LIKE '%$keyword%' OR
                perihal LIKE '%$keyword%' 
                ";
         return query($query);
    }

    function tambah($data) {
        global $conn;
      
        $no_surat = htmlspecialchars($data["no_surat"]);
        $tanggal_surat = htmlspecialchars($data["tanggal_surat"]);
        $perihal = htmlspecialchars($data["perihal"]);
        $tujuan = htmlspecialchars($data["tujuan"]);
        $tanggal_followup = htmlspecialchars($data["tanggal_followup"]);
        $nama_paraf = htmlspecialchars($data["nama_paraf"]);

        $file_surat = upload();
        if(!$file_surat) {
            return false;
        }
      
        $query = "INSERT INTO surat_keluar
                VALUES
                ('','$no_surat','$tanggal_surat','$perihal','$tujuan','$tanggal_followup','$nama_paraf', '$file_surat')  
              ";
        mysqli_query($conn,$query);
      
        return mysqli_affected_rows($conn);
      }

      function upload() {
        $nama_file = $_FILES['file_surat']['name'];
        $ukuran_file = $_FILES['file_surat']['size'];
        $error = $_FILES['file_surat']['error'];
        $tmp_name = $_FILES['file_surat']['tmp_name'];

        if ($error === 4) {
            echo"<script>
                    alert('Pilih File Terlebih ahulu');           
                </script)";
            return false;
        }

        $ekstensifilevalid = ['pdf','docx'];
        $ekstensifile = explode('.', $nama_file);
        $ekstensifile = strtolower(end($ekstensifile));
        if(!in_array($ekstensifile,$ekstensifilevalid)) {
            echo"<script>
                     alert('Yang Anda Upload Bukan File');           
                </script)";  
            return false;
        }

        if($ukuran_file > 5000000) {
            echo"<script>
                    alert('Ukuran File Terlalu Besar');           
                </script)";
            return false;
        }

        $namafilebaru = uniqid(); 
        $namafilebaru .= '.';
        $namafilebaru .= $ekstensifile;

        move_uploaded_file($tmp_name, 'filesuratkeluar/'. $namafilebaru);

        return $namafilebaru;
    }

    function edit($data) {
        global $conn;

        $no = $data["no"];
        $no_surat = htmlspecialchars($data["no_surat"]);
        $tanggal_surat = htmlspecialchars($data["tanggal_surat"]);
        $perihal = htmlspecialchars($data["perihal"]);
        $tujuan = htmlspecialchars($data["tujuan"]);
        $tanggal_followup = htmlspecialchars($data["tanggal_followup"]);
        $nama_paraf = htmlspecialchars($data["nama_paraf"]);

        $filelama = htmlspecialchars($data["filelama"]);

        if( $_FILES['file_surat']['error'] === 4) {
            $file_surat = $filelama;
        }  else {
            $file_surat = upload();
        }
        
      
        $query = "UPDATE surat_keluar SET
                no_surat = '$no_surat',
                tanggal_surat = '$tanggal_surat',
                perihal = '$perihal',
                tujuan = '$tujuan',
                tanggal_followup = '$tanggal_followup',
                nama_paraf = '$nama_paraf',
                file_surat = '$file_surat'

                WHERE no = $no; 
                ";
        mysqli_query($conn,$query);
      
      return mysqli_affected_rows($conn);
    }

    function signup($data) {
        global $conn;

        $username = strtolower (stripcslashes($data["username"]));
        $password = mysqli_real_escape_string($conn, $data["password"]);

        $result = mysqli_query($conn, "SELECT username FROM users
                WHERE username = '$username'");

        if(mysqli_fetch_assoc($result)) {
            echo" <script>
                    alert('Username sudah Terdaftar')
                </script>";
                
            return false;
        }

        $password = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($conn, "INSERT INTO users VALUES('','$username', '$password')");
        return mysqli_affected_rows($conn);
    }

?>