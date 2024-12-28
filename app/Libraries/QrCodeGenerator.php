<?php

namespace App\Libraries;

// Bao gồm các tệp cần thiết
require_once "C:\\xampp\\htdocs\\web_ban_banh_kem\\app\\Libraries\\Endroid\\QrCode\\src\\QrCodeInterface.php"; 
require_once "C:\\xampp\\htdocs\\web_ban_banh_kem\\app\\Libraries\\Endroid\\QrCode\\src\\QrCode.php"; 
require_once "C:\\xampp\\htdocs\\web_ban_banh_kem\\app\\Libraries\\Endroid\\QrCode\\src\\Writer\\AbstractGdWriter.php"; // Nếu bạn không có AbstractGdWriter, hãy chọn lớp writer thích hợp khác
require_once "C:\\xampp\\htdocs\\web_ban_banh_kem\\app\\Libraries\\Endroid\\QrCode\\src\\Writer\\PngWriter.php"; 
require_once "C:\\xampp\\htdocs\\web_ban_banh_kem\\app\\Libraries\\Endroid\\QrCode\\src\\Writer\\ValidatingWriterInterface.php"; 
require_once "C:\\xampp\\htdocs\\web_ban_banh_kem\\app\\Libraries\\Endroid\\QrCode\\src\\Writer\\WriterInterface.php"; 
require_once "C:\\xampp\\htdocs\\web_ban_banh_kem\\app\\Libraries\\Endroid\\QrCode\\src\\Writer\\SvgWriter.php"; // Chỉ cần bao gồm nếu bạn sử dụng nó

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class QrCodeGenerator
{
    public function generate($data)
    {
        // Tạo mã QR
        $qrCode = new QrCode($data);

        // Chọn writer để xuất mã QR
        $writer = new PngWriter(); // Đảm bảo PngWriter thực sự có sẵn

        // Xuất mã QR ra định dạng PNG
        $result = $writer->write($qrCode);

        // Trả về dữ liệu mã QR dưới dạng PNG
        return $result->getString();
    }
}
