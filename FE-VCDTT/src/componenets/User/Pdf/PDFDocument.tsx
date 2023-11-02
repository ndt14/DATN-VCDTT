import React, { useEffect } from "react";
import jsPDF from 'jspdf';
import 'jspdf-autotable';

const PDFDocument = ({ data }) => {
  useEffect(() => {
    // Tạo một tài liệu jspdf
    const doc = new jsPDF();

    // Tải font Arial Unicode MS
    

    // Sử dụng font 'Arial Unicode MS' cho tài liệu
    doc.setFont('Roboto');

    // Thêm nội dung vào tài liệu
    doc.setFontSize(18);
    doc.text(data.titles, 105, 20, 'center');

    doc.setFontSize(12);
    doc.text(data.paymentStatus, 20, 40);

    // Thêm nội dung cho "Đơn vị mua hàng"
    doc.setFontSize(14);
    doc.text("Đơn vị mua hàng", 20, 60);
    doc.setFontSize(12);
    doc.text(`Họ và tên: ${data.fullName} ${data.userName}`, 20, 70);
    doc.text(`Email: ${data.userEmail}`, 20, 80);
    doc.text(`Số điện thoại: ${data.phoneNumber}`, 20, 90);

    // Thêm nội dung cho "Đơn vị bán hàng"
    doc.setFontSize(14);
    doc.text("Đơn vị bán hàng", 140, 60);
    doc.setFontSize(12);
    doc.text("VCDTT", 140, 70);
    doc.addImage(data.imageSrc, 'PNG', 140, 80, 50, 50);
    doc.text(`Mã số thanh toán: ${data.transactionId}`, 140, 140);

    // Thêm nội dung cho "Tên tour"
    doc.setFontSize(14);
    doc.text(`Tên tour: ${data.tourName}`, 20, 160);

    // Tạo một mảng dữ liệu cho bảng
    const tableData = [
      ["#", "Số lượng", "Đơn giá", "Thành tiền"],
      ["Người lớn", data.adultCount, data.tourAdultPrice, data.totalAdultPrice],
      ["Trẻ em", data.childCount, data.tourChildPrice, data.totalChildPrice],
      ["Tổng", "", "", data.totalPrice],
      ["Coupon", "", data.couponPercentage != null ? `${data.couponPercentage}%` : data.couponFixed, ""],
      ["Giá cuối", "", "", data.formattedFinalPrice],
    ];

    // Thêm bảng vào tài liệu sử dụng jspdf-autotable
    doc.autoTable({
      head: [tableData[0]],
      body: tableData.slice(1),
      startY: 180, // Vị trí bắt đầu của bảng
    });

    // Lưu tài liệu PDF
    doc.save("payment_receipt.pdf");
  }, [data]);

  return null;
};

export default PDFDocument;