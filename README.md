# Tổng quan 

1. Khái niệm
- `vnp_TmnCode`: mã (ID) của Website được khai báo tại hệ thống Cổng Thanh toán VNPAY.
- `vnp_HashSecret`: chuỗi bí mật sử dụng để kiểm tra toàn vẹn dữ liệu khi hai hệ thống trao đổi thông tin (checksum).
- `vnp_PaymentURL`: URL thực hiện thanh toán trên VNPAY.
- `vnp_ReturnURL`: URL để VNPAY chuyển hướng khi giao dịch hoàn tất.
- `vnp_IPNURL`: URL để VNPAY call sang dưới dạng webhook khi giao dịch hoàn tất.
