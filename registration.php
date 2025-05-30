
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Pages / Register - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>
<?php 
session_start();
?>
<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

    

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Enter your personal details to create account</p>
                  </div>

                  <form class="row g-3 needs-validation" action="./controllers/registration.php" method="POST" novalidate >

                    <div class="col-12">
                      <label for="yourName" class="form-label">First Name</label>
                      <input type="text" name="firstName" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Please, enter your first name!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourName" class="form-label">Last Name</label>
                      <input type="text" name="lastName" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Please, enter your last name!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourName" class="form-label">Email Address</label>
                      <input type="text" name="email" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Please, enter your email address!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourName" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Please, enter your password!</div>
                    </div>
                   
                    <div class="col-12">
                      <label for="yourName" class="form-label">Confirm Password</label>
                      <input type="password" name="cpassword" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Please, confirm your password!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourName" class="form-label">Phone Number</label>
                      <input type="text" name="phoneNumber" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Please, enter your phone number!</div>
                    </div>

                    

                    <div class="col-12">
                        <div class="row mb-3">
                            <label class="col-lg-3 col-form-label">Gender</label>
                            <div class="col-lg-9">
                                <select class="form-select" name = "gender" aria-label="Default select example" required>
                                <option selected disabled>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row mb-3">
                            <label for="inputDate"  class="col-lg-3 col-form-label">Birthday</label>
                            <div class="col-lg-9">
                                <input type="date" name = "birthday" class="form-control" required>
                            </div>
                        </div>
                    </div>

                
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="registration">Create Account</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="./login.php">Log in</a></p>
                    </div>
                  </form>

                </div>
              </div>



            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>


  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <?php
if (isset($_SESSION['message']) && isset($_SESSION['code']) && $_SESSION['code'] != '') {
?>
<script>
  const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.onmouseenter = Swal.stopTimer;
      toast.onmouseleave = Swal.resumeTimer;
    }
  });
  Toast.fire({
    icon: "<?php echo htmlspecialchars($_SESSION['code']); ?>",
    title: "<?php echo htmlspecialchars($_SESSION['message']); ?>"
  });
</script>
<?php
  unset($_SESSION['message']);
  unset($_SESSION['code']);
}
?>


</body>

</html>