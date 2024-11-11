<?php require_once 'header.php';
date_default_timezone_set('Asia/Kolkata');
?>
<?php $userinfo = userinfo(); ?>
<!--**********************************
   Content body start
   ***********************************-->
<style>
   body {
      background: #eaeef2 !important;
   }

   .social_icon img {
      max-width: 45px;
      background-color: #fff;
      border-radius: 5px;
      padding: 2px;
   }

   .dashboard-inner {
      background: url('/uploads/layer.jpg');
      background-size: cover;
      background-repeat: no-repeat;
   }

   .work-image {
      display: block;
      position: relative;
   }

   .popup-btn {
      position: absolute;
      left: 0;
      top: 50%;
      text-align: center;
      right: 0;
      color: #ffffff;
      margin-top: 0;
      font-size: 24px;
      opacity: 0;
      visibility: hidden;
   }

   .work-image:hover .popup-btn {

      visibility: visible;
      margin-top: -15px;

   }

   span.tab-text {
      font-size: 18px;
   }

   /* .bg-color{
   background: #ecf2ff !important;
   }
   .bg1-color{ 
   background: #fef5e5 !important;
   }
   .bg2-color{
   background: #e8f7ff !important;
   }
   .bg3-color{
   background: #fdede8 !important;
   }
   .bg4-color{
   background: #e6fffa !important;

   
   }*/

   body {
      text-align: center;
      background: #00ecb9;
      font-family: sans-serif;
      font-weight: 100;
   }

   .countdown-title {
      color: #396;
      font-weight: 100;
      font-size: 40px;
      margin: 40px 0px 20px;
   }

   .countdown {
      font-family: sans-serif;
      color: #fff;
      display: inline-block;
      font-weight: 100;
      text-align: center;
      font-size: 30px;
   }

   .countdown-number {
      padding: 10px;
      border-radius: 3px;
      background: #00bf96;
      display: inline-block;
   }

   .countdown-time {
      padding: 15px;
      border-radius: 3px;
      background: #00816a;
      display: inline-block;
   }

   .countdown-text {
      display: block;
      padding-top: 5px;
      font-size: 16px;
   }
</style>
<script>
   function countdown(element, seconds) {
      // Fetch the display element
      var el = document.getElementById(element).innerHTML;

      // Set the timer
      var interval = setInterval(function() {
         if (seconds <= 0) {
            //(el.innerHTML = "level lapsed");
            $('#' + element).text('Time  Lapsed')

            clearInterval(interval);
            return;
         }
         var time = secondsToHms(seconds)
         $('#' + element).text(time)

         seconds--;
      }, 1000);
   }

   function secondsToHms(d) {
      d = Number(d);
      var day = Math.floor(d / (3600 * 24));
      var h = Math.floor(d % (3600 * 24) / 3600);
      var m = Math.floor(d % 3600 / 60);
      var s = Math.floor(d % 3600 % 60);

      var dDisplay = day > 0 ? day + (day == 1 ? " day, " : "D ") : "";
      var hDisplay = h > 0 ? h + (h == 1 ? " hour, " : "H ") : "";
      var mDisplay = m > 0 ? m + (m == 1 ? " minute, " : "M ") : "";
      var sDisplay = s > 0 ? s + (s == 1 ? " second" : "S ") : "";
      var t = dDisplay + hDisplay + mDisplay + sDisplay;
      return t;
      // console.log(t)
   }
</script>
<!--app-content open-->


