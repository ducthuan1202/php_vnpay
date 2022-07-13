<?php

/**
 * Quick view result page
 *
 * Đây là trang hiển thị nhanh kết quả thanh toán cho người dùng xem
 * không nên dùng page này để tính toán hay cập nhật thông tin liên quan tới thanh toán
 */

require_once("./functions.php");
require_once("./constants.php");
require_once("./VNPay.php");

$vnpay = new VNPay();
$vnpayResponse = $vnpay->parse($_GET);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <title>VNPAY RESPONSE</title>
        <!-- Bootstrap core CSS -->
        <link href="assets/bootstrap.min.css" rel="stylesheet"/>
        <!-- Custom styles for this template -->
        <link href="assets/jumbotron-narrow.css" rel="stylesheet">         
        <script src="assets/jquery-1.11.3.min.js"></script>
    </head>
    <body>
        <!--Begin display -->
        <div class="container">
            <div class="header clearfix">
                <h3 class="text-muted">VNPAY RESPONSE</h3>
            </div>
            <div class="table-responsive">
                <div class="form-group">
                    <label >Mã đơn hàng:</label>
                    <label><?= $vnpayResponse->getOrderID() ?></label>
                </div>    
                <div class="form-group">
                    <label >Số tiền:</label>
                    <label class="text-info"><?= number_format($vnpayResponse->getAmount()) ?> VND</label>
                </div>  
                <div class="form-group">
                    <label >Nội dung thanh toán:</label>
                    <label><?= $vnpayResponse->getOrderInfo() ?></label>
                </div> 
                <div class="form-group">
                    <label >Mã phản hồi (vnp_ResponseCode):</label>
                    <label><?= $vnpayResponse->getTransactionStatus() ?> - <?= $vnpayResponse->getTransactionStatusText() ?></label>
                </div> 
                <div class="form-group">
                    <label >Mã GD Tại VNPAY:</label>
                    <label><?= $vnpayResponse->getTransactionNumber() ?></label>
                </div> 
                <div class="form-group">
                    <label >Mã Ngân hàng:</label>
                    <label><?= $vnpayResponse->getBankCode() ?></label>
                </div> 
                <div class="form-group">
                    <label >Thời gian thanh toán:</label>
                    <label><?= $vnpayResponse->getPayDate() ?></label>
                </div> 
                <div class="form-group">
                    <label >Kết quả:</label>
                    <label>
                        <?php if ($vnpayResponse->isValid()): ?>
                            <?php if ($vnpayResponse->isSuccess()): ?>
                                <span class="text-info">GD thành công</span>
                            <?php else: ?>
                                <span class="text-warning">GD thất bại</span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="text-danger">Chữ ký không hợp lệ</span>
                        <?php endif; ?>
                    </label>
                </div> 
            </div>           
        </div>  
    </body>
</html>
