<?php

// Giá trị này do VNPay cung cấp sau khi đăng ký.
// đây là những tham số nhạy cảm, nên được lưu vào file .env để tránh bị rò rỉ thông tin
const VNPAY_WEBSITE_ID = "SA5UESKV";
const VNPAY_SECRET_KEY = "VUGDPQIDBZKBMUVJTKWQWGNAWHNYJDYU";

// phương thức mã hóa hash data VNPay sử dụng
const VNPAY_ALGORITHM = "sha512";

// link trang thanh toán của VNPay. Hiện tại, đang để giá trị sanbox
const VNPAY_PAYMENT_URL = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
const VNPAY_MERCHANT_URL = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";

// đây là trang chuyển hướng sau khi VNPay hoàn tất thanh toán
const VNPAY_URL_CALLBACK = "http://localhost/vnpay/page_callback.php";

// webhook - để nhận thông tin thanh toán sau khi hoàn tất
const VNPAY_WEBHOOK_IPN_URL = "http://localhost/vnpay/page_confirm.php";