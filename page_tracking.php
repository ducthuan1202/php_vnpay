<?php

/**
 * Tracking page
 *
 * Đây là page mà VNPAY sẽ call tới với dũ liệu sau khi hoàn tất thanh toán
 * chỗ này chính là nơi để cập nhật đơn hàng, trạng thái thanh toán, ...
 * hay bất kỳ xử lý logic nào liên quan tới thanh toán VNPAY trả về
 */
require_once("./functions.php");
require_once("./constants.php");
require_once("./VNPay.php");

$resp = null;
if (array_key_exists("order_id", $_POST)) {
    $vnpay = new VNPay();
    $resp = $vnpay->tracking($_POST);
    header('content-type: text/plain');
    var_export($resp);
    exit();
}
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Tra cứu giao dịch</title>
    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap.min.css" rel="stylesheet"/>
    <!-- Custom styles for this template -->
    <link href="assets/jumbotron-narrow.css" rel="stylesheet">
    <script src="assets/jquery-1.11.3.min.js"></script>
</head>
<body>
<div class="container">
    <div class="header clearfix">
        <h3 class="text-muted">VNPAY DEMO</h3>
    </div>
    <div style="width: 100%;padding-top:0px;font-weight: bold;color: #333333"><h3>Querydr</h3></div>
    <div style="width: 100% ;border-bottom: 2px solid black;padding-bottom: 20px" >
        <form id="frmCreateOrder" method="post">
            <div class="form-group">
                <label >OrderID</label>
                <input class="form-control" data-val="true"  name="order_id" type="text" />
            </div>
            <div class="form-group">
                <label>Payment Date</label>
                <input class="form-control" data-val="true"  name="payment_date" type="text" />
            </div>
            <button type="submit" class="btn btn-success btn-lg">Lấy thông tin thanh toán</button>
        </form>
    </div>

    <?= $resp ?>
</div>
</body>
</html>
