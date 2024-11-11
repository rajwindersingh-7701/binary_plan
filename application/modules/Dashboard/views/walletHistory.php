<?php include 'header.php' ?>
<style>
    section.content-header {
        background: #e0e0e0;
        color: #000;
        padding: 8px 16px;
        border-radius: 10px;
    }

    .messageBox {
        padding: 1em;
        background: #002e3666;
        border: #eee solid 2px;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-right: -50%;
        transform: translate(-50%, -50%);
        text-shadow: 0px 0px 8px #000;
        color: #fff;
    }

    #text {
        font-family: Questrial;
        text-align: center;
    }

    #construction {
        font-family: "Pacifico", cursive;
    }
</style>

<!-- <div class="messageBox">
  <h1 id="construction">Coming Soon!</h1>
</div> -->

<?php $none = 0; ?>
<?php //($none == 1){ 
?>
<main>

    <div class="main-content app-content mt-0">
        <!-- BEGIN breadcrumb -->
        <!--<ul class="breadcrumb"><li class="breadcrumb-item"><a href="#">FORMS</a></li><li class="breadcrumb-item active">FORM WIZARS</li></ul>-->
        <!-- END breadcrumb -->
        <!-- BEGIN page-header -->

        <!-- END page-header -->
        <!-- BEGIN wizard -->
        <div class="content mt-3">
            <div id="rootwizard" class="wizard-full-width col-12">
                <div class="panel-heading mb-3">
                    <h4 class="panel-title">Deposit History</h4>
                </div>
                <!-- BEGIN wizard-header -->

                <!-- END wizard-header -->
                <!-- BEGIN wizard-form -->

                <div class="wizard-content tab-content">
                    <!-- BEGIN tab-pane -->
                    <div class="tab-pane active show" id="tabFundRequestForm">
                        <!-- BEGIN row -->
                        <div class="row">
                            <!-- BEGIN col-6 -->
                            <div class="col-md-12">
                                <div class="card card-body mt-0">
                                    <!-- <p class="desc m-b-20" style="margin-top:20px;font-size: 18px;">Make sure to use a valid input, you'll need to verify it before you can submit request.</p> -->
                                    <div class="form-group m-b-10">

                                    </div>
                                    <div class="form-group m-b-10">

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped dataTable" id="tableView">
                                                <thead>
                                                    <tr>
                                                        <th>S No.</th>
                                                        <th>hash</th>
                                                        <th>from</th>
                                                        <th>To</th>
                                                        <th>value</th>
                                                        <th>tokenName</th>
                                                        <th>Date</th>


                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($records as $key => $request) {
                                                    ?>

                                                        <tr>
                                                            <td><?php echo ($key + 1) ?></td>
                                                            <td><a href="<?php echo 'https://bscscan.com/tx/' . $request['hash']; ?>" target="_blank">View</a> </td>
                                                            <!-- <td><?php //echo $request['hash']; 
                                                                        ?></td> -->
                                                            <td><?php echo $request['from']; ?></td>
                                                            <td><?php echo $request['to']; ?></td>
                                                            <td><?php echo $request['value']; ?></td>
                                                            <td><?php echo $request['tokenName']; ?></td>
                                                            <td><?php echo $request['createdAt']; ?></td>


                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>


                                    </div>

                                </div>
                            </div>
                            <!-- END col-6 -->
                        </div>
                        <!-- END row -->
                    </div>
                    <!-- END tab-pane -->
                    <!-- BEGIN tab-pane -->

                </div>
                <!-- END wizard-content -->

                <!-- END wizard-form -->
            </div>
        </div>
        <!-- END wizard -->


    </div>
</main>
<?php //} 
?>





<?php include 'footer.php' ?>