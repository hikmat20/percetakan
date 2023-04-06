<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?php echo $nama_program; ?></title>
  <style>
    /* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */
    body {
      font-family: "Open Sans", sans-serif;
      height: 100vh;
      background: url("<?php echo site_url(); ?>assets/img/background1.jpg") 100% fixed;
      background-size: cover;
    }

    @keyframes spinner {
      0% {
        transform: rotateZ(0deg);
      }

      100% {
        transform: rotateZ(359deg);
      }
    }

    * {
      box-sizing: border-box;
    }

    .wrapper {
      display: flex;
      align-items: center;
      flex-direction: column;
      justify-content: center;
      width: 100%;
      min-height: 100%;
      padding: 20px;
      background: rgba(43, 127, 64, 0.85);
    }

    .login {
      border-radius: 2px 2px 5px 5px;
      padding: 10px 20px 20px 20px;
      width: 90%;
      max-width: 320px;
      background: #ffffff;
      position: relative;
      padding-bottom: 80px;
      box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.3);
    }

    .login.loading button {
      max-height: 100%;
      padding-top: 50px;
    }

    .login.loading button .spinner {
      opacity: 1;
      top: 40%;
    }

    .login.ok button {
      background-color: #8bc34a;
    }

    .login.ok button .spinner {
      border-radius: 0;
      border-top-color: transparent;
      border-right-color: transparent;
      height: 20px;
      animation: none;
      transform: rotateZ(-45deg);
    }

    .login input {
      display: block;
      padding: 15px 10px;
      margin-bottom: 10px;
      width: 100%;
      border: 1px solid #ddd;
      transition: border-width 0.2s ease;
      border-radius: 2px;
      color: #ccc;
    }

    .login input+i.fa {
      color: #fff;
      font-size: 1em;
      position: absolute;
      margin-top: -47px;
      opacity: 0;
      left: 0;
      transition: all 0.1s ease-in;
    }

    .login input:focus {
      outline: none;
      color: #444;
      border-color: #00a65a;
      border-left-width: 35px;
    }

    .login input:focus+i.fa {
      opacity: 1;
      left: 30px;
      transition: all 0.25s ease-out;
    }

    .login a {
      font-size: 0.8em;
      color: #00a65a;
      text-decoration: none;
    }

    .login .title {
      color: #444;
      font-size: 1.2em;
      font-weight: bold;
      margin: 10px 0 30px 0;
      border-bottom: 1px solid #eee;
      padding-bottom: 20px;
    }

    .login button {
      width: 100%;
      height: 100%;
      padding: 10px 10px;
      background: #00a65a;
      color: #fff;
      display: block;
      border: none;
      margin-top: 20px;
      position: absolute;
      left: 0;
      bottom: 0;
      max-height: 60px;
      border: 0px solid rgba(0, 0, 0, 0.1);
      border-radius: 0 0 2px 2px;
      transform: rotateZ(0deg);
      transition: all 0.1s ease-out;
      border-bottom-width: 7px;
    }

    .login button .spinner {
      display: block;
      width: 40px;
      height: 40px;
      position: absolute;
      border: 4px solid #ffffff;
      border-top-color: rgba(255, 255, 255, 0.3);
      border-radius: 100%;
      left: 50%;
      top: 0;
      opacity: 0;
      margin-left: -20px;
      margin-top: -20px;
      animation: spinner 0.6s infinite linear;
      transition: top 0.3s 0.3s ease, opacity 0.3s 0.3s ease, border-radius 0.3s ease;
      box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.2);
    }

    .login:not(.loading) button:hover {
      box-shadow: 0px 1px 3px #074314;
    }

    .login:not(.loading) button:focus {
      border-bottom-width: 4px;
    }

    header {
      -webkit-border-top-left-radius: 4px;
      -webkit-border-top-right-radius: 4px;
      -webkit-border-bottom-right-radius: 0;
      -webkit-border-bottom-left-radius: 0;
      -moz-border-radius-topleft: 4px;
      -moz-border-radius-topright: 4px;
      -moz-border-radius-bottomright: 0;
      -moz-border-radius-bottomleft: 0;
      border-top-left-radius: 4px;
      border-top-right-radius: 4px;
      border-bottom-right-radius: 0;
      border-bottom-left-radius: 0;
      background: #00a65a;
      box-shadow: inset 0px -3px 0px rgba(0, 0, 0, 0.2);
      padding: 20px 10px;
      text-align: center;
      font-size: 26px;
      font-weight: 300;
      color: #fff;
    }





    footer {
      display: block;
      padding-top: 50px;
      text-align: center;
      color: #ddd;
      font-weight: normal;
      text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.2);
      font-size: 0.8em;
    }

    footer a,
    footer a:link {
      color: #fff;
      text-decoration: none;
    }
  </style>
</head>

<body>

  <div class="wrapper">
    <<<<<<< HEAD <?= form_open($this->uri->uri_string(), array('id' => 'frm_login', 'name' => 'frm_login', 'class' => 'login')) ?> <header>
      <font color="green">
        <h3 class='box-title' align='center'><b>Documents Control</b></h3>
        <img src="<?php echo base_url('assets/img/logo.png') ?>" class="img-circle" alt="Logo">
      </font>
      </header>

      =======



      <?= form_open($this->uri->uri_string(), array('id' => 'frm_login', 'name' => 'frm_login', 'class' => 'login')) ?>

      <header>
        <font color="white">
          <h3 class='box-title' align='center'><b>Project Controller</b></h3>
          <img src="<?php echo base_url('assets/img/logo.png') ?>" class="img-circle" alt="Logo">
        </font>
      </header>

      >>>>>>> 103e29958206849e8d6ab102cdae171d54f52c31
      <p class='title'>Log in</p>
      <input type="text" name="username" placeholder="Username" value="<?= set_value('username') ?>" required autofocus>
      <i class="fa fa-user"></i>
      <input type="password" name="password" placeholder="Password" value="" required>
      <i class="fa fa-key"></i>
      <<<<<<< HEAD <button type="submit" name="login">Sign In</button>
        </form>
        <footer>
          <font color="white">
            <p>Copyright &copy; <?php echo $idt->nm_perusahaan; ?> 2018</p>
            <p>Halaman ini dimuat selama <strong>{elapsed_time}</strong> detik</p>
          </font>
        </footer>
        </p>
  </div>
  <script src="<?php echo base_url(); ?>assets/login/js/index.js"></script>
  =======

  <button type="submit" name="login">Sign In</button>
  </form>
  <footer>
    <font color="white">
      <p>Copyright &copy; <?php echo $idt->nm_perusahaan; ?> 2021</p>
      <p>Halaman ini dimuat selama <strong>{elapsed_time}</strong> detik</p>
    </font>
  </footer>
  </p>
  </div>
  <script src="<?php echo base_url(); ?>assets/login/js/index.js"></script>
  >>>>>>> 103e29958206849e8d6ab102cdae171d54f52c31
</body>

</html>