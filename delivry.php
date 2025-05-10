<?php
include 'db.php';

// جلب البيانات من الفورم
$name = $_POST['name'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$order_details = $_POST['order_details'];

// إدخال البيانات في جدول التوصيل
$conn->query("INSERT INTO Deliveries (name, phone, address, order_details) VALUES ('$name', '$phone', '$address', '$order_details')");

// التحقق من الفيداليتي
$check = $conn->query("SELECT * FROM Customers WHERE phone = '$phone'");
if ($check->num_rows > 0) {
    // تحديث عدد الطلبات
    $conn->query("UPDATE Customers SET orders_count = orders_count + 1 WHERE phone = '$phone'");
    $result = $conn->query("SELECT orders_count FROM Customers WHERE phone = '$phone'");
    $data = $result->fetch_assoc();
    $count = $data['orders_count'];
} else {
    
    
    $conn->query("INSERT INTO Customers (name, phone) VALUES ('$name', '$phone')");
    $count = 1;
}


echo "sucsesful request <br>";

if ($count == 5) {
    echo "<strong> Congratulations! You have become a faithful customer. In your next order, you will receive a 50% discount </strong>";
}

$conn->close();
?>