<div class="main-content app-content mt-0">
   <div class="card card-body bg-custom-gr ">
      <div class="page-header pd-bottom">
         <h1 class="page-title">Dashboard </h1>
      </div>
      <!-- <div class="page-header pd-bottom">
         <h6 class="page-title">Timer : <span></span> </h6>
      </div> -->
   </div>
   <div class="side-app box-style">
      <!-- CONTAINER -->
      <div class="main-container container-fluid ">

         <div class="content-box">
            <div class="col-md-12">

            </div>
            <div class="row">
               <!-- <h1>6 AM Reverse Timer</h1> -->
               <!-- <p id="timer"></p> -->
               <!-- <div id="clock"></div> -->

               <!-- <script src="countdown_to_6am.js"></script> -->

               <!-- <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 d-grid">
                  <div class="dashboard-item">
                     <div class="dashboard-inner">
                        <div class="box_img">
                        </div>
                        <div class="box_content flex-custom">
                           <div id="clock"></div>

                           <script src="countdown_to_6am.js"></script>
                        </div>
                     </div>
                  </div>
               </div> -->

              <?php
              if($user['total_limit'] == $user['pending_limit'] && $user['paid_status'] > 0){
              ?>
               <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 d-grid">
                  <div class="dashboard-item">
                     <div class="dashboard-inner">
                        <div class="box_img">
                        </div>
                        <div class="box_content flex-custom">
                           <h5 class="m-0 amount"></h5>
                           <p class="title-box text-danger">Please Retopup Your Account </p>
                        </div>
                     </div>
                  </div>
               </div>
               <?php
              }
              ?>
               <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 d-grid">
                  <div class="dashboard-item">
                     <div class="dashboard-inner">
                        <div class="box_img">
                        </div>
                        <div class="box_content flex-custom">
                           <h5 class="m-0 amount"><?php echo currency; ?> <?php echo $user['total_package']; ?> </h5>
                           <p class="title-box">Subscription Package</p>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 d-grid">
                  <div class="dashboard-item">
                     <div class="dashboard-inner">
                        <div class="box_img">
                        </div>
                        <div class="box_content flex-custom">
                           <h5 class="m-0 amount"><?php echo currency; ?> <?php echo $wallet_balance['wallet_balance']; ?> </h5>
                           <p class="title-box">E-wallet</p>
                        </div>
                     </div>
                  </div>
               </div>

               <?php
               $incomes = $this->config->item('incomes');
               foreach ($incomes as $incKey => $inc) :
                  $table = "tbl_income_wallet";
                  $getBalance = $this->User_model->get_single_record($table, ['user_id' => $this->session->userdata['user_id'], 'type' => $incKey], 'ifnull(sum(amount),0) as balance');

               ?>
                  <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 d-grid">
                     <div class="dashboard-item">
                        <div class="dashboard-inner">
                           <div class="box_img">
                           </div>
                           <div class="box_content flex-custom">
                              <h5 class="m-0 amount"><?php echo currency; ?><?php echo round($getBalance['balance'], 2); ?></h5>
                              <p class="title-box"><?php echo $inc; ?></p>
                           </div>
                        </div>
                     </div>
                  </div>
               <?php
               endforeach;
               ?>

               <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 d-grid">
                  <div class="dashboard-item">
                     <div class="dashboard-inner">
                        <div class="box_img">
                        </div>
                        <div class="box_content flex-custom">
                           <h5 class="m-0 amount"><?php echo currency; ?><?php echo number_format($total_income['total_income'], 2); ?></h5>
                           <p class="title-box">Total Earning</p>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 d-grid">
                  <div class="dashboard-item">
                     <div class="dashboard-inner">
                        <div class="box_img">
                        </div>
                        <div class="box_content flex-custom">
                           <h5 class="m-0 amount"><?php echo currency; ?> <?php echo abs($total_withdrawal['balance']); ?></h5>
                           <p class="title-box">Withdrawal Amount</p>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 d-grid">
                  <div class="dashboard-item">
                     <div class="dashboard-inner">
                        <div class="box_img">
                        </div>
                        <div class="box_content flex-custom">
                           <h5 class="m-0 amount"><?php echo currency; ?><?php echo ($income_balance['income_balance'] > 0) ? round($income_balance['income_balance'], 2) : 0; ?></h5>
                           <p class="title-box">Available Balance</p>
                        </div>
                     </div>

                  </div>
               </div>

               <?php if (registration == 1) { ?>
                  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 d-grid">
                     <div class="dashboard-item">
                        <div class="dashboard-inner add-exp">
                           <div class="box_img">
                           </div>
                           <div class="box_content flex-custom">
                              <div class="add-prom">
                                 <div class="add-left">
                                    <p class="title-box">Left Business</p>
                                    <h5 class="m-0 amount"><?php echo currency; ?><?php echo ($userinfo->leftBusiness > 0) ? round($userinfo->leftBusiness, 2) : 0; ?></h5>
                                 </div>
                                 <div class="add-right">
                                    <p class="title-box">Right Business</p>
                                    <h5 class="m-0 amount"><?php echo currency; ?><?php echo ($userinfo->rightBusiness > 0) ? round($userinfo->rightBusiness, 2) : 0; ?></h5>
                                 </div>

                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
            </div>


         </div>
      </div>

      <div class="row mt-2">
         <div class="col-md-12 col-lg-12 col-xl-12  box-bottom-m ">
            <div class="card mt-0 mb-0  add-img">
               <div class="card-header justify-content-between">
                  <h5 class="card-title mb-0">Total Direct Team</h5>
                  <h3 class="fw-normal mb-0">
                     <?php echo  $paid_directs['paid_directs'] + $free_directs['free_directs']; ?>
                  </h3>
               </div>
               <div class="card-body">
                  <ul class="p-0 m-0 custombx">
                     <li class="mb-3 display_flex justify-content-between">
                        <div class="d-flex align-items-center lh-1 me-3 ">
                           <span class="badge badge-dot bg-success me-2"></span>
                           Direct Team
                        </div>
                        <div class="display_flex gap-3">
                           <span class="fw-semibold tab-text">Active - <?php echo $paid_directs['paid_directs']; ?></span>
                           <span class="fw-semibold tab-text">Inactive - <?php echo $free_directs['free_directs']; ?></span>
                        </div>
                     </li>
                     <li class="mb-3 display_flex justify-content-between">
                        <div class="d-flex align-items-center lh-1 me-3">
                           <span class="badge badge-dot bg-danger me-2"></span>
                           Total Direct Business
                        </div>
                        <div class="display_flex gap-3">
                           <span class="fw-semibold tab-text">Total - <?php echo currency . $directBusiness['directBusiness']; ?></span>
                        </div>
                     </li>
                     <li class="mb-3 display_flex justify-content-between">
                        <div class="d-flex align-items-center lh-1 me-3">
                           <span class="badge badge-dot bg-danger me-2"></span>
                           Direct Business
                        </div>
                        <div class="display_flex gap-3">
                           <span class="fw-semibold tab-text">Left - <?php echo currency . $directBusinessL['directBusinessL']; ?></span>
                           <span class="fw-semibold tab-text">Right - <?php echo currency . $directBusinessR['directBusinessR']; ?></span>
                        </div>
                     </li>
                  </ul>
               </div>
            </div>
         </div>

         <!-- <div class="col-md-6 col-lg-6 col-xl-6  box-bottom-m ">
                  <div class="card mt-0 mb-0 bg-success">
                     <div class="card-header justify-content-between">
                        <h5 class="card-title mb-0">Total Downline Team </h5>
                        <h3 class="fw-normal mb-0">
                           <?php // echo ($LeftPaidteam['team'] + $RightPaidteam['team'] + $RightUnPaidteam['team'] + $LeftUnPaidteam['team']); 
                           ?>
                        </h3>
                     </div>
                     <div class="card-body">
                        <ul class="p-0 m-0 custombx">

                           <li class="mb-3 display_flex justify-content-between">
                              <div class="d-flex align-items-center lh-1 me-3">
                                 <span class="badge badge-dot bg-danger me-2"></span>
                                 Downline Team
                              </div>
                              <div class="display_flex gap-3">
                                 <span class="fw-semibold"> Active - <?php // echo $LeftPaidteam['team'] + $RightPaidteam['team']; 
                                                                     ?></span>
                                 <span class="fw-semibold"> Inactive - <?php // echo $LeftUnPaidteam['team'] + $RightUnPaidteam['team']; 
                                                                        ?></span>
                              </div>
                           </li>

                           <li class="mb-3 display_flex justify-content-between">
                              <div class="d-flex align-items-center lh-1 me-3">
                                 <span class="badge badge-dot bg-danger me-2"></span>
                                 Total Team Business
                              </div>
                              <div class="display_flex gap-3">
                                 <span class="fw-semibold"> Total - <?php // echo currency . ($LeftBusiness['teamBusiness'] + $RightBusiness['teamBusiness']); 
                                                                     ?></span>
                              </div>
                           </li>


                           <li class="mb-3 display_flex justify-content-between">
                              <div class="d-flex align-items-center lh-1 me-3">
                                 <span class="badge badge-dot bg-danger me-2"></span>
                                 Team Business
                              </div>
                              <div class="display_flex gap-3">
                                 <span class="fw-semibold">Left - <?php // echo currency . $LeftBusiness['teamBusiness']; 
                                                                  ?></span>
                                 <span class="fw-semibold">Right - <?php // echo currency . $RightBusiness['teamBusiness']; 
                                                                     ?></span>
                              </div>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div> -->
      <?php } ?>
      <div class="row">

         <div class="col-12" data-bound>
            <div class="bx">
               <marquee behavior="" direction="left" onMouseOver="this.stop()" onMouseOut="this.start()" class="work-image">
                  <!-- <img src="<?php //echo logo; 
                                 ?>" alt="">
                     <a href="<?php //echo logo; 
                              ?>" class="popup-btn" target="_blank">view</a> -->
                  <?php
                  foreach ($achiever as $key => $ach) {

                  ?>
                     <img src="<?php echo base_url('uploads/' . $ach['image']); ?>" height="100px" width="100px">
                     <!-- <td><?php //echo $ach['name']; 
                              ?></td> -->
                  <?php

                  }

                  ?>
               </marquee>

            </div>

         </div>

         <div class="col-md-6 col-lg-6 col-xl-6 box-bottom-m">
            <div class="card mt-0 mb-0 add-img">
               <div class="earn-thumb">
               </div>
               <div class="card-header">
                  <h5 class="card-title mb-2 text-center m-auto p-0">User Details</h5>
               </div>
               <div class="card-body">
                  <ul class="p-0 m-0 custombx">
                     <li class="mb-3 display_flex justify-content-between">
                        <div class="d-flex align-items-center lh-1 me-3">
                           <span class="badge badge-dot bg-success me-2"></span>
                           Name
                        </div>
                        <div class="d-flex gap-3">
                           <span class="fw-semibold tab-text"><?php echo $userinfo->name ?> </span>
                        </div>
                     </li>
                     <li class="mb-3 display_flex justify-content-between">
                        <div class="d-flex align-items-center lh-1 me-3">
                           <span class="badge badge-dot bg-success me-2"></span>
                           User ID
                        </div>
                        <div class="d-flex gap-3">
                           <span class="fw-semibold tab-text"><?php echo $userinfo->user_id ?> </span>
                        </div>
                     </li>
                     <li class="mb-3 display_flex justify-content-between">
                        <div class="d-flex align-items-center lh-1 me-3">
                           <span class="badge badge-dot bg-success me-2"></span>
                           Phone 
                        </div>
                        <div class="d-flex gap-3">
                           <span class="fw-semibold tab-text"><?php echo $userinfo->phone ?> </span>
                        </div>
                     </li>
                     <li class="mb-3 display_flex justify-content-between">
                        <div class="d-flex align-items-center lh-1 me-3">
                           <span class="badge badge-dot bg-success me-2"></span>
                           Package
                        </div>
                        <div class="d-flex gap-3">
                           <span class="fw-semibold tab-text"><?php echo $userinfo->total_package ?> </span>
                        </div>
                     </li>
                     <li class="mb-3 display_flex justify-content-between">
                        <div class="d-flex align-items-center lh-1 me-3">
                           <span class="badge badge-dot bg-success me-2"></span>
                           Activation Date
                        </div>
                        <div class="d-flex gap-3">
                           <span class="fw-semibold tab-text"><?php echo $userinfo->topup_date ?> </span>
                        </div>
                     </li>
                     <li class="mb-3 display_flex justify-content-between">
                        <div class="d-flex align-items-center lh-1 me-3">
                           <span class="badge badge-dot bg-danger me-2"></span>
                           Status
                        </div>
                        <div class="d-flex gap-3">
                           <span class="fw-semibold tab-text"><?php echo ($userinfo->paid_status > 0) ? '<span class="text-success">active</span>' : '<span class="text-danger">inactive</span>'; ?>
                        </div>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="col-md-6 col-lg-6 col-xl-6 box-bottom-m">
            <div class="card mt-0 mb-0 add-img">
               <div class="earn-thumb">
               </div>
               <div class="card-header">
                  <h5 class="card-title m-auto">Latest News</h5>
               </div>
               <div class="card-body">
                  <ul class="p-0 m-0 custombx">
                     <li class="mb-3 w-100">
                        <div class="d-flex align-items-center lh-1 me-3">
                           <span class="badge badge-dot bg-success me-2"></span>
                           <marquee direction="left" scrollamount="2">
                              <?php foreach ($news as $n) : ?>
                                 <p class="" style="color:#fff"><?php echo $n['news']; ?></p>
                              <?php endforeach; ?>
                           </marquee>
                        </div>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>


      <?php if (registration == 1) { ?>
         <div class="col-md-6 box-bottom-m">
            <div class="earn-item  add-img">
               <h3>Left Referal Link</h3>
               <div class="display_flex flex-direction reffral-code w-100 trans__adsd">
                  <input style="width:100%;" type="text" id="linkTxt" value="<?php echo base_url('register/?sponser_id=' . $userinfo->user_id . '&position=L'); ?>" readonly class="form-control custom-form">
                  <button id="btnCopy" iconcls="icon-save" class="btn d-block btn-lg copy_btns">
                     Copy
                  </button>
                  <div class="social_icon mt-4 mt-md-0">
                     <a href="https://wa.me/?text=<?php echo base_url('register/?sponser_id=' . $userinfo->user_id . '&position=L'); ?>" target="_blank">
                        <img src="<?php echo base_url('uploads/wp-icon.png'); ?>" alt="">
                     </a>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-6 box-bottom-m">
            <div class="earn-item add-img">

               <h3>Right Referal Link</h3>

               <div class="display_flex flex-direction reffral-code w-100 trans__adsd">
                  <input style="width:100%;" type="text" id="linkTxt2" value="<?php echo base_url('register/?sponser_id=' . $userinfo->user_id . '&position=R'); ?>" readonly class="form-control custom-form">
                  <button id="btnCopy2" iconcls="icon-save" class="btn d-block btn-lg copy_btns">
                     Copy
                  </button>
                  <div class="social_icon mt-4 mt-md-0">
                     <a href="https://wa.me/?text=<?php echo base_url('register/?sponser_id=' . $userinfo->user_id . '&position=R'); ?>" target="_blank">
                        <img src="<?php echo base_url('uploads/wp-icon.png'); ?>" alt="">
                     </a>
                  </div>
               </div>
            </div>
         </div>
      <?php } else { ?>
         <div class="col-md-12 box-bottom-m">
            <div class="earn-item ">
               <h3>Referal Link</h3>
               <div class="display_flex flex-direction reffral-code w-100 trans__adsd">
                  <input style="width:100%;  float:left" type="text" id="linkTxt" value="<?php echo base_url('register/?sponser_id=' . $userinfo->user_id); ?>" readonly class="form-control custom-form">
                  <button id="btnCopy" iconcls="icon-save" class="btn d-block btn-lg copy_btns">
                     Copy link
                  </button>
               </div>
            </div>
         </div>
      <?php } ?>

      </div>

   </div>
   <div class="row">
      <div class="col-md-12 col-lg-12">
         <div class="card x ">
            <div class="card-header">
               <h2 class="card-title text-center text-dark m-auto"> Cash Back & Reward Bonus
               </h2>
            </div>
            <div class="card-body">
               <h6 class="mb-4">1. Cash Back & Reward Bonus</h6>
               <div class="order-table">
                  <div class="table-responsive">
                     <table id="" class="table table-striped table-bordered text-nowrap  mb-0">
                        <thead>
                           <tr class="bold border-bottom">
                              <th class="border-bottom-0">SR NO.</th>
                              <th class="border-bottom-0">Direct Business</th>
                              <th class="border-bottom-0">Cashback</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $rewardarr = $this->config->item('team_reward');
                           foreach ($rewardarr as $key => $ra) :
                           ?>
                              <tr>
                                 <td><?php echo $key; ?></td>
                                 <td>+<?php echo $ra['direct_business']; ?><?php echo currency; ?></td>
                                 <td><?php echo $ra['cashback']; ?><?php echo currency; ?></td>
                              </tr>
                           <?php endforeach; ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="col-md-12 col-lg-12">
         <div class="card x ">
            <div class="card-body">
               <h6 class="mb-4">2. Team Reward Bonus</h6>
               <div class="order-table">
                  <div class="table-responsive">
                     <table id="" class="table table-striped table-bordered text-nowrap  mb-0">
                        <thead>
                           <tr class="bold border-bottom">
                              <th class="border-bottom-0">SR NO.</th>
                              <th class="border-bottom-0">Left</th>
                              <th class="border-bottom-0">Right</th>
                              <th class="border-bottom-0">Reward</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $bonus = $this->config->item('reward_bonus');
                           foreach ($bonus as $key => $ra) :
                           ?>
                              <tr>
                                 <td><?php echo $key; ?></td>
                                 <td>+<?php echo $ra['left']; ?><?php echo currency; ?></td>
                                 <td>+<?php echo $ra['right']; ?><?php echo currency; ?></td>
                                 <td><?php echo $ra['reward']; ?></td>
                              </tr>
                           <?php endforeach; ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- ROW-4 END -->
