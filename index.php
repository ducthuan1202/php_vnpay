<?php

/**
 * Create Payment page
 *
 * Đây là trang demo thanh toán với VNPAY
 * Sau khi submit, trang sẽ được điều hướng tới VNPAY để thực hiện tao thác thanh toán
 * khi hoàn tất, sẽ chuyển lại về trang page_callbac.php để hiển thị kết quả
 */

require_once("./functions.php");
require_once("./constants.php");
require_once("./VNPay.php");

if (array_key_exists("order_id", $_POST)) {
    $vnpay = new VNPay();
    $vnpay->payment($_POST);
    exit();
}
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
    <title>Tạo mới đơn hàng</title>
    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap.min.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="assets/jumbotron-narrow.css" rel="stylesheet">
    <script src="assets/jquery-1.11.3.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="header clearfix">
            <h3 class="text-muted">VNPAY DEMO</h3>
        </div>

        <form id="create_form" method="post">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <h3>Thông tin đơn hàng (Order)</h3>
                    </div>

                    <div class="form-group">
                        <label for="language">Loại hàng hóa </label>
                        <select name="order_type" id="order_type" class="form-control">
                            <option value="topup">Nạp tiền điện thoại</option>
                            <option value="billpayment">Thanh toán hóa đơn</option>
                            <option value="fashion">Thời trang</option>
                            <option value="other">Khác - Xem thêm tại VNPAY</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="order_id">Mã hóa đơn</label>
                        <input class="form-control" id="order_id" name="order_id" type="text" value="<?= date("YmdHis") ?>" />
                    </div>
                    <div class="form-group">
                        <label for="amount">Số tiền</label>
                        <input class="form-control" id="amount" name="amount" type="number" value="12021990" />
                    </div>
                    <div class="form-group">
                        <label for="order_desc">Nội dung thanh toán</label>
                        <textarea class="form-control" cols="20" id="order_desc" name="order_desc" rows="2">TT tien maxtra quy I - 2022</textarea>
                    </div>
                    <div class="form-group">
                        <label for="bank_code">Ngân hàng</label>
                        <select name="bank_code" id="bank_code" class="form-control">
                            <option value="">Không chọn</option>
                            <option value="NCB"> Ngan hang NCB</option>
                            <option value="AGRIBANK"> Ngan hang Agribank</option>
                            <option value="SCB"> Ngan hang SCB</option>
                            <option value="SACOMBANK">Ngan hang SacomBank</option>
                            <option value="EXIMBANK"> Ngan hang EximBank</option>
                            <option value="MSBANK"> Ngan hang MSBANK</option>
                            <option value="NAMABANK"> Ngan hang NamABank</option>
                            <option value="VNMART"> Vi dien tu VnMart</option>
                            <option value="VIETINBANK">Ngan hang Vietinbank</option>
                            <option value="VIETCOMBANK"> Ngan hang VCB</option>
                            <option value="HDBANK">Ngan hang HDBank</option>
                            <option value="DONGABANK"> Ngan hang Dong A</option>
                            <option value="TPBANK"> Ngân hàng TPBank</option>
                            <option value="OJB"> Ngân hàng OceanBank</option>
                            <option value="BIDV"> Ngân hàng BIDV</option>
                            <option value="TECHCOMBANK"> Ngân hàng Techcombank</option>
                            <option value="VPBANK"> Ngan hang VPBank</option>
                            <option value="MBBANK"> Ngan hang MBBank</option>
                            <option value="ACB"> Ngan hang ACB</option>
                            <option value="OCB"> Ngan hang OCB</option>
                            <option value="IVB"> Ngan hang IVB</option>
                            <option value="VISA"> Thanh toan qua VISA/MASTER</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="language">Ngôn ngữ</label>
                        <select name="language" id="language" class="form-control">
                            <option value="vn">Tiếng Việt</option>
                            <option value="en">English</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <h3>Thông tin hóa đơn (Billing)</h3>
                    </div>
                    <div class="form-group">
                        <label>Họ tên (*)</label>
                        <input class="form-control" id="txt_billing_fullname" name="txt_billing_fullname" type="text" value="NGO DUC HIEU" />
                    </div>
                    <div class="form-group">
                        <label>Email (*)</label>
                        <input class="form-control" id="txt_billing_email" name="txt_billing_email" type="text" value="ng.hieu89@gmail.com" />
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại (*)</label>
                        <input class="form-control" id="txt_billing_mobile" name="txt_billing_mobile" type="text" value="0936488286" />
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ (*)</label>
                        <input class="form-control" id="txt_billing_addr1" name="txt_billing_addr1" type="text" value="584 Lạc Long Quân, Tây Hồ" />
                    </div>
                    <div class="form-group">
                        <label>Mã bưu điện (*)</label>
                        <input class="form-control" id="txt_postalcode" name="txt_postalcode" type="text" value="100000" />
                    </div>
                    <div class="form-group">
                        <label>Tỉnh/TP (*)</label>
                        <input class="form-control" id="txt_bill_city" name="txt_bill_city" type="text" value="Hà Nội" />
                    </div>
                    <div class="form-group">
                        <label>Bang (Áp dụng cho US,CA)</label>
                        <input class="form-control" id="txt_bill_state" name="txt_bill_state" type="text" value="" />
                    </div>
                    <div class="form-group">
                        <label>Quốc gia (*)</label>
                        <input class="form-control" id="txt_bill_country" name="txt_bill_country" type="text" value="VN" />
                    </div>
                </div>
            </div>

            <hr/>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <h3>Thông tin giao hàng (Shipping)</h3>
                    </div>
                    <div class="form-group">
                        <label>Họ tên (*)</label>
                        <input class="form-control" id="txt_ship_fullname" name="txt_ship_fullname" type="text" value="Nguyễn Duy Minh" />
                    </div>
                    <div class="form-group">
                        <label>Email (*)</label>
                        <input class="form-control" id="txt_ship_email" name="txt_ship_email" type="text" value="minhnd@gmail.vn" />
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại (*)</label>
                        <input class="form-control" id="txt_ship_mobile" name="txt_ship_mobile" type="text" value="0962729906" />
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ (*)</label>
                        <input class="form-control" id="txt_ship_addr1" name="txt_ship_addr1" type="text" value="Phòng 315, Công ty VNPAY, Tòa nhà TĐL, 22 Láng Hạ, Đống Đa, Hà Nội" />
                    </div>
                    <div class="form-group">
                        <label>Mã bưu điện (*)</label>
                        <input class="form-control" id="txt_ship_postalcode" name="txt_ship_postalcode" type="text" value="1000000" />
                    </div>
                    <div class="form-group">
                        <label>Tỉnh/TP (*)</label>
                        <input class="form-control" id="txt_ship_city" name="txt_ship_city" type="text" value="Hà Nội" />
                    </div>
                    <div class="form-group">
                        <label>Bang (Áp dụng cho US,CA)</label>
                        <input class="form-control" id="txt_ship_state" name="txt_ship_state" type="text" value="" />
                    </div>
                    <div class="form-group">
                        <label>Quốc gia (*)</label>
                        <input class="form-control" id="txt_ship_country" name="txt_ship_country" type="text" value="VN" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <h3>Thông tin gửi Hóa đơn điện tử (Invoice)</h3>
                    </div>
                    <div class="form-group">
                        <label>Tên khách hàng</label>
                        <input class="form-control" id="txt_inv_customer" name="txt_inv_customer" type="text" value="Nguyễn Duy Minh" />
                    </div>
                    <div class="form-group">
                        <label>Công ty</label>
                        <input class="form-control" id="txt_inv_company" name="txt_inv_company" type="text" value="Công ty Cổ phần giải pháp Thanh toán Việt Nam" />
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <input class="form-control" id="txt_inv_addr1" name="txt_inv_addr1" type="text" value="22 Láng Hạ, Phường Láng Hạ, Quận Đống Đa, TP Hà Nội" />
                    </div>
                    <div class="form-group">
                        <label>Mã số thuế</label>
                        <input class="form-control" id="txt_inv_taxcode" name="txt_inv_taxcode" type="text" value="0102182292" />
                    </div>
                    <div class="form-group">
                        <label>Loại hóa đơn</label>
                        <select name="cbo_inv_type" id="cbo_inv_type" class="form-control">
                            <option value="I" selected>Cá Nhân</option>
                            <option value="O">Công ty/Tổ chức</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" id="txt_inv_email" name="txt_inv_email" type="text" value="pholv@vnpay.vn" />
                    </div>
                    <div class="form-group">
                        <label>Điện thoại</label>
                        <input class="form-control" id="txt_inv_mobile" name="txt_inv_mobile" type="text" value="0962729906" />
                    </div>
                </div>
            </div>

            <div style="margin-top: 30px;" class="text-center">
                <button type="submit" class="btn btn-primary btn-lg" id="btnPopup">Đi tới VNPay & Thanh toán</button>
            </div>

        </form>
    </div>
</body>

</html>