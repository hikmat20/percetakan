<?php
    $ENABLE_ADD     = has_permission('Folders.Add');
    $ENABLE_MANAGE  = has_permission('Folders.Manage');
    $ENABLE_VIEW    = has_permission('Folders.View');
    $ENABLE_DELETE  = has_permission('Folders.Delete');
	$ENABLE_DOWNLOAD  = has_permission('Folders.Download');
?>

<div class="row">
        <?php
		if($ENABLE_ADD){
		?>
          <!-- ./col -->
		  <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-blue">
              <div class="inner">
			    <h4><b>CREATE DOKUMEN</b></h4>
                <p>&nbsp;</p>
              </div>
              <div class="icon">
                <i class="fa fa-folder-open"></i>
              </div>
             <a href='http://103.228.117.98/sentraldocs/folders' class="small-box-footer">	
			  <b>More info</b> <i class="fa fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
		<?php
		}
		if($ENABLE_VIEW){
		?>
		   <div class="col-lg-3 col-6">
		     <!-- small card -->
            <div class="small-box bg-green">
              <div class="inner">
                <h4><b>LIST DOKUMEN</b></h4>
                <p>&nbsp;</p>
              </div>
              <div class="icon">
                <i class="fa fa-list"></i>
              </div>
			  <a href='http://103.228.117.98/sentraldocs/dokumen' class="small-box-footer">	
			  <b>More info</b> <i class="fa fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          
          <!-- ./col -->
		  
        <?php
		}
		?>
         

</div>

<!-- /.row -->
           
