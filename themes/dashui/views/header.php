<!DOCTYPE html>
<html lang="en">

<head>
    <title>Applications</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/logo-l.png" />
    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url(); ?>assets/images/favicon/favicon.ico">

    <!-- Libs CSS -->
    <script src="<?= base_url(); ?>assets/libs/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="<?= base_url(); ?>themes/dashui/assets/libs/prismjs/themes/prism.css">
    <link rel="stylesheet" href="<?= base_url(); ?>themes/dashui/assets/libs/prismjs/plugins/line-numbers/prism-line-numbers.css">
    <link rel="stylesheet" href="<?= base_url(); ?>themes/dashui/assets/libs/prismjs/plugins/toolbar/prism-toolbar.css">
    <link rel="stylesheet" href="<?= base_url(); ?>themes/dashui/assets/libs/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url(); ?>themes/dashui/assets/fonts/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="<?= base_url(); ?>themes/dashui/assets/libs/dropzone/dist/dropzone.css">
    <link rel="stylesheet" href="<?= base_url(); ?>themes/dashui/assets/libs/sweetalert2/sweetalert2.css">
    <link rel="stylesheet" href="<?= base_url(); ?>themes/dashui/assets/libs/select2/css/select2.css">
    <link rel="stylesheet" href="<?= base_url(); ?>themes/dashui/assets\libs\datatables\dataTables.bootstrap5.css">
    <link rel="stylesheet" href="<?= base_url(); ?>themes/dashui/assets/libs/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css">
    <link href="<?= base_url(); ?>themes/dashui/assets/libs/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.0/normalize.css"> -->
    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>themes/dashui/assets/css/theme.min.css">
    <script type="text/javascript">
        var baseurl = "<?= base_url(); ?>";
        var siteurl = "<?php echo site_url(); ?>";
        var base_url = siteurl;
        var controller = '<?php echo $this->uri->segment(1); ?>' + '/';
    </script>
    <style>
        .nav-item {
            padding: 0px 9px;
        }

        a.nav-link.active {
            background-color: #0166c5;
            border-radius: 8px;
        }
    </style>
</head>

<div id="db-wrapper">
    <!-- navbar vertical -->
    <!-- Sidebar -->
    <nav class="navbar-vertical navbar">
        <div class="av-scroller">
            <!-- Brand logo -->
            <a class="navbar-brand" href="/">
                <img src="<?= base_url(); ?>assets/images/logo-l.png" style="height: 3rem;" alt="Logo Percetakan" />
            </a>
            <!-- Navbar nav -->
            <?= $this->menu_generator->show_menus(); ?>
        </div>
    </nav>
    <!-- Page content -->
    <div id="page-content">
        <div class="header @@classList">
            <!-- navbar -->
            <nav class="navbar-classic nav-slimscroll navbar navbar-expand-lg">
                <a id="nav-toggle" href="#"><i data-feather="menu" class="nav-icon me-2 icon-xs"></i></a>
                <div class="ms-lg-3 d-none d-md-none d-lg-block">
                    <!-- Form -->
                    <!-- <form class="d-flex align-items-center">
                            <input type="search" class="form-control" placeholder="Search" />
                        </form> -->

                </div>
                <!--Navbar nav -->
                <ul class="navbar-nav navbar-right-wrap ms-auto d-flex nav-top-wrap">

                    <!-- List -->
                    <div class="name pe-2 text-end" style="border-right: 1px solid #a7a7a7;">
                        <?php if ($shift) : ?>
                            <span class="text-primary fw-bold">
                                Shift : Aktif
                            </span>
                            <br>
                            <small class="name  text-end"><?= $shift->start_shift; ?> </small>
                        <?php else : ?>
                            <span class="text-danger fw-bold">
                                Shift : Tidak Aktif
                            </span>
                            <br>
                            <small class="name  text-end">~</small>
                        <?php endif; ?>
                    </div>
                    <li class="dropdown ms-2">
                        <span class="name"><?= $this->session->User['full_name']; ?></span>
                        <a class="rounded-circle" href="#" role="button" id="dropdownUser" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="avatar avatar-md avatar-indicators avatar-online">
                                <img alt="avatar" src="<?= base_url(); ?>assets/images/avatar/<?= ($this->session->User['photo']) ? $this->session->User['photo'] : 'avatar.png'; ?>" class="rounded-circle" />
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                            <div class="px-4 pb-0 pt-2">
                                <div class="lh-1 ">
                                    <h5 class="mb-1"> <?= $this->session->User['full_name']; ?></h5>
                                    <span href="#" class="text-inherit fs-6"></span>
                                </div>
                                <div class=" dropdown-divider mt-3 mb-2"></div>
                            </div>

                            <ul class="list-unstyled">

                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="me-2 icon-xxs dropdown-item-icon" data-feather="user"></i>Edit
                                        Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="me-2 icon-xxs dropdown-item-icon" data-feather="activity"></i>Activity Log
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="me-2 icon-xxs dropdown-item-icon" data-feather="settings"></i>Account Settings
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('logout'); ?>">
                                        <i class="me-2 icon-xxs dropdown-item-icon" data-feather="power"></i>Sign Out
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="<?= ($this->uri->segment(1) == 'dashboard' || $this->uri->segment(1) == '') ? 'bg-primary' : 'bg-gray'; ?> bg-gray pt-5 pb-22"></div>
        <div class="container-fluid mt-n22 px-6">