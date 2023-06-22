
  <?
        session_start ();
        $_SESSION['admin_pass'];
        $_SESSION['admin_name'];
        try{
            include("config/admin_db_config.php");
            $connection = new PDO("mysql:host=$servername;dbname=$dbname",$username, $password); 
            $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $connection->prepare("SELECT * FROM admin WHERE username=:username");
            $stmt->bindParam(':username', $_SESSION['admin_name']);
            $stmt->execute(); 
            $user = $stmt->fetch();
            $stmt = $connection->prepare("SELECT * FROM admin WHERE password=:password");
            $stmt->bindParam(':password', $_SESSION['admin_pass']);
            $stmt->execute(); 
            $pass = $stmt->fetch();
            if ($user and $pass) {
                echo '
                <!DOCTYPE html>
                <html lang="fr">
                <head>
                  <meta charset="UTF-8">
                  <meta name="viewport" content="width=device-width, initial-scale=1.0">
                  <title>Administration</title>
                  <style>
                  body {
                                      font-family: Arial, sans-serif;
                                      background-color: #f7f7f7;
                                      margin: 0;
                                      padding: 20px;
                                    }
                                    
                                    .forum-post {
                                      background-color: #fff;
                                      border-radius: 5px;
                                      padding: 20px;
                                      margin-bottom: 20px;
                                      border: 1px solid rgb(0, 196, 65);
                                    }
                
                                    .admin-info {
                                      background-color: #fff;
                                      border-radius: 5px;
                                      padding: 20px;
                                      margin-bottom: 20px;
                                      border: 3px solid rgb(0, 196, 65);
                                    }
                                    
                                    .post-header {
                                      display: flex;
                                      align-items: center;
                                      margin-bottom: 10px;
                                    }
                                    
                                    .post-header img {
                                      width: 40px;
                                      height: 40px;
                                      border-radius: 50%;
                                      margin-right: 10px;
                                    }
                                    
                                    .post-content {
                                      margin-bottom: 10px;
                                    }
                                    
                                    .reply-button {
                                      background-color: rgb(0, 196, 65);
                                      color: #fff;
                                      border: none;
                                      padding: 10px 20px;
                                      border-radius: 5px;
                                      cursor: pointer;
                                    }
                                    
                                    .reply-button:hover {
                                      background-color: #0069d9;
                                    }
                                    
                                    .create-post-form {
                                      background-color: #fff;
                                      border-radius: 5px;
                                      padding: 20px;
                                      border: 1px solid rgb(0, 196, 65);
                                    }
                                    
                                    .create-post-form textarea {
                                      width: 100%;
                                      padding: 10px;
                                      border: 1px solid #ccc;
                                      border-radius: 5px;
                                      resize: vertical;
                                      margin-bottom: 10px;
                                      margin-left: -10px;
                                    }
                                
                                    header {
                                      display: flex;
                                      align-items: center;
                                      justify-content: space-between;
                                      margin-bottom: 20px;
                                      border-radius: 5px;
                                      padding: 20px;
                                      border: 3px solid rgb(0, 196, 65);
                                    }
                                    
                                    header h1 {
                                      font-size: 24px;
                                      margin: 0;
                                    }
                                    
                                    .settings-button {
                                      background-color: rgb(0, 196, 65);
                                      color: #fff;
                                      border: none;
                                      padding: 10px 20px;
                                      border-radius: 5px;
                                      cursor: pointer;
                                    }
                                    
                                    .settings-button:hover {
                                      background-color: #0069d9;
                                    }
                                    
                                    .create-post-form button {
                                      background-color: rgb(0, 196, 65);
                                      color: #fff;
                                      border: none;
                                      padding: 10px 20px;
                                      border-radius: 5px;
                                      cursor: pointer;
                                    }
                                    
                                    .create-post-form button:hover {
                                      background-color: #0069d9;
                                    }
                  </style>
                </head>
                <body>
                  <header>
                    <h1>Administration</h1>
                  </header>



                                  <h2>Utilisateurs :</h2>

                 
                          ";
                ';

                $recup_user = "SELECT username, avatar, color, ip FROM user";
                $result = $connection->query($recup_user);
                
                if ($result->rowCount() > 0) {
                  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $color = $row['color'];
                    $avatar = $row['avatar'];
                    $user = $row['username'];
                        echo "
                              <div class='forum-post'>
                                  <div class='post-header'>
                                      <img src='/easyannounce/assets/img/$avatar.jpg' alt='Avatar utilisateur'>
                                      <h4 style='color: $color;'>$user</h4>
                                  </div>
                                  <form method='post' id='banoranswer'>
                                      <button class='reply-button' name='ban' value='ban'>Ban</button>
                                      <input type='hidden' name='postId'>
                                  </form>
                              </div>
                          </div>
                              ";
                    }
                } 
                    
            }else{
                header('Location: http://dev.sport-market.shop/easyannounce/admin/admin-login.php');
                exit();
            } 
        }
        catch(PDOException $e){
            echo $e->getMessage();
        } 
    ?>
