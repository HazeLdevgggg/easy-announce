<?
        session_start ();
        $_SESSION['pass'];
        $_SESSION['name'];
        try{
            include("config/db_config.php"); 
            $connection = new PDO("mysql:host=$servername;dbname=$dbname",$username, $password); 
            $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $connection->prepare("SELECT * FROM user WHERE username=:username");
            $stmt->bindParam(':username', $_SESSION['name']);
            $stmt->execute(); 
            $user = $stmt->fetch();
            $stmt = $connection->prepare("SELECT * FROM user WHERE password=:password");
            $stmt->bindParam(':password', $_SESSION['pass']);
            $stmt->execute(); 
            $pass = $stmt->fetch();
            if ($user and $pass) {
                echo '
                <!DOCTYPE html>
                <html lang="fr">
                <head>
                  <meta charset="UTF-8">
                  <meta name="viewport" content="width=device-width, initial-scale=1.0">
                  <title>Forum</title>
                  <style>
                    /* Styles CSS pour le forum */
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
                      border: 1px solid rgb(0, 196, 65);
                      background-color: #fff;
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
                      text-decoration: none;
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
                    <h1>Easy Announce</h1>
                      <a class="settings-button" href="http://dev.sport-market.shop/easyannounce/settings">Paramètres</a>
                    </header>

                
                  <div class="create-post-form">
                  <h3>Créer un nouveau post</h3>
                  <form method="POST">
                    <textarea name="message" rows="4" placeholder="Entrez votre message ici" required></textarea>
                    <button type="submit">Envoyer</button>
                  </form>
                </div>
                </br>
                <h1>All Post :</h1>
                </body>
                </html>
                ';
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $message = $_POST['message'];
                        $user=  $_SESSION['name'];
                        include("config/db_config.php"); 
                        $connection = new PDO("mysql:host=$servername;dbname=$dbname",$username, $password); 
                        $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = $connection->prepare("INSERT INTO announce (user, message ) VALUES (:user, :message)");
                        $sql->bindParam(':user', $user);
                        $sql->bindParam(':message', $message);
                        $sql->execute(); 
                      }
                        include("config/db_config.php"); 
                      $conn = new mysqli($servername, $username, $password, $dbname);
                      if ($conn->connect_error) {
                          die("Connection failed: " . $conn->connect_error);
                      }
                      $recup_post = "SELECT user, color, message, id, idawnser FROM announce ORDER BY id DESC LIMIT 10";
                      $result = $conn->query($recup_post);

                      if ($result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                              $username = $row['user'];
                              $sql = $connection->prepare("SELECT color, avatar, id FROM user WHERE username = :username");
                              $sql->bindParam(':username', $username);
                              $sql->execute();
                              $userResult = $sql->fetch(PDO::FETCH_ASSOC);
                              $color = $userResult['color'];
                              $avatar = $userResult['avatar'];
                              $user = $row['user'];
                              $message = $row['message'];
                              $postId = $row['id'];
                              $idawnser = $row['idawnser'];
                              if ($message == NULL) {
                                $sql = $connection->prepare("DELETE FROM announce WHERE message IS NULL");
                                $sql->execute();
                            }elseif ($idawnser == '') {

                              echo "<div class='forum-post'>
                                  <div class='post-header'>
                                      <img src='assets/img/$avatar.jpg' alt='Avatar utilisateur'>
                                      <h4 style='color: $color;'>$user</h4>
                                  </div>
                                  <div class='post-content'>
                                      <p>$message</p>
                                  </div>
                                  </br>
                                  </br>
                                  <form method='post' id='banoranswer'>
                                      <button class='reply-button' name='ban' value='ban'>Ban</button>
                                      <input type='hidden' name='postId' value='$postId'>
                                  </form>
                              </div>";
                                if (isset($_POST['messageawnser'])) {
                                    $awnser_message = $_POST['messageawnser'];
                                    $postId = $row['id'];
                                    echo $postId;
                                    $sql = $connection->prepare("INSERT INTO announce (user, message, idawnser) VALUES (:username, :message, :idawnser)");
                                    $sql->bindParam(':idawnser', $postId);
                                    $sql->bindParam(':username', $_SESSION['name']);
                                    $sql->bindParam(':message', $_POST['messageawnser']);
                                    $sql->execute();
                                }
                              }
                        }
                    }
                      $conn->close();
            }else{
                header('Location: http://dev.sport-market.shop/easyannounce/login');
                exit();
            } 
        }
        catch(PDOException $e){
            echo $e->getMessage();
        } 
    ?>

















