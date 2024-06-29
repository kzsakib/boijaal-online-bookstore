<?php
include 'connect.php';

$total_price_query = $conn->query("SELECT SUM(price * qty) AS total_price FROM orders");
if ($total_price_query) {
    $total_price_row = $total_price_query->fetch(PDO::FETCH_ASSOC);
    $total_sale_price = $total_price_row['total_price'];
} else {
    $total_sale_price = 0;
}

$total_qty_query = $conn->query("SELECT SUM(qty) AS total_qty FROM orders");
if ($total_qty_query) {
    $total_qty_row = $total_qty_query->fetch(PDO::FETCH_ASSOC);
    $total_qty = $total_qty_row['total_qty'];
} else {
   
    $total_qty = 0;
}

$count_query = $conn->query("SELECT COUNT(*) AS total_books FROM bookinfo");
if ($count_query) {
    $count_row = $count_query->fetch(PDO::FETCH_ASSOC);
    $total_books = $count_row['total_books'];
} else {
    
    $total_books = 0;
}

function english_to_bangla_number($number) {
   $bangla_digits = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
   $english_digits = range(0, 9);
   return str_replace($english_digits, $bangla_digits, $number);
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
    <nav>
            <div class="Nlogo"><a href="#">এডমিন হোমপেজ</a></div>
            <ul class="navlinks" id="nav-links">
                
                <li class="link"><a href="addp.php">বই অ্যাড করুন</a></li>
                
              </ul>
              <div class="menubtn" id="menu-btn">
                <span><i class="ri-menu-line"></i></span>
              </div>
              <div class="navactions">
                
                <span class="user-icon" id="user-icon"><i class="ri-user-fill"></i></span>
              </div>
        </nav>
        <div class="overlay" id="overlay">
          <div class="overlay-content">
              <button class="esc-btn"><a href="index.php">লগ আউট</a></button>
              <button class="esc-btn"><a href="dashboard.php">বন্ধ করুন</a></button>
          </div>
      </div>
    </header>

    <section class="dashboard">

<h1 class="heading">ড্যাশবোর্ড</h1>

<div class="box-container sectioncontainer">

   <div class="box">
      <h3>স্বাগতম!</h3>
      <p>অ্যাডমিন</p>
      
   </div>

   <div class="box">
      <h3><?php echo english_to_bangla_number($total_sale_price); ?><span>/=</span></h3>
      <p>অর্ডার কমপ্লিট</p>
      
   </div>

   <div class="box">
      <h3><?php echo english_to_bangla_number($total_qty); ?><span>টি</span></h3>
      <p>বিক্রিত বই</p>
     
   </div>

   <div class="box">
      <h3><?php echo english_to_bangla_number($total_books); ?><span>টি</span></h3>
      <p>বই অ্যাড করা হয়েছে</p>
      
   </div>

</section>

    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="main.js"></script>
</body>
</html>