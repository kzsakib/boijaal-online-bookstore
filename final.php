<?php
include 'connect.php';
session_start();
function english_to_bangla_number($number) {
    $bangla_digits = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
    $english_digits = range(0, 9);
    return str_replace($english_digits, $bangla_digits, $number);
}

$total_price_query = $conn->query("SELECT SUM(cart.qty * bookinfo.price_e) AS total_price FROM cart INNER JOIN bookinfo ON cart.isbn_e = bookinfo.isbn_e");
        $total_price = 0;
        if ($total_price_query) {
            $total_price_row = $total_price_query->fetch(PDO::FETCH_ASSOC);
            $total_price = $total_price_row['total_price'];
        }

if(isset($_POST['order'])) {

    $name = $_POST['name'];
    $phone = $_POST['number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $zilla = $_POST['zilla'];
    $upazilla = $_POST['upazilla'];

    $sql = "INSERT INTO tempinfo (name, phone, email, address, zilla, upazilla) VALUES ('$name', '$phone', '$email', '$address', '$zilla', '$upazilla')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
    }
 

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
            <div class="Nlogo"><a href="index.php">বইজাল</a></div>
            <ul class="navlinks" id="nav-links">
                <li class="link"><a href="index.php">হোম</a></li>
                <li class="link"><a href="category.php">বইসমূহ </a></li>
                <li class="link"><a href="#help">সাহায্য</a></li>
              </ul>
              <div class="menubtn" id="menu-btn">
                <span><i class="ri-menu-line"></i></span>
              </div>
              <div class="navactions">
                <a href="cart.php"><span><i class="ri-shopping-cart-2-fill"></i></span></a>
                <span class="user-icon" id="user-icon"><i class="ri-user-fill"></i></span>
              </div>
        </nav>
        <div class="overlay" id="overlay">
          <div class="overlay-content">
              <span class="close-btn" id="close-btn">&times;</span>
              <h2>লগইন অথবা রেজিস্টার</h2>
              <button class="login-btn"><a href="login.php">এডমিন লগইন</a></button>
              <button class="esc-btn">বন্ধ করুন</button>
          </div>
      </div>
    </header>

    <section class="final-orders sectioncontainer">
        <h3>আপনার অর্ডারসমূহ</h3>
        <div class="display-orders">
            <div class="order-info">
                <span>নাম :</span>
                <span><?= isset($name) ? $name : ''; ?></span>
            </div>
            <div class="order-info">
                <span>ফোন নাম্বার :</span>
                <span><?= isset($phone) ? $phone : ''; ?></span>
            </div>
            <div class="order-info">
                <span>ই-মেইল :</span>
                <span><?= isset($email) ? $email : ''; ?></span>
            </div>
            <div class="order-info">
                <span>ঠিকানা :</span>
                <span><?= isset($address) ? $address : ''; ?></span>
            </div>
            <div class="order-info">
                <span>জেলা :</span>
                <span><?= isset($zilla) ? $zilla : ''; ?></span>
            </div>
            <div class="order-info">
                <span>উপজেলা / থানা :</span>
                <span><?= isset($upazilla) ? $upazilla : ''; ?></span>
            </div>
            <div class="order-info">
                <span>সর্বমোট মূল্য :</span>
                <span><?= isset($total_price) ? english_to_bangla_number($total_price) : ''; ?>/=</span>
            </div>

            <a href="ssl.php?name=<?= urlencode($name) ?>&phone=<?= urlencode($phone) ?>&price=<?= urlencode($total_price) ?>">এগিয়ে যান</a>
        </div>
    </section>
     
     
  
    <footer class="footer">
      <div class="sectioncontainer footercontainer">
        <div class="footercontent">
          <h4>আমাদের সম্পর্কে সর্বশেষ খবর পেতে সাবস্ক্রাইব করুন</h4>
          <p>
            যেকোনো নতুন বই এর আপডেট পেতে আপনার ইমেইল লিখুন
          </p>
        </div>
        <div class="footerform">
          <form action="/">
            <input type="text" placeholder="আপনার ইমেইল" />
            <button>সাবস্ক্রাইব</button>
          </form>
        </div>
      </div>
      <div class="sectioncontainer footerbar">
        <div class="footerlogo">
          <h4><a href="#">বইজাল</a></h4>
        </div>
        <ul class="footernav">
          <li class="footerlink"><a href="#">সম্পর্কিত</a></li>
          <li class="footerlink"><a href="#">সাহায্য</a></li>
          <li class="footerlink"><a href="#">যোগযোগ</a></li>
          
        </ul>
      </div>
    </footer>


    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="main.js"></script>
</body>
</html>