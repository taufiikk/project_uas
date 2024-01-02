<?php 

    //koneksi ke database
    $con = mysqli_connect("localhost", "root", "", "dbuas");


      function query($query){
        global $con;
        $result = mysqli_query($con, $query);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
            return $rows;
    }


    function tambah($data) {
            global $con;

            $nama = htmlspecialchars($data["name"]);
            // $gambar = htmlspecialchars($data["gambar"]);
            $no_gambar = htmlspecialchars($data["descrip"]);

            

            // // upload gambar
            $gambar = upload();
            if(!$gambar) {

                return false;
                
            }

            $query = "INSERT INTO gambar VALUES('', '$nama', '$gambar', '$no_gambar')";

            mysqli_query($con, $query);

            return mysqli_affected_rows($con);
    }

    function upload() {
        

        $filename = $_FILES['gambar']['name'];
        $sizeFile = $_FILES['gambar']['size'];
        $error = $_FILES['gambar']['error'];
        $tmpName = $_FILES['gambar']['tmp_name'];

        //yg di upload gambar atau bukan
        if($error === 4) {
            echo "<script>
                alert('pilh gambar dulu');
                </script>";

                return false;
        }

        //upload harus gambar

        $ekstensiWajib = ['jpg', 'jpeg', 'png'];
        $eksetensiGambar = explode('.', $filename);
        $eksetensiGambar = strtolower(end($eksetensiGambar));

        if(!in_array($eksetensiGambar, $ekstensiWajib)) {
            echo  "<script>
            alert('yang anda upload bukan gambar');
            </script>";

            return false;
        }

        //cek ukuran gamba
        if($sizeFile > 10000000) {
            echo  "<script>
            alert('Maksimal 1MB');
            </script>";

            return false;
        }

        // cek jika nama sama
        $newFilename = uniqid();
        $newFilename .= '.'; //dirangkai dengan titik
        $newFilename .= $eksetensiGambar; //dirangkai dengan ekstensi gambar
        


        //jika lolos pengecekan
        move_uploaded_file($tmpName, 'img/'.$newFilename);

        return $newFilename;
        //supaya ke $gambar di function tambah();
    }

    function delete($id) {
        global $con;

        mysqli_query($con, "DELETE FROM gambar WHERE id = $id");

        return mysqli_affected_rows($con);
    }


    function ubah($data) {
        if (!isset($data["id"])) {
            return -1; // Keluar fungsi jika 'id' tidak ditemukan
        }
        global $con;

        $id = $data["id"];
        $nama = htmlspecialchars($data["name"]);
        
        $no_gambar = htmlspecialchars($data["descrip"]);
        
        $gambarLama = htmlspecialchars($data["gambarLama"]);

        //jika user tidak pilih tomnol upload atau user pilih gambar baru atau tidak.
        //jika gambar error = 4 atau tidak ada gambar di upload maka gambar diisi dengan gambar lama melalui input hidden
        //jika selain 4, kalo ada gambarnya nilainya berubah menjadi 4 maka akan diisi dengan $gambar = upload();
        if($_FILES['gambar']['error'] === 4 ) {
            $gambar = $gambarLama;
        } else {
            $gambar = upload();
        }

        $query = "UPDATE gambar SET 
                    
                    nama = '$nama',
                    gambar = '$gambar',
                    descrip = '$no_gambar' WHERE id = $id";

        mysqli_query($con, $query);

        return mysqli_affected_rows($con);
    }

    function cari($keyword) {
        global $con;

        $query = "SELECT * FROM gambar WHERE
                nama LIKE '%$keyword%' OR
                gambar LIKE '%$keyword%' OR
                no_gambar LIKE '%$keyword%'";

               return query($query); 
    }

    function register($data, $role = 'pengguna') {
        global $con;

        $username = strtolower(stripcslashes($data['username']));
        $email= strtolower(stripcslashes($data['email'])); 
        $password = mysqli_real_escape_string($con, $data['password']);
        $password2 = mysqli_real_escape_string($con, $data['password2']);

        
       

        //cek username sudah ada atau belum
        $result = mysqli_query($con, "SELECT username FROM users WHERE username = '$username'");
        if(mysqli_fetch_assoc($result)) {
            echo "
            <script> 
                alert('username sudah terdaftar! gunakan email lain');
            </script> ";

            return false;

        }


        //cek konirmasi password
        if($password !== $password2) {
            echo "
            <script> 
                alert('password tidak sesuai!');
            </script> ";

            return false;
        }
       

        //cek enkripsi password
        $password = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($con, "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')");

         return mysqli_affected_rows($con);
        //untuk menghasilkan angka 1 jika berhasil dan -1 jika gagal
    
    }


    function registerAd($data, $role = 'admin') {
        global $con;

        $username = strtolower(stripcslashes($data['username']));
        $email= strtolower(stripcslashes($data['email'])); 
        $password = mysqli_real_escape_string($con, $data['password']);
        $password2 = mysqli_real_escape_string($con, $data['password2']);

        
       

        //cek username sudah ada atau belum
        $result = mysqli_query($con, "SELECT username FROM users WHERE username = '$username'");
        if(mysqli_fetch_assoc($result)) {
            echo "
            <script> 
                alert('username sudah terdaftar! gunakan email lain');
            </script> ";

            return false;

        }

        // if(mysqli_fetch_assoc($result)) {
        //     echo "<script> alert('Username already registered!'); </script>";
        //     return false;
        // }

        //cek konirmasi password
        if($password !== $password2) {
            echo "
            <script> 
                alert('password tidak sesuai!');
            </script> ";

            return false;
        }
       

        //cek enkripsi password
        $password = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($con, "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')");

         return mysqli_affected_rows($con);
         
        //untuk menghasilkan angka 1 jika berhasil dan -1 jika gagal
    
    }
    
   
?>