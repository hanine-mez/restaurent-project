<?php
include 'db.php';

// جلب البيانات من الفورم
$name = $_POST['name'];
$phone = $_POST['phone'];
$date = $_POST['date'];
$time = $_POST['time'];
$guests = $_POST['guests'];

// إدخال البيانات في جدول الحجز
$conn->query("INSERT INTO Reservations (name, phone, date, time, guests) VALUES ('$name', '$phone', '$date', '$time', $guests)");

// التحقق من الفيداليتي
$check = $conn->query("SELECT * FROM Customers WHERE phone = '$phone'");
if ($check->num_rows > 0) {
    // تحديث عدد الطلبات
    $conn->query("UPDATE Customers SET orders_count = orders_count + 1 WHERE phone = '$phone'");
    $result = $conn->query("SELECT orders_count FROM Customers WHERE phone = '$phone'");
    $data = $result->fetch_assoc();
    $count = $data['orders_count'];
} else {
    // إذا كان الزبون غير موجود، إضافته
    $conn->query("INSERT INTO Customers (name, phone) VALUES ('$name', '$phone')");
    $count = 1;
}

// طباعة رسالة التأكيد
echo "sucsesful request<br>";

if ($count == 5) {
    echo "<strong> Congratulations! You have become a faithful customer. In your next order, you will receive a 50% discount </strong>";
}

$conn->close();
?>