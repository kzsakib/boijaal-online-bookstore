<?php
include 'connect.php';

if(isset($_POST['query'])) {
    $search_query = htmlspecialchars($_POST['query']);
    $search_sql = "SELECT * FROM `bookinfo` WHERE name_e LIKE :name_e OR name_b LIKE :name_b";

    $stmt = $conn->prepare($search_sql);

    $stmt->bindParam(':name_e', $search_query_param, PDO::PARAM_STR);
    $stmt->bindParam(':name_b', $search_query_param, PDO::PARAM_STR);

    $search_query_param = "%$search_query%";

    $stmt->execute();

    $search_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if(isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];
  
    $select_book_details = $conn->prepare("SELECT * FROM `bookinfo` WHERE id = ?");
    $select_book_details->execute([$book_id]);
    $book = $select_book_details->fetch(PDO::FETCH_ASSOC);
  
  };
  
  if(isset($_POST['cart']) && isset($_POST['isbn'])) {
    $isbn = $_POST['isbn'];
  
    $existing_cart_item = $conn->query("SELECT * FROM cart WHERE isbn_e = '$isbn'")->fetch();
  
    if ($existing_cart_item) {
        
        $new_quantity = $existing_cart_item['qty'] + 1; 
        $conn->query("UPDATE cart SET qty = $new_quantity WHERE isbn_e = '$isbn'");
        echo "<script>alert('Quantity updated in cart.');</script>";
    } else {
        $conn->query("INSERT INTO cart (isbn_e, qty) VALUES ('$isbn', 1)");
        echo "<script>alert('Book added to cart.');</script>";
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
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

    <?php if(isset($search_results) && !empty($search_results)): ?>
<section id="browse-books" class="sectioncontainer">
    <h2>সার্চ ফলাফল</h2>
    <div class="pro-container">
        <?php foreach ($search_results as $book): ?>
        <a href="prod.php?book_id=<?= $book['id']; ?>" class="pro-link">
            <div class="pro">
                <img src="uploaded_img/<?= $book['image']; ?>">
                <div class="des">
                    <span><?= $book['category_b']; ?></span>
                    <h5><?= $book['name_b']; ?></h5>
                    <h4><?= $book['price_b']; ?>/=</h4>
                </div>
                <form action="" method="post">
                <input type="hidden" name="isbn" value="<?= $book['isbn_e']; ?>">
                <button type="submit" class="add-to-cart-btn" name="cart">
                    <i class="ri-add-line add"></i> 
                </button>
                </form>
            </div>
        </a>
        <?php endforeach; ?>
        </div>
        </section>
        <?php endif; ?>


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
