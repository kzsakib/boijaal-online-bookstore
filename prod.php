  <?php
  include 'connect.php';

  if(isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];

    $select_book_details = $conn->prepare("SELECT * FROM `bookinfo` WHERE id = ?");
    $select_book_details->execute([$book_id]);
    $book_details = $select_book_details->fetch(PDO::FETCH_ASSOC);

  };

  if(isset($_POST['cart']) && isset($_POST['isbn'])) {
    $isbn = $_POST['isbn'];

    $existing_cart_item = $conn->query("SELECT * FROM cart WHERE isbn_e = '$isbn'")->fetch();

    if ($existing_cart_item) {
        
        $new_quantity = $existing_cart_item['qty'] + 1; 
        $conn->query("UPDATE cart SET qty = $new_quantity WHERE isbn_e = '$isbn'");
        echo "<script>alert('কার্টে পণ্যের পরিমাণ আপডেট হয়েছে.');</script>";
    } else {
        $conn->query("INSERT INTO cart (isbn_e, qty) VALUES ('$isbn', 1)"); 
        echo "<script>alert('বই অ্যাড করা হয়েছে.');</script>";
    }
  }

  if(isset($_POST['cart']) || isset($_POST['buy'])) {
    $isbn = $_POST['isbn'];

    $existing_cart_item = $conn->query("SELECT * FROM cart WHERE isbn_e = '$isbn'")->fetch();

    if ($existing_cart_item) {
        if(isset($_POST['buy'])) {
            $new_quantity = $existing_cart_item['qty'] + 1;
        } else {
            $new_quantity = $existing_cart_item['qty']; 
        }
        $conn->query("UPDATE cart SET qty = $new_quantity WHERE isbn_e = '$isbn'");
        echo "<script>alert('কার্টে পণ্যের পরিমাণ আপডেট হয়েছে.');</script>";
    } else {
        $conn->query("INSERT INTO cart (isbn_e, qty) VALUES ('$isbn', 1)"); 
        echo "<script>alert('বই অ্যাড করা হয়েছে.');</script>";
    }
    header("Location: cart.php");
    exit();
  }
  ?>
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

      <section id="prodetails" class="sectioncontainer">
      <div class="singleimage">
          <img src="uploaded_img/<?= $book_details['image']; ?>" width="100%" id="MainImg">
      </div>
      <div class="singleprodetails">
          <h5><a href="">হোম</a>/<?= $book_details['category_b']; ?></h5>
          <h2><?= $book_details['name_b']; ?></h2>
          <h6>লেখক : <?= $book_details['author_b']; ?></h6>
          <h1><?= $book_details['price_b']; ?> /=</h1>
          <h3>পেইজ সংখ্যা : <?= $book_details['page_b']; ?></h3>
          <h3>আইএসবিএন : <?= $book_details['isbn_b']; ?></h3>
          <h3>রেটিং : <?= $book_details['rate_b']; ?></h3>
          <form action="" method="post">
          <input type="hidden" name="isbn" value="<?= $book_details['isbn_e']; ?>">
          <button type="submit" class="btn buycart" name="buy">কিনুন</button>
          </form>

          <form action="" method="post">
          <input type="hidden" name="isbn" value="<?= $book_details['isbn_e']; ?>">
          <button type="submit" class="btn addcart" name="cart">কার্ট এ অ্যাড করুন</button>
          </form>
          <br><br>
          <h6>বর্ণনা :</h6>
          <span><?= $book_details['description']; ?></span>
      </div>  
      </section>

  <?php
  $stmt = $conn->prepare("SELECT * FROM `bookinfo` ORDER BY id DESC LIMIT 4");
  $stmt->execute();
  $featured_books = $stmt->fetchAll(PDO::FETCH_ASSOC);
  ?>

  <section id="product1" class="sectioncontainer">
    <h2>বিশেষ বইসমূহ</h2>
    <div class="pro-container">
      <?php foreach ($featured_books as $book): ?>
        <a href="prod.php?book_id=<?php echo $book['id']; ?>" class="pro-link">
          <div class="pro">
            <img src="uploaded_img/<?php echo $book['image']; ?>">
            <div class="des">
              <span><?php echo $book['category_b']; ?></span>
              <h5><?php echo $book['name_b']; ?></h5>
              <h4><?php echo $book['price_b']; ?>/=</h4>
            </div>
            <i class="ri-add-line add"></i>
          </div>
        </a>
      <?php endforeach; ?>
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