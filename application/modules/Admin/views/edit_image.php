<?php include 'header.php' ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><?php echo $header; ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <!-- <li class="breadcrumb-item">Shoppingt</li> -->
                        <li class="breadcrumb-item active"><?php echo $header; ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="card-body">
              <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <?php echo form_open_multipart(); ?>
                    <div class="kt-portlet__body">
                        <h2><?php echo $this->session->flashdata('message'); ?></h2>
                        <div class="form-group">
                            <label>Achiever Name</label>
                            <div></div>
                            <?php
                            echo form_input(array('type' => 'text', 'class' => 'form-control', 'name' => 'name'));
                            ?>
                            <span class="text-danger"><?php echo form_error('name'); ?></span>
                        </div>
                        <div class="form-group">
                            <label>Achiever Image</label>
                            <input type="file" name="Pimage" class="form-control" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" />
                            <!-- <input type="file" name="Pimage" class="form-control" /> -->
                        </div>

                        <div class="" style="margin-bottom:20px;">
                            <?php
                            echo form_input(array('type' => 'submit', 'class' => 'btn btn-primary', 'name' => 'create', 'value' => 'Update'));
                            ?>
                        </div>

                        <!-- <button class="btn btn-success upload-result" type="submit" style="display:block;">Upload</button> -->
                        <?php //echo form_close(); //}
                        ?>
                    </div>
                  
                </div>
                <div class="col-md-6">

                    <img id="blah" style="max-width: 80px;" alt="" class="image-fluid" />


                </div>
                <?php echo form_close(); ?>
            </div>
           
        </div>
    </div>
</div>
<?php include_once 'footer.php'; ?>
<script src="//cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace('long_desc', {
        width: "500px",
        height: "200px"
    });
</script>

<script type="text/javascript">
    $(document).on('submit', '#productImageForm', function(e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var formData = new FormData(this);
        var t = $(this);
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(data) {
                res = JSON.parse(data);
                alert(res.message)
                t.append('<input type="hidden" name="' + res.token_name + '" value="' + res.token_value + '" style="display:none;">')
                if (res.success == 1)
                    location.reload();
            },
            cache: false,
            contentType: false,
            processData: false
        });
    })
</script>