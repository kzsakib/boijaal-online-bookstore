<?php

include 'connect.php';

if(isset($_POST['add_book'])){

   $ename = $_POST['ename'];
   $name = $_POST['name'];
   $price = $_POST['price'];
   $eprice = $_POST['eprice'];
   $author = $_POST['author'];
   $eauthor = $_POST['eauthor'];
   $pagen = $_POST['pagen'];
   $epagen = $_POST['epagen'];
   $isbn = $_POST['isbn'];
   $eisbn = $_POST['eisbn'];
   $rating = $_POST['rating'];
   $erating = $_POST['erating'];
   $cat = $_POST['cat'];
   $ecat = $_POST['ecat'];
   $textd = $_POST['textd'];
   $image_01 = $_FILES['image_01']['name'];
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = 'uploaded_img/'.$image_01;

   $select_products = $conn->prepare("SELECT * FROM `bookinfo` WHERE isbn_e = ?");
   $select_products->execute([$eisbn]);

   if($select_products->rowCount() > 0){
      $message[] = 'product name already exist!';
   }else{

      $insert_products = $conn->prepare("INSERT INTO `bookinfo`(name_e,name_b,price_e,price_b,author_e,author_b,page_e,page_b,isbn_e,isbn_b,description,rate_e,rate_b,category_e,category_b,image) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
      $insert_products->execute([$ename, $name, $eprice, $price, $eauthor, $author, $epagen, $pagen, $eisbn, $isbn, $textd, $erating, $rating, $ecat, $cat, $image_01]);

      if($insert_products){
         if($image_size_01 > 2000000){
            $message[] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            echo "<script>alert('New product added!');</script>";
         }

      }

   }  

   
   

};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `bookinfo` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $delete_product = $conn->prepare("DELETE FROM `bookinfo` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   header('location:addp.php');

};

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
            <div class="Nlogo"><a href="dashboard.php">এডমিন হোমপেজ</a></div>
            <ul class="navlinks" id="nav-links">
                
                <li class="link"><a href="dashboard.php">ড্যাশবোর্ড</a></li>
                
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
            <button class="esc-btn"><a href="addp.php">বন্ধ করুন</a></button>
          </div>
      </div>
    </header>


        <section class="add-products sectioncontainer">

            <h1 class="heading">বই অ্যাড করুন</h1>
         
            <form action="" method="post" enctype="multipart/form-data">
               <div class="flex">
                  <div class="inputBox">
                     <span>নাম</span>
                     <input type="text" class="box" required maxlength="500" placeholder="বইয়ের নাম লিখুন" name="name">
                  </div>
                  <div class="inputBox">
                     <span>ইংরেজিতে নাম</span>
                     <input type="text" class="box" required maxlength="500" placeholder="বইয়ের ইংরেজিতে নাম লিখুন" name="ename">
                  </div>
                  <div class="inputBox">
                     <span>দাম</span>
                     <input type="text" min="0" class="box" required max="9999999999" placeholder="বইয়ের দাম লিখুন"  name="price">
                  </div>
                  <div class="inputBox">
                     <span>ইংরেজিতে দাম</span>
                     <input type="number" min="0" class="box" required max="9999999999" placeholder="বইয়ের ইংরেজিতে দাম লিখুন"  name="eprice">
                  </div>
                 <div class="inputBox">
                    <span>লেখক</span>
                    <input type="text" min="0" class="box" required max="9999999999" placeholder="বইয়ের লেখকের নাম লিখুন"  name="author">
                 </div>
                 <div class="inputBox">
                    <span>ইংরেজিতে লেখক</span>
                    <input type="text" min="0" class="box" required max="9999999999" placeholder="বইয়ের লেখকের নাম ইংরেজিতে লিখুন"  name="eauthor">
                 </div>
                 <div class="inputBox">
                    <span>পেইজ সংখ্যা</span>
                    <input type="text" min="0" class="box" required max="9999999999" placeholder="বইয়ের পেইজ সংখ্যা লিখুন"  name="pagen">
                 </div>
                 <div class="inputBox">
                    <span>ইংরেজিতে পেইজ সংখ্যা</span>
                    <input type="number" min="0" class="box" required max="9999999999" placeholder="বইয়ের পেইজ সংখ্যা ইংরেজিতে লিখুন"  name="epagen">
                 </div>
                 <div class="inputBox">
                    <span>আইএসবিএন</span>
                    <input type="text" min="0" class="box" required max="9999999999" placeholder="বইয়ের আইএসবিএন লিখুন"  name="isbn">
                 </div>
                 <div class="inputBox">
                    <span>ইংরেজিতে আইএসবিএন</span>
                    <input type="number" min="0" class="box" placeholder="বইয়ের আইএসবিএন ইংরেজিতে লিখুন"  name="eisbn">
                 </div>
                 <div class="inputBox">
                    <span>রেটিং</span>
                    <input type="text" min="0" class="box" required max="9999999999" placeholder="বইয়ের রেটিং লিখুন"  name="rating">
                 </div>
                 <div class="inputBox">
                    <span>ইংরেজিতে রেটিং</span>
                    <input type="number" min="0" step="0.1" class="box" required max="9999999999" placeholder="বইয়ের রেটিং ইংরেজিতে লিখুন"  name="erating">
                 </div>
                 <div class="inputBox">
                    <span>ক্যাটাগরি</span>
                    <input type="text" min="0" class="box" required max="9999999999" placeholder="বইয়ের ক্যাটাগরি লিখুন"  name="cat">
                 </div>
                 <div class="inputBox">
                    <span>ইংরেজিতে ক্যাটাগরি</span>
                    <input type="text" min="0" class="box" required max="9999999999" placeholder="বইয়ের ক্যাটাগরি ইংরেজিতে লিখুন"  name="ecat">
                 </div>
                 <div class="inputBox"  id="textd">
                    <span>বর্ণনা</span>
                    <input type="text" min="0" class="box" required max="9999999999" placeholder="বইয়ের বর্ণনা লিখুন" name="textd">
                 </div>
                 <div class="inputBox">
                     <span>ছবি</span>
                     <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp, image/gif" class="box" required>
                 </div>
               </div>
               
               <input type="submit" value="অ্যাড" class="btn" name="add_book">
            </form>
         
         </section>
         
         <section class="show-products sectioncontainer">
         
            <h1 class="heading">সকল বই যেগুলো অ্যাড করা হয়েছে</h1>
         
            <div class="box-container sectioncontainer">
         
            <?php
               $select_products = $conn->prepare("SELECT * FROM `bookinfo`");
               $select_products->execute();
               if($select_products->rowCount() > 0){
                  while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
            ?>
                  <div class="box">
                     <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
                     <div class="name"><?= $fetch_products['name_b']; ?></div>
                     <div class="price"><span><?= $fetch_products['price_b']; ?></span>/=</div>
                     <div class="flex-btn">
                        <a href="addp.php?delete=<?= $fetch_products['id']; ?>" class="btn" onclick="return confirm('delete this product?');">ডিলিট</a>
                     </div>
                  </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
   ?>
          
            </div>
         
         </section>
         

    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="main.js"></script>
</body>
</html>