<?php

include 'connect.php';

$select_books = $conn->prepare("SELECT * FROM `bookinfo` LIMIT 7");
$select_books->execute();
$books = $select_books->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['email'])) {
  $email = htmlspecialchars($_POST['email']);
  try {
      $checkEmail = $conn->prepare("SELECT * FROM subscribers WHERE email = :email");
      $checkEmail->bindParam(':email', $email);
      $checkEmail->execute();
      $rowCount = $checkEmail->rowCount();
      if ($rowCount > 0) {
          echo "<script>window.alert('ইমেইল ইতিমধ্যে সাবস্ক্রাইব করা হয়েছে!');</script>";
      } else {
          $insertSubscriber = $conn->prepare("INSERT INTO subscribers (email) VALUES (:email)");
          $insertSubscriber->bindParam(':email', $email);
          $insertSubscriber->execute();
          header("Location: index.php");
          exit; 
      }
  } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
} else {
  
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="jquery.hislide.css" /> 

    <style>
        .header {
            background-image: linear-gradient(
                to bottom,
                rgba(0,0,0,.8),
                rgba(0,0,0,.2)
            ), url(images/header.jpg);
        }
    </style>
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
              <h2>লগইন</h2>
              <button class="login-btn"><a href="login.php">এডমিন লগইন</a></button>
              <button class="esc-btn">বন্ধ করুন</button>
          </div>
      </div>
        <div class="sectioncontainer headercontainer" id="home">
            <h1>ওয়েব টেকনোলজি বিষয়ক বই এর সমাহার</h1>
            <p>
                এইচটিএমএল, সিএসএস, ইউআই ডিজাইন, পিএইচপি এবং আরও বই এর সন্ধান এখানেই
            </p>
            <form action="search.php" method="POST">
              <input type="text" name="query" placeholder="বই খুঁজুন" />
              <button type="submit"><i class="ri-search-line"></i></button>
            </form>

            
          </div>

    </header>

    <section class="sectioncontainer choosecontainer" id="choose">
      
      <div class="choosecontent">
        <h2 class="sectionheader">বইসমূহ</h2>
        <p class="sectionsubheader">
          বিভিন্ন ওয়েব টেক বিষয়ক বই ব্রাউজ করুন
        </p>
        <div class="choosegrid">
          <div class="choosecard">
            <span><i class="ri-html5-line"></i></span>
            <h4>এইচটিএমএল</h4>
            <p>
              ওয়েব পেজ গঠনের প্রয়োজনীয় বিষয়গুলো আয়ত্ত করুন।
            </p>
          </div>
          <div class="choosecard">
            <span><i class="ri-javascript-line"></i></span>
            <h4>জাভাস্ক্রিপ্ট</h4>
            <p>
              জাভাস্ক্রিপ্ট প্রোগ্রামিং এর মৌলিক বিষয়গুলো শিখুন।
            </p>
          </div>
          <div class="choosecard">
            <span><i class="ri-server-line"></i></span>
            <h4>পিএইচপি</h4>
            <p>
              পিএইচপি শিখে সার্ভার-সাইড স্ক্রিপ্টিং এ দক্ষ হন।
            </p>
          </div>
          <div class="choosecard">
            <span><i class="ri-layout-masonry-line"></i></span>
            <h4>উইআই/উইএক্স</h4>
            <p>
              ইউজার ইন্টারফেস ডিজাইনের নীতিগুলি বুঝুন।
            </p>
          </div>
        </div>
      </div>
      <div class="chooseimage">
        <img src="images/choose.png" alt="choose" />
      </div>
    </section>

    <section class="offercontainer sectioncontainer" id="offer">
    <div class="image-rotator hi-slide">
    
        <div class="hi-prev"></div>
        <div class="hi-next"></div>
        <h2 class="sectionheader2">বর্তমান অফারস</h2>
        <ul>
            <?php foreach ($books as $book): ?>
                <li>
                    <a href="prod.php?book_id=<?= $book['id']; ?>"><img src="uploaded_img/<?= $book['image']; ?>" alt="<?= $book['name_b']; ?>" /></a>
                    <p><?= $book['name_b']; ?></p>
                    <h4><?= $book['price_b']; ?> /=</h4>
                </li>
            <?php endforeach; ?>
        </ul>
        </div>
    </section>

    <section class="sectioncontainer craftcontainer" id="craft">
    <div class="craftcontent">
      <h2 class="sectionheader">বর্তমানে জনপ্রিয় বইসমূহ</h2>
      <button class="btn">ঘুরে দেখুন</button>
    </div>

    <?php
        $select_popular_books = $conn->prepare("SELECT * FROM `bookinfo` LIMIT 3");
        $select_popular_books->execute();
        $popular_books = $select_popular_books->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <?php foreach ($popular_books as $book): ?>
      <div class="craftimage">
        <div class="craftimagecontent">
          <a href="prod.php?book_id=<?= $book['id']; ?>"><img src="uploaded_img/<?= $book['image']; ?>" alt="craft" /></a>
          <p><?= $book['name_b']; ?></p>
          <h4><?= $book['price_b']; ?> /=</h4>
        </div>
      </div>
    <?php endforeach; ?>
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
            <form action="index.php" method="POST">
              <input type="text" name="email" placeholder="আপনার ইমেইল" /> 
              <button type="submit" class="newsub">সাবস্ক্রাইব</button> 
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
   	<script type="text/javascript" src="jquery.hislide.js" ></script>
		<script>
  			$('.image-rotator').hiSlide();
		</script>
</body>
</html>