<?php

echo "Transaction Success!";

include 'connect.php';

$total_price_query = $conn->query("SELECT SUM(cart.qty * bookinfo.price_e) AS total_price FROM cart INNER JOIN bookinfo ON cart.isbn_e = bookinfo.isbn_e");
$total_price = 0;
if ($total_price_query) {
    $total_price_row = $total_price_query->fetch(PDO::FETCH_ASSOC);
    $total_price = $total_price_row['total_price'];
}
try {
    $conn->beginTransaction();

    $tempinfo_query = $conn->query("SELECT * FROM tempinfo");
    if ($tempinfo_query) {
        $tempinfo_row = $tempinfo_query->fetch(PDO::FETCH_ASSOC);

        $name = $tempinfo_row['name'];
        $phone = $tempinfo_row['phone'];
        $email = $tempinfo_row['email'];
        $address = $tempinfo_row['address'];
        $zilla = $tempinfo_row['zilla'];
        $upazilla = $tempinfo_row['upazilla'];

    }
    
    $cart_query = $conn->query("SELECT * FROM cart INNER JOIN bookinfo ON cart.isbn_e = bookinfo.isbn_e");
    if ($cart_query) {
        while ($row = $cart_query->fetch(PDO::FETCH_ASSOC)) {
            $isbn = $row['isbn_e'];
            $qty = $row['qty'];
            $price = $row['price_e'];

            $insert_query = $conn->prepare("INSERT INTO orders (name, phone, email, address, zilla, upazilla, price, isbn_e, qty) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_query->execute([$name, $phone, $email, $address, $zilla, $upazilla, $price, $isbn, $qty]);
        }

        $delete_query = $conn->query("DELETE FROM cart");
        $delete_query2 = $conn->query("DELETE FROM tempinfo");
    }

    $conn->commit();

    header("Location: index.php");
    exit();
} catch (Exception $e) {
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

?>