</div>
<!-- CONTAINER END -->
</div>
<!--app-content close-->
<?php if ($popup['status'] == 0) : ?>
   <div class="modal fade justify-content-center" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel"><?php echo $popup['caption'] ?></h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" fdprocessedid="mhmwvk">X</button>
            </div>
            <div class="modal-body">
               <img src="<?php echo base_url('uploads/' . $popup['media']) ?>" class="img-fluid">
            </div>
         </div>
      </div>
   </div>
<?php endif; ?>
<?php require_once 'footer.php'; ?>
<script>
   $(document).ready(function() {
      $('#myModal').modal('show');
   });

   $(document).on('click', '#btnCopy', function() {
      var copyText = document.getElementById("linkTxt");
      copyText.select();
      copyText.setSelectionRange(0, 99999)
      document.execCommand("copy");
      toastr.success('<span class="text-success">Referal link Copied!</span>')
   })
   $(document).on('click', '#btnCopy2', function() {
      var copyText = document.getElementById("linkTxt2");
      copyText.select();
      copyText.setSelectionRange(0, 99999)
      document.execCommand("copy");
      toastr.success('<span class="text-success">Referal link Copied!</span>')
   })

   // const desktopData = () => {
   //    const url = "<?php //echo base_url('Dashboard/AjaxController/jsonData'); 
                        ?>"
   //    fetch(url, {
   //          method: "GET",
   //          headers: {
   //             "X-Requested-With": "XMLHttpRequest"
   //          }
   //       })
   //       .then(response => response.json())
   //       .then(response => {
   //          console.log(response)
   //          document.getElementById('paidDirects').innerHTML = 'Active: ' + response.paidDirects['paidDirects']
   //          document.getElementById('freeDirects').innerHTML = 'Inactive: ' + response.freeDirects['freeDirects']
   //          document.getElementById('paidTeam').innerHTML = 'Free Team: ' + response.freeTeam['team']
   //          document.getElementById('freeTeam').innerHTML = 'Paid Team: ' + response.paidTeam['team']
   //          document.getElementById('leftPaidTeam').innerHTML = 'Paid L Team: ' + response.leftPaidTeam['team']
   //          document.getElementById('leftTeam').innerHTML = 'Free L Team: ' + response.leftfreeTeam['team']
   //          document.getElementById('rightPaidTeam').innerHTML = 'Paid R Team: ' + response.rightPaidTeam['team']
   //          document.getElementById('rightTeam').innerHTML = 'Free R Team: ' + response.rightfreeTeam['team']
   //       })
   // }

   // desktopData()
   function getTimeRemaining() {
      var now = new Date();
      var hours = now.getHours();
      var minutes = now.getMinutes();
      var seconds = now.getSeconds();

      // Get the time remaining until 6 AM of the next day
      var targetTime = new Date(now);
      targetTime.setHours(6, 0, 0, 0); // Set target time to 6:00 AM of the next day

      // If the current time is after 6 AM, set target time to 6:00 AM of the day after the next day
      if (hours >= 6) {
         targetTime.setDate(targetTime.getDate() + 1);
      }

      var timeDiff = targetTime.getTime() - now.getTime();

      // Calculate remaining hours, minutes, and seconds
      var remainingHours = Math.floor(timeDiff / (1000 * 60 * 60));
      var remainingMinutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
      var remainingSeconds = Math.floor((timeDiff % (1000 * 60)) / 1000);

      return {
         'hours': remainingHours,
         'minutes': remainingMinutes,
         'seconds': remainingSeconds
      };
   }

   function initializeClock() {
      var clock = document.getElementById('clock');

      function updateClock() {
         var time = getTimeRemaining();

         // Display the remaining time
         clock.innerHTML = ' Pool Timer : ' +
            ('0' + time.hours).slice(-2) + ':' +
            ('0' + time.minutes).slice(-2) + ':' +
            ('0' + time.seconds).slice(-2);

         // Update every second
         if (time.total <= 0) {
            clearInterval(timeinterval);
         }
      }

      // updateClock();
      // var timeinterval = setInterval(updateClock, 1000);
   }

   initializeClock();
</script>