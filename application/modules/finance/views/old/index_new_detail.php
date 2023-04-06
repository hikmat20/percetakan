<?php
$ENABLE_ADD     = has_permission('Folders.Add');
$ENABLE_MANAGE  = has_permission('Folders.Manage');
$ENABLE_VIEW    = has_permission('Folders.View');
$ENABLE_DELETE  = has_permission('Folders.Delete');
$ENABLE_DOWNLOAD  = has_permission('Folders.Download');
?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-stretch shadow card-custom">
                <div class="card-body">
                    <button type="button" onclick="history.go(-1)" class="btn btn-icon text-dark-95 bg-white bg-hover-secondary" title="Kembali">
                        <i class="fa fa-arrow-left"></i>
                    </button>
                    <hr class="my-8">
                    <!-- <button type="button" id="btn-rename" class="btn btn-icon text-dark-95 bg-white m-1 bg-hover-secondary" title="Rename">
                <i class="fa fa-pen"></i>
            </button>
            <button type="button" id="btn-delete" class="btn btn-icon text-dark-95 bg-white m-1 bg-hover-secondary" title="Delete">
                <i class="fa fa-trash"></i>
            </button> -->
            
                    <h4 for="">Master Dokumen</h4>
                    <div class="row">
                        <?php if ($masDoc) :
                            foreach ($masDoc as $data) :
                        ?>
                                <div class="col-lg-3 col-xl-2 col-md-3 col-sm-6 col-xs-6 m-0 px-2">
                                    <div class="card bg-transparent card-custom my-2 overlay shadow-none">
                                        <div class="card-body p-0" title="<?= $data->nama_file; ?>">
                                            <div class="overlay-wrapper text-center">
                                                <i class="fa fa-file-alt p-3 text-muted" style="font-size:7rem;"></i><br>
                                                <div class="p-3">
                                                    <div class="card-title m-0">
                                                        <?= $data->deskripsi; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="overlay-layer">
                                                <a href="javascript:void(0)" data-id="<?= $data->id; ?>" data-file="<?= $data->nama_file; ?>" data-table="gambar1" class="view btn btn-icon btn-warning btn-sm btn-shadow" title="View Dokumen"><i class="fa fa-eye"></i></a>
                                                <a href="javascript:void(0)" onclick="location.href = siteurl+active_controller+'download_detail1/<?= $data->id; ?>'" data-id="<?= $data->id; ?>" data-file="<?= $data->nama_file; ?>" data-table="gambar1" class="download btn btn-icon btn-info btn-sm btn-shadow ml-2" title="Download Dokumen"><i class="fa fa-download"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <hr class="my-8">
                    <h4 for="">Lampiran Dokumen</h4>
                    <div class="row">
                        <?php if ($row) :
                            foreach ($row as $data) :
                        ?>
                                <div class="col-lg-3 col-xl-2 col-md-3 col-sm-6 col-xs-6 m-0 px-2">
                                    <div class="card bg-transparent card-custom my-2 overlay shadow-none">
                                        <div class="card-body p-0" title="<?= $data->nama_file; ?>">
                                            <div class="overlay-wrapper text-center">
                                                <i class="fa fa-file-alt p-3 text-muted" style="font-size:7rem;"></i><br>
                                                <div class="p-3">
                                                    <div class="card-title m-0">
                                                        <?= $data->deskripsi; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="overlay-layer">
                                                <a href="javascript:void(0)" data-id="<?= $data->id; ?>" data-file="<?= $data->nama_file; ?>" data-table="gambar1" class="view btn btn-icon btn-warning btn-sm btn-shadow" title="View Dokumen"><i class="fa fa-eye"></i></a>
                                                <a href="javascript:void(0)" onclick="location.href = siteurl+active_controller+'download_detail1/<?= $data->id; ?>'" data-id="<?= $data->id; ?>" data-file="<?= $data->nama_file; ?>" data-table="gambar1" class="download btn btn-icon btn-info btn-sm btn-shadow ml-2" title="Download Dokumen"><i class="fa fa-download"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalView" tabindex="-1" role="dialog" aria-labelledby="exampleModalSizeSm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 1360px !Important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="viewData"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#example1').DataTable({
        orderCellsTop: false,
        fixedHeader: true,
        scrollX: true,
        ordering: false,
        info: false
    });

    $(document).ready(function() {
        $('#btn-add').click(function() {
            loading_spinner();
        });

    });

    function new_folder() {
        Swal.fire({
            html: "<input id='folder_name' required class='form-control' name='new-folder' placeholder='New Folder'>",
            showCancelButton: true
        }).then(function(result) {
            if (result.value) {
                let folder_name = $('#folder_name').val()
                if (folder_name == '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Nama tidak boleh kosong!',
                    })
                } else {
                    $.ajax({
                        url: base_url + active_controller + 'add',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            folder_name
                        },
                        success: function(result) {
                            if (result.status == '1') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Folder baru berhasil dibuat!',
                                }).then(function() {
                                    location.reload()
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjssadi kesalahan tidak terduga!',
                                    text: result.pesan
                                })
                            }
                        },
                        error: function(result) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadiaa kesalahan tidak terduga!',
                                text: result.pesan
                            })
                        }
                    })
                }
            }
        });
    }

    $(document).on('focus', '.button-master', function() {
        $('.button-master').removeClass('active');
        $(this).toggleClass('active');
        $('#btn-rename').attr('data-id', $(this).data('id'))
        $('#btn-delete').attr('data-id', $(this).data('id'))
    })

    $(document).on('blur', 'body', function() {

        $('.button-master').removeClass('active');
        $('#btn-rename').attr('data-id', '')
        $('#btn-delete').attr('data-id', '')
    })


    function delData(id) {
        swal({
                title: "Are you sure?",
                text: "You will not be able to process again this data!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, Process it!",
                cancelButtonText: "No, cancel process!",
                closeOnConfirm: true,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    loading_spinner();
                    window.location.href = base_url + 'index.php/' + active_controller + '/delete/' + id;

                } else {
                    swal("Cancelled", "Data can be process again :)", "error");
                    return false;
                }
            });

    }

    $(document).on('click', '.view', function(e) {
        var id = $(this).data('id');
        var table = $(this).data('table');
        var file = $(this).data('file');
        // alert(id + ", " + table + ", " + file)
        $.ajax({
            type: "post",
            url: siteurl + active_controller + 'history_revisi',
            data: "id=" + id + "&table=" + table + "&file=" + file,
            success: function(result) {
                // $(".modal-dialog").css('max-width', '1360px !important');
                $(".modal-title").html("<b>VIEW DATA</b>");
                $("#viewData").html(result);
                $("#ModalView").modal('show');
            }
        })
    })
</script>