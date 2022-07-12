<?php

/**
 * Payment Notify (IPN)
 *
 * Tựa như webhook, để VNPAY call tới sau khi thanh toán thành công
 * Như vậy, sau khi thanh toán hoàn tất, VNPAY làm 2 việc:
 * - Điều hướng tới page return để hiển thị nhanh kết quả thanh toán
 * - Call webhook của KH để hỗ trợ cập nhật dữ liệu
 *
 * IPN URL: Ghi nhận kết quả thanh toán từ VNPAY
 * Các bước thực hiện:
 * Kiểm tra checksum
 * Tìm giao dịch trong database
 * Kiểm tra số tiền giữa hai hệ thống
 * Kiểm tra tình trạng của giao dịch trước khi cập nhật
 * Cập nhật kết quả vào Database
 * Trả kết quả ghi nhận lại cho VNPAY
 **/

require_once("./functions.php");
require_once("./constants.php");
require_once("./VNPay.php");

$vnpay = new VNPay();
$vnpayResponse = $vnpay->confirm($_GET);