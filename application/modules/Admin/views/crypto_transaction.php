<?php include 'header.php' ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <section class="content-header">
                        <span class="">Total Amount</span><br>
                        <span class=""><?php //echo $tokenname; ?><?php echo number_format($sum,2) ;?></span>
                    </section>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">All users</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-header">
                                    <form method="GET" action="<?php echo base_url('Admin/Crypto/'.$url); ?>">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <select class="form-control" name="type">
                                                   
                                                    <option value="user_id" <?php echo $type == 'user_id' ? 'selected' : ''; ?>>
                                                        User ID</option>
                                                 
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="value" class="form-control float-right" value="<?php echo $value; ?>" placeholder="Search">
                                            </div>

                                            <div class="col-md-3">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <p id="demo"></p>
                                    <table class="table table-hover" id="">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>User ID</th>
                                                <th>Hash</th>
                                                <th>to</th>
                                                <th>From</th>
                                                <th>Amount</th>
                                                <th>Token Name</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = ($segament) + 1;
                                            foreach ($transactions as $key => $transaction) {
                                                if ($transaction['transfer_status'] == 0) {
                                                    $transStatus = "Pending";
                                                }else{
                                                    $transStatus = "Clear";

                                                }  
                                            ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $transaction['user_id']; ?></td>
                                                    <td>
                                                        <a href="<?php echo base_url('Admin/Crypto/Transaction/' . $transaction['hash']); ?>"><?php echo $transaction['hash']; ?>
                                                        </a>
                                                    </td>
                                                    <td><a style="color:black" target="_blank" href="https://bscscan.com/address/<?php echo $transaction['to']; ?>"><?php echo $transaction['to']; ?></a></td>
                                                    <td><?php echo $transaction['from']; ?></td>
                                                    <td><?php echo $transaction['value']; ?></td>
                                                    <td><?php echo $transaction['tokenName']; ?></td>
                                                    <td><?php echo $transStatus; ?></td>
                                                    <!-- <td><?php //echo $transaction['transfer_status'] == 1 ? 'Clear' : 'Pending'; ?></td> -->
                                                    <td><?php echo $transaction['createdAt']; ?></td>
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
                                            Showing <?php echo ($segament + 1) . ' to  ' . ($i - 1); ?> of
                                            <?php echo $total_records; ?> entries</div>
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

<?php include 'footer.php' ?>