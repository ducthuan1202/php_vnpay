<?php

/**
 * Instant Payment Notification (IPN)
 *
 * Hiện tại, khi đăng ký tài khoản sanbox, chưa thấy VNPAY cho phép đăng ký link này
 * khi đăng ký tài khoản production có thể sẽ sẽ có
 *
 * Mình sẽ tạo link IPN trên server rồi gửi thông tin sang VNPAY để họ config IPN URL
 *
 * Tựa như webhook, để VNPAY call tới sau khi thanh toán thành công
 * Như vậy, sau khi thanh toán hoàn tất, VNPAY làm 2 việc:
 * - Điều hướng tới page return để hiển thị nhanh kết quả thanh toán
 * - Call webhook của KH để hỗ trợ cập nhật dữ liệu
 *
 **/

require_once("./functions.php");
require_once("./constants.php");
require_once("./VNPay.php");

$vnpay = new VNPay();
$vnpayResponse = $vnpay->confirm($_GET);