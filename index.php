<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Cafeteria</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #3E4C59;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
        nav {
            display: flex;
            justify-content: center;
            background-color: #333;
            padding: 10px;
        }
        nav a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 10px;
            border-radius: 5px;
        }
        nav a:hover {
            background-color: #575757;
        }
        .content {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin: 20px;
        }
        .menu-item {
            background-color: white;
            border-radius: 10px;
            margin: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            text-align: center;
            width: 200px;
        }
        .menu-item img {
            width: 100%;
            border-radius: 10px;
        }
        footer {
            text-align: center;
            background-color: #3E4C59;
            color: white;
            padding: 10px;
            margin-top: 20px;
        }
        .cta-btn {
            background-color: #ff5722;
            color: white;
            padding: 15px 30px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .cta-btn:hover {
            background-color: #e64a19;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to the University Cafeteria</h1>
        <p>Serving the best meals and drinks on campus</p>
    </header>
    
    <nav>
        <a href="index.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="contact.php">Contact Us</a>
        <a href="login.php">Login</a>
    </nav>

    <section class="content">
        <div class="menu-item">
            <img src="food1.jpg" alt="Meal 1">
            <h3>Breakfast</h3>
            <p>Delicious sandwiches with a hot drink</p>
            <p>Price: 15 SAR</p>
        </div>
        <div class="menu-item">
            <img src="food2.jpg" alt="Meal 2">
            <h3>Lunch</h3>
            <p>Main dish with a salad and drink</p>
            <p>Price: 25 SAR</p>
        </div>
        <div class="menu-item">
            <img src="food3.jpg" alt="Meal 3">
            <h3>Dinner</h3>
            <p>Light meal after a long day</p>
            <p>Price: 20 SAR</p>
        </div>
    </section>

    <section style="text-align:center; margin: 30px;">
        <button class="cta-btn" onclick="window.location.href='login.php'">Login to Pre-Order</button>
    </section>

    <footer>
        <p>&copy; 2025 University Cafeteria | All rights reserved</p>
    </footer>
</body>
</html>

