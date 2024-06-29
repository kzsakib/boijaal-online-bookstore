  <?php
  include 'connect.php';

  function english_to_bangla_number($number) {
    $bangla_digits = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
    $english_digits = range(0, 9);
    return str_replace($english_digits, $bangla_digits, $number);
  }


  if(isset($_POST['clear_cart'])) {
    $conn->query("TRUNCATE TABLE cart");
    echo "<script>alert('কার্ট মুছে ফেলা হয়েছে।');</script>";
  }

  if(isset($_POST['delete_book'])) {
    $isbn = $_POST['isbn'];
    $conn->query("DELETE FROM cart WHERE isbn_e = '$isbn'");
    echo "<script>alert('বই ডিলিট করা হয়েছে।');</script>";
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

      <section class="products shopping-cart sectioncontainer">
      <h3 class="heading">আপনার শপিং কার্ট</h3>
      <div class="box-container">
          <?php
          $cart_items_query = $conn->query("SELECT cart.qty, bookinfo.* FROM cart INNER JOIN bookinfo ON cart.isbn_e = bookinfo.isbn_e");
          if ($cart_items_query) {
              while ($cart_item = $cart_items_query->fetch(PDO::FETCH_ASSOC)) {
                  $sub_total = $cart_item['qty'] * $cart_item['price_e'];
          ?>
                  <form action="" method="post" class="box">
                      <img src="uploaded_img/<?= $cart_item['image']; ?>" alt="">
                      <div class="name"><?= $cart_item['name_b']; ?></div>
                      <div class="flex">
                      <div class="price"><?= english_to_bangla_number($cart_item['price_e']); ?>/=</div>
                      </div>
                      <div class="sub-total"> মোট : <span><?= english_to_bangla_number($sub_total); ?>/=</span> </div>
                      <input type="hidden" name="isbn" value="<?= $cart_item['isbn_e']; ?>">
                      <input type="submit" value="বই ডিলিট করুন" class="btn" name="delete_book">
                  </form>
          <?php
              }
          }
          ?>
      </div>

      <div class="cart-total">
          <?php
          $total_price_query = $conn->query("SELECT SUM(cart.qty * bookinfo.price_e) AS total_price FROM cart INNER JOIN bookinfo ON cart.isbn_e = bookinfo.isbn_e");
          $total_price = 0;
          if ($total_price_query) {
              $total_price_row = $total_price_query->fetch(PDO::FETCH_ASSOC);
              $total_price = $total_price_row['total_price'];
          }
          ?>
          <p>সর্বমোট : <span><?= english_to_bangla_number($total_price); ?>/=</span></p>
          <a href="category.php" class="btn">কেনাকাটা চালিয়ে যান</a>
          <a href="#" class="btn" onclick="document.getElementById('clear_cart_form').submit();">কার্ট মুছে ফেলুন</a>
          <form id="clear_cart_form" action="" method="post" style="display: none;">
              <input type="hidden" name="clear_cart" value="1">
          </form>
          <a href="checkout.php" class="btn">চেকআউট</a>
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