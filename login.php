<?php

session_start();

if(isset($_SESSION["login"])) {


    header("Location: index.php");
    exit;
}
require 'function.php';

  
        if(isset($_POST["login"])) {
            //mengambil data usernam dan pass dari $_POST
            $username = $_POST["username"];
            $password = $_POST["password"];

            $result = mysqli_query($con, "SELECT *FROM users WHERE username = '$username'");

            
                # code...
            
            
            // login:
            //ccek username
            //kalo ketemu nilanya 1 kalo tidak 0
            if(mysqli_num_rows($result) === 1 ) { //untuk hitung ada berapa baris yang dikembalikan dari fungsi SELECT


                $row = mysqli_fetch_assoc($result);
                if(password_verify($password, $row["password"])) { //diambil dari $row = $result berdasarkan $username

                    $_SESSION["login"] = true;
                    $_SESSION["role"] = $row["role"];

                    if ($_SESSION["role"] === "admin") {
                        header('Location: index.php');
                        exit;
                    } elseif ($_SESSION["role"] === "pengguna") {
                        header('Location: dasboard.php');
                        exit;
                    }
                 
                }
            } 
             // jika tidak ada username akan langusng ke $eror = true;
            //jika passwors salah akan demikian
            $error = true;

            } 
  
?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content />
        <meta name="author" content />
        <title>Login</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Custom Google font-->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>
    <body class="d-flex flex-column">
        <main class="flex-shrink-0">
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
                <div class="container px-5">
                    <a class="navbar-brand" href="index.html"><span class="fw-bolder text-primary">.Hello</span></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                </div>
            </nav>
            <!-- Page content-->
            <section class="py-5">
                <div class="container px-5">
                    <!-- Contact form-->
                    <div class="bg-light rounded-4 py-5 px-4 px-md-5">
                        <div class="text-center mb-5">
                            <div class="feature bg-primary bg-gradient-primary-to-secondary text-white rounded-3 mb-3"><i class="bi bi-person-circle"></i></div>
                            <h1 class="fw-bolder">Login</h1>
                            <p class="lead fw-normal text-muted mb-0">Let's work together!</p>
                        </div>
                        <div class="row gx-5 justify-content-center">
                            <div class="col-lg-8 col-xl-6">
                              
                                <form method="post" data-sb-form-api-token="API_TOKEN">
                                    <!-- Name input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="username" type="text" placeholder="Enter your name..." data-sb-validations="required" />
                                        <label for="name">Username</label>
                                        <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                                    </div>
                                    <!-- Email address input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="password" type="password" placeholder="name@example.com" data-sb-validations="required,password" />
                                        <label for="password">Password</label>
                                    </div>
                                    <!-- <div class="form-floating mb-3">
                                        <input class="form-control" id="captcha" name="captcha" type="teks" placeholder="name@example.com" data-sb-validations="required,password" />
                                        <label for="password">Captcha</label>
                                        <img src="captcha.php" alt="CAPTCHA" class="mt-3">
                                    </div> -->
                                    
                                   
                                    <div class="d-grid">
                                        <button name="login" class="btn btn-primary btn-lg " type="submit">Login</button>
                                        <p id="login" class="lead fw-normal text-muted mb-0" style="justify-content: center; display: flex; margin: 10px;">You don't have an account? <a href="register.php" style="margin-left: 10px;">Sign Up</a></p>
                                    </div>
                                   
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <!-- Footer-->
        <footer class="bg-white py-4 mt-auto">
            <div class="container px-5">
                <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                    <div class="col-auto"><div class="small m-0">Copyright &copy; Your Website <?php echo date("Y") ?></div></div>
                    <div class="col-auto">
                        <a class="small" href="#!">Privacy</a>
                        <span class="mx-1">&middot;</span>
                        <a class="small" href="#!">Terms</a>
                        <span class="mx-1">&middot;</span>
                        <a class="small" href="#!">Contact</a>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>