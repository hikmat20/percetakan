<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">



  <!-- Favicon icon-->
  <link rel="shortcut icon" type="image/x-icon" href="/assets/images/favicon/favicon.ico">

  <!-- Libs CSS -->

  <link rel="stylesheet" href="/assets/libs/prismjs/themes/prism.css">

  <!-- Theme CSS -->
  <link rel="stylesheet" href="/assets/css/theme.min.css">
  <title>Log In | SinarDigital</title>
</head>

<body style="background-image: url('/assets/images/bglogin.jpg');background-size: cover;backdrop-filter: brightness(.7)blur(3px);">
  <!-- container -->
  <div class="container d-flex flex-column">
    <div class="row align-items-center justify-content-center g-0
        min-vh-100">
      <div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">
        <!-- Card -->
        <div class="card smooth-shadow-md">
          <!-- Card body -->
          <div class="card-body p-6">
            <?php if ($this->session->userdata('tmessage')) : ?>
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Failed!</strong> <?= $this->session->userdata('tmessage'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <?php endif; ?>

            <div class="mb-4">
              <!-- <a href="<?= base_url(); ?>"><img src="/assets/images/brand/logo/logo-primary.svg" class="mb-2" alt=""></a> -->
              <!-- <p class="mb-6">Please enter your user information.</p> -->
            </div>
            <!-- Form -->
            <form action="<?= $this->uri->uri_string(); ?>" method="POST" id="frm_login" name="frm_login">
              <!-- Username -->
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" class="form-control" autocomplete="off" name="username" placeholder="Username" required="">
              </div>
              <!-- Password -->
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" class="form-control" autocomplete="off" name="password" placeholder="********" required="">
              </div>
              <!-- Checkbox -->
              <div class="d-lg-flex justify-content-between align-items-center mb-4">
                <!-- <div class="form-check custom-checkbox">
                  <input type="checkbox" class="form-check-input" id="rememberme">
                  <label class="form-check-label" for="rememberme">Remember
                      me</label>
                </div> -->

              </div>
              <div>
                <!-- Button -->
                <div class="d-grid">
                  <button type="submit" id="login" name="login" class="btn btn-primary">Log in</button>
                </div>

                <!-- <div class="d-md-flex justify-content-between mt-4">
                  <div class="mb-2 mb-md-0">
                    <a href="sign-up.html" class="fs-5">Create An
                        Account </a>
                  </div>
                  <div>
                    <a href="forget-password.html" class="text-inherit
                        fs-5">Forgot your password?</a>
                  </div>

                </div> -->
              </div>


            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Scripts -->
  <!-- Libs JS -->
  <script src="/assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Theme JS -->
  <script src="/assets/js/theme.min.js"></script>
</body>

</html>