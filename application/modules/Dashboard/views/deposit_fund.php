<?php $this->load->view('header'); ?>
<style>
    #inviteCode.invite-page {
        box-sizing: border-box;
        display: flex;
        flex-direction: row;
        background-color: transparent;
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        justify-content: space-between;
        width: 100%;
        box-shadow: 0px 1px 2px rgba(0, 0, 0, .07);
    }

    #linkTxt {
        align-self: center;
        font-size: 1.2em;
        color: #000;
        font-weight: bold;
        flex-grow: 2;
        background-color: transparent;
        border: none;
    }

    #btnCopy {
        margin-left: 20px;
        border: 1px solid #006633;
        border-radius: 5px;
        background-color: #f8f8f8;
        padding: 4px 35px !important;
    }

    .note {
        background: #006633;
        color: #fff;
        padding: 10px 15px;
        border-radius: 5px;
        margin-top: 15px
    }
    div.qr img {
    background: #fff;
    padding: 12px;
    border-radius: 8px;
    max-width: 350px;
}
.qr{
	display: flex;
	justify-content: center;
	align-items: center;
}
@media (max-width:576px) {
    #btnCopy{
margin-left: 0;
    }
    #inviteCode.invite-page {
	flex-direction: column;
}
.btn.btn-danger {
	width: 100%;
	padding: 4px;
    font-size: 13px;
}
}
</style>
<div class="main-content app-content mt-0">
    <div class="contanier-fluid">
        <!-- <section class="main-content"> -->
        <div class="col-md-12">
            <div class="pannel-box-custom">
                <div class="panel-heading mb-3">
                    <h4 class="panel-title"><?php echo $heeader ?></h4>
                </div>

            </div>
        </div>
        <div class="content mt-3 col-12">
            <div id="rootwizard" class="card wizard-full-width">
                <div class="">
                    <div class="wizard-content tab-content">
                        <div class="tab-pane active show" id="tabFundRequestForm">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <a class="to-padding widget widget-stats">
                                                    <div class="widget-stats-info mm-info">
                                                        <div class="widget-stats-value to-fontsize" id="balance_received"> E-Wallet Balance: <?php echo currency; ?></div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="">
                                                <div class="row mt-3">
                                                    <div class="col-md-3">
                                                        <div class="qr" id="qrcode">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9 mt-3 mt-md-0">
                                                        <div id="inviteCode" class="invite-page">
                                                            <input id="linkTxt" value="<?php echo $user['wallet_address']; ?>" readonly>
                                                            <!-- <i id="btnCopy" class="bi bi-clipboard"></i> -->
                                                            <button class="btn btn-info" id="btnCopy">Copy</button>

                                                            
                                                        </div>
                                                    <a href="<?php echo base_url('dashboard/deposit-history'); ?> " class="btn btn-danger">Click here to see Deposit Transaction</a>

                                                    </div>
                                                <p class="note">Note confirmation time is 1 Minute then click on Transaction History</p>
                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- </section> -->
    </div>
</div>

<?php $this->load->view('footer'); ?>

<script type="">
    $(document).on('click', '#btnCopy', function () {
    //linkTxt
    var copyText = document.getElementById("linkTxt");
    copyText.select();
    copyText.setSelectionRange(0, 99999)
    document.execCommand("copy");
    toastr.success('Copied!')
})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" integrity="sha512-CNgIRecGo7nphbeZ04Sc13ka07paqdeTu0WR1IM4kNcpmBAUSHSQX0FslNhTDadL4O5SAGapGt4FodqL8My0mA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    var code = '<?php echo $user['wallet_address']; ?>';
    new QRCode(document.getElementById("qrcode"), code);
</script>
<script>
    $('#global-loader').hide()

    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#slipImage').css('display', 'block');
                $('#slipImage').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#payment_slip").change(function() {
        readURL(this);
    });
    $(document).on('submit', '#paymentForm', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#savebtn').css('display', 'none');
        $('#uploadnot').css('display', 'block');
        var action = $(this).attr('action');
        $.ajax({
            url: action,
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                data = JSON.parse(data);
                if (data.success === 1) {
                    toastr.success(data.message);
                    //                    swal("Thank You", data.message);
                    //window.location = "https://soarwaylife.in/Dashboard/request_money.php" + data.message;
                    location.reload();
                } else {
                    toastr.error(data.message);
                }
                $('#savebtn').css('display', 'block');
                $('#uploadnot').css('display', 'none');
            }
        });
    });
</script>

<script>
    function check_updated_balance() {
        var params = "msgcheck=1";
        var jsondata = "";
        var url = "<?php echo base_url() ?>Dashboard/Fund/depositAjax";
        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'html',
            data: params,
            success: function(html) {
                jsondata = JSON.parse(html);
                // console.log(jsondata.wallet);
                if (jsondata.records.balance != "")
                    if (jsondata.records.balance > 0) {
                        document.getElementById("balance_received").innerHTML = 'E-Wallet Balance :' + jsondata.records.balance;

                    } else {
                        document.getElementById("balance_received").innerHTML = 'E-Wallet Balance : 0';
                    }
            }
        });


    }
    var timer = setInterval(function() {
        check_updated_balance();
    }, 1000);
</script>