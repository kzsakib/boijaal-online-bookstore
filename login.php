<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $stmt = $conn->prepare("SELECT * FROM admin WHERE name = :username AND password = :password");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($user) {
        header("Location: dashboard.php");
        exit();
    } else {
       
        echo "<script>alert('ইউজারনেম অথবা পাসওয়ার্ড সঠিক নয়');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url('images/loginbg.jpg') center center/cover no-repeat;
            font-family: "Noto Sans Bengali", sans-serif;
        }
        
        .container {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            backdrop-filter: blur(20px);
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            text-align: center;
            color: black;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            color: antiquewhite;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.8);
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
            color: #333;
        }
        
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: #333;
            color: antiquewhite;
            cursor: pointer;
        }
        
        input[type="submit"]:hover {
            background: #222;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>এডমিন লগইন</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">ইউজারনাম</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">পাসওয়ার্ড</label>
                <input type="password" id="password" name="password" required>
            </div>
            <input type="submit" value="লগইন">
        </form>
    </div>
</body>
</html>
