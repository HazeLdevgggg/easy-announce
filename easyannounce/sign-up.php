<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Sign-UP</title> 
     <link rel="stylesheet" href="assets/css/style-login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
  </head>
  <body>
    <div class="container">
      <div class="wrapper">
        <div class="title"><span>Sign-UP</span></div>
        <form method ="post">
        <div class="row">
        <i class="fas fa-user"></i>
            <input type="text" placeholder="Enter Mail" name="mail" required>
          </div>
          <div class="row">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Enter Username" name="username" required>
          </div>
          <div class="row">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Enter Password" name="password"required>
          </div>
          <div class="pass"><a href="#">Forgot password?</a></div>
          <div class="row button">
            <input type="submit" value="Login">
          </div>
          <div class="signup-link">Account Create ?<a href="http://dev.sport-market.shop/easyannounce/login"> Go to Login</a></div>
        </form>
      </div>
    </div>
  </body>
</html>

<?
   if (isset($_POST['username'], $_POST['password'])) {
    try {
        include("config/db_config.php");  
        $connection = new PDO("mysql:host=$servername;dbname=$dbname",$username, $password); 
        $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $mail = $_POST['mail'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $date = date("Y-m-d H:i:s");
        $stmt = $connection->prepare("SELECT * FROM user WHERE username=:username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch();
        $stmt = $connection->prepare("SELECT * FROM user WHERE password=:password");
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $pass = $stmt->fetch();
        if ($user || $pass) {
          echo '<script>alert("Mail or Username Already Used");</script>';
        } else {
            $basic_color ='#000';
            $avatar = 'avatar1';
            $stmt = $connection->prepare("INSERT INTO user (mail, username, password, ip, date, color, avatar) VALUES (:mail, :username, :password, :ip, :date, :color, :avatar)");
            $stmt->bindParam(':mail', $mail);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':ip', $ip);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':color', $basic_color);
            $stmt->bindParam(':avatar', $avatar);
            $stmt->execute();
            echo '<script>alert("Account create!");</script>';
            header('Location: http://dev.sport-market.shop/easyannounce/login.php');
            exit();
        }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    ?>
</body>     
</html>