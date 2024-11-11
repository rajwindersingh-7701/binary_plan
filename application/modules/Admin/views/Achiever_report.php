<?php include'header.php' ?>
<div class="main-content">
    <div class="page-content">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <section class="content-header">
            <span class="">Achiever Gallery</span>
            </section>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Achiever Gallery</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
     
    <div>
        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-body">
              <div class="card-header">
                 
              </div>
              
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <p id="demo"></p>
                <table class="table table-hover" id="">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                           
                            <th>Name</th>
                            <th>Joining Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                      $i = ($segament) + 1;
                        foreach ($users as $key => $user) {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><img src="<?php echo base_url('uploads/').$user['image']; ?>" width="100"></td>
                               
                                 <td><?php echo $user['name']; ?></td>
                                 <td><?php echo $user['created_at']; ?></td>
                                 <td>
                                  <a href="<?php echo base_url('Admin/Settings/gallery_delete/'.$user['id']);?>" class="btn btn-danger">Delete</a>
                                  
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>

                    </tbody>
                </table>
              </div>
              <div class="row">
                  <div class="col-sm-12 col-md-5">
                      <div class="dataTables_info" id="tableView_info" role="status" aria-live="polite">
                          Showing <?php echo ($segament + 1) .' to  '.($i -1);?> of
                          <?php echo $total_records;?> entries</div>
                  </div>
                  <div class="col-sm-12 col-md-7">
                      <div class="dataTables_paginate paging_simple_numbers" id="tableView_paginate">
                          <?php
                          echo $this->pagination->create_links();
                          ?>
                      </div>
                  </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
          </div>
      </div>
    </div>
  </div>
   </div>
<?php include'footer.php' ?>
<script>
$(document).on('click','.blockUser',function(){
  var status = $(this).data('status');
  var user_id = $(this).data('user_id');
  var url = "<?php echo base_url('Admin/Management/blockStatus/');?>"+user_id + '/' + status;
  $.get(url,function(res){
    alert(res.message)
    if(res.success == 1)
      location.reload()
  },'json')
})
</script>
<script>
function loadDoc($user) {
  let url = '<?php echo base_url('Admin/Management/notification/?user_id=');?>'+$user;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("demo").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("GET", url, true);
  xhttp.send();
}
</script>