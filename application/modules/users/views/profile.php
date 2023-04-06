<?php
$ENABLE_ADD     = has_permission('Users.Add');
$ENABLE_MANAGE  = has_permission('Users.Manage');
$ENABLE_DELETE  = has_permission('Users.Delete');

?>
<div class="row">
    <div class="col-md-3">
        <div class="box box-widget widget-user-2">
            <div class="widget-user-header bg-maroon">
                <div class="widget-user-image">
                    <img class="img-circle img-thumbnail" src="<?= base_url('assets/img/'); ?><?= $userData->photo; ?>" alt="User Avatar">
                </div>
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username"><?= $userData->nm_lengkap; ?></h3>
                <h5 class="widget-user-desc"><?= ucfirst($userData->level); ?></h5>
            </div>
            <div class="box-footer no-padding">
                <ul class="nav nav-stacked">
                    <li><a href="#">Projects <span class="pull-right badge bg-blue">31</span></a></li>
                    <li><a href="#">Tasks <span class="pull-right badge bg-aqua">5</span></a></li>
                    <li><a href="#">Completed Projects <span class="pull-right badge bg-green">12</span></a></li>
                    <li><a href="#">Followers <span class="pull-right badge bg-red">842</span></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#profile" data-toggle="tab" aria-expanded="false">Profile</a></li>
                <li class=""><a href="#change-password" data-toggle="tab" aria-expanded="true">Ubah Password</a></li>
                <!-- <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Timeline</a></li> -->
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="profile">
                    <div id="alert-msg"></div>
                    <form class="form-horizontal" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="photo" class="col-sm-2 control-label">Photo</label>
                            <div class="col-sm-10">
                                <img id="preview" class="img-thumbnail profile-user-img img-responsive" style="width:200px" src="<?= base_url('assets/img/'); ?><?= $userData->photo; ?>" alt="">
                                <input type="file" name="photo" onchange="preview_image(event)" id="photo" class="hidden">
                                <input type="hidden" name="old_photo" id="old_photo" value="<?= $userData->photo; ?>">
                                <div class="">
                                    <br>
                                    <button class="btn btn-warning" onclick="$('#photo').click()" type="button"><i class="fa fa-upload"></i> Upload Gambar</button>
                                    <br>
                                    <span class="text-center text-muted text-sm">*) Ukuran Max. 500kb, Dimensi Max. 1000 x 1000 pixel</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="full-name" class="col-sm-2 control-label">Full Name</label>
                            <div class="col-sm-10">
                                <input type="text" value="<?= $userData->nm_lengkap; ?>" name="nm_lengkap" class="form-control" id="full-name" placeholder="Full Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>

                            <div class="col-sm-10">
                                <input type="email" value="<?= $userData->email; ?>" name="email" class="form-control" id="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mobile-no" class="col-sm-2 control-label">Mobile No</label>
                            <div class="col-sm-10">
                                <input type="number" name="phone" value="<?= $userData->hp; ?>" class="form-control" id="mobile-no" placeholder="+62 ...">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="city" class="col-sm-2 control-label">Mobile No</label>
                            <div class="col-sm-10">
                                <input type="text" name="city" value="<?= $userData->kota; ?>" class="form-control" id="city" placeholder="Jakarta">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-2 control-label">Address</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="address" id="address" placeholder="Address"><?= $userData->alamat; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                    <label>
                                        <!-- <input type="checkbox"> I agree to ch -->
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="change-password">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">Name</label>

                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="inputName" placeholder="Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">Name</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputName" placeholder="Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                            <div class="col-sm-10">
                                <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputSkills" class="col-sm-2 control-label">Skills</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-danger">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.box -->
<script>
    function preview_image(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('preview');
            output.src = reader.result;

            $.ajax({
                url: siteurl + active_controller + "upload",
                data: formData,
                type: 'POST',
                dataType: 'JSON',
                success: function(result) {
                    if (result.status == '1') {
                        $('#alert-msg').html(`<div class="alert" style="background-color: #dcffe0;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Success!!</strong> Photo Profile berhasil di update.
                        </div>`)
                    } else {
                        $('#alert-msg').html(`<div class="alert" style="background-color: #ff8a8a;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Gagal!!</strong> Photo Profile gagal di update.
                        </div>`)
                    }
                },
                error: function(result) {

                }
            })
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>