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
            echo $color;
            if ($user and $pass) {
                $sql = $connection->prepare("SELECT color,avatar FROM user WHERE username = :username");
                $sql->bindParam(':username', $_SESSION['name']);
                $sql->execute();
                $result = $sql->fetch(PDO::FETCH_ASSOC);
                    $color = $result['color'];
                    $avatar = $result['avatar'];
                    echo "
                <!DOCTYPE html>
                <html lang='fr'>
                <head>
                  <meta charset='UTF-8'>
                  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                  <title>Paramètres</title>
                  <style>
                    body {
                      font-family: Arial, sans-serif;
                      background-color: #f7f7f7;
                      margin: 0;
                      padding: 20px;
                    }
                    
                    header {
                      display: flex;
                      align-items: center;
                      justify-content: space-between;
                      margin-bottom: 20px;
                      border-radius: 5px;
                      padding: 20px;
                      border: 1px solid rgb(0, 196, 65);
                    }
                    
                    header h1 {
                      font-size: 24px;
                      margin: 0;
                    }
                    
                    .back-button {
                      background-color: rgb(0, 196, 65);
                      color: #fff;
                      border: none;
                      padding: 10px 20px;
                      border-radius: 5px;
                      cursor: pointer;
                    }
                    
                    .back-button:hover {
                      background-color: #0069d9;
                    }
                    
                    .avatar-container {
                      display: flex;
                      align-items: center;
                      margin-bottom: 20px;
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

                        .popup-container {
                            position: fixed;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            background-color: rgba(0, 0, 0, 0.5);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            z-index: 9999;
                        }
                
                        .popup {
                            background-color: #fff;
                            border-radius: 5px;
                            padding: 20px;
                            max-width: 400px;
                            text-align: center;
                        }
                
                        .color-picker {
                            margin-bottom: 20px;
                        }

                         .popup-containe-change {
                            position: fixed;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            background-color: rgba(0, 0, 0, 0.5);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            z-index: 9999;
                        }
                
                        .popupchnage{
                            background-color: #fff;
                            border-radius: 5px;
                            padding: 20px;
                            max-width: 400px;
                            text-align: center;
                        }

                        .popup-containe-delete {
                            position: fixed;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            background-color: rgba(0, 0, 0, 0.5);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            z-index: 9999;
                        }
                
                        .popupdelete{
                            background-color: #fff;
                            border-radius: 5px;
                            padding: 20px;
                            max-width: 400px;
                            text-align: center;
                        }

                        .popup-container-avatar {
                            position: fixed;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            background-color: rgba(0, 0, 0, 0.5);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            z-index: 9999;
                        }
                
                        .popupavatar{
                            background-color: #fff;
                            border-radius: 5px;
                            padding: 20px;
                            max-width: 400px;
                            text-align: center;
                        }

                        .post-header .avatar-button {
                            border: none;
                            background-color: transparent;
                            padding: 0;
                            margin-right: 10px;
                          }
                          
                          .post-header .avatar-button img {
                            width: 40px;
                            height: 40px;
                            border-radius: 50%;
                          }
                    
                  </style>
                </head>
                <body>
                  <header>
                    <h1>Settings</h1>
                    <a class='settings-button' href='http://dev.sport-market.shop/easyannounce/announce'>Back</a>
                  </header>
                        <div class='forum-post'>
                        <div class='post-header'>
                            <img src='assets/img/$avatar.jpg' alt='Avatar utilisateur'>
                            <h4 style='color: $color;'>Accounts Settings</h4>
                        </div>
                    <button class='reply-button'  onclick='OpenDelete()'>Delete Account</button>
                    <div id='popupContainerdelete' class='popup-containe-delete' style='display: none;'>
                        <div class='popupdelete'>
                            <form id='popupdelete' method='post'>
                                <h2>Really ?</h2>
                                </br>
                                <button class='reply-button' onclick='OpenDelete()' name = 'delete'>Delete</button>
                            </form>
                        </div>
                    </div>
                    <script>
                        function OpenDelete() {
                            document.getElementById('popupContainerdelete').style.display = 'flex';
                        }

                    </script>

                    <button class='reply-button' onclick='openPopupchange()'>Change Data</button>
                    <div id='popupContainerchange' class='popup-containe-change' style='display: none;'>
                        <div class='popupchnage'>
                        <form id='popupchange' method='post'>
                            <h2>Change Data :</h2>
                              <div class='row'>
                                <i class='fas fa-user'></i>
                                <input type='text' placeholder='Enter new Username' name='new_username' required>
                              </div>
                              </br>
                              <div class='row'>
                                <i class='fas fa-lock'></i>
                                <input type='password' placeholder='Enter newPassword' name='new_password'required>
                              </div>
                            </br>
                            <button class='reply-button' onclick='openPopupchange()'>Appliquer</button>
                        </form>
                        </div>
                    </div>
                    <script>
                        function openPopupchange() {
                            document.getElementById('popupContainerchange').style.display = 'flex';
                        }
                    </script>
                </div>
                </body>
                </html>    
                ";

                if (isset($_POST["delete"])) {
                    $sql = $connection->prepare("DELETE FROM user WHERE username = :username");
                    $sql->bindParam(':username', $_SESSION['name']);
                    $sql->execute();
                    $sql = $connection->prepare("DELETE FROM announce WHERE user = :username");
                    $sql->bindParam(':username', $_SESSION['name']);
                    $sql->execute();
                    $redirectUrl = 'http://dev.sport-market.shop/easyannounce/login';
                    echo '<script>
                            window.location.href = "' . $redirectUrl . '";
                        </script>';
                    }

                    if (isset($_POST["new_username"], $_POST["new_password"])) {
                        $sql = $connection->prepare("UPDATE user SET username = :new_username, password = :password WHERE username = :oldname");
                        $sql->bindParam(':new_username', $_POST["new_username"]);
                        $sql->bindParam(':password', $_POST["new_password"]);
                        $sql->bindParam(':oldname', $_SESSION['name']);
                        $sql->execute();
                        $redirectUrl = 'http://dev.sport-market.shop/easyannounce/login';
                        echo '<script>
                                window.location.href = "' . $redirectUrl . '";
                            </script>';
                        }

                $sql = $connection->prepare("SELECT color,avatar FROM user WHERE username = :username");
                $sql->bindParam(':username', $_SESSION['name']);
                $sql->execute();
                $result = $sql->fetch(PDO::FETCH_ASSOC);
                    $color = $result['color'];
                    $avatar = $result['avatar'];
                    echo "<div class='forum-post'>
                        <div class='post-header'>
                            <img src='assets/img/$avatar.jpg' alt='Avatar utilisateur'>
                            <h4 style='color: $color;'>Style Settings</h4>
                        </div>
                    <button class='reply-button' onclick='openavatar()'>Change avatar</button>
                    <div id='popupavatar' class='popup-container-avatar' style='display: none;'>
                        <div class='popupavatar'>
                        <form id='popupavatar' method='post'>
                            <h2>Choose :</h2>
                            <div class='post-header'>
                            <form method='post'>

                                <label>
                                <input type='radio' name='avatar1' value='avatar1'>
                                <img src='assets/img/avatar1.jpg' alt='Avatar utilisateur'>
                                </label>
                                <label>
                                <input type='radio' name='avatar' value='avatar2'>
                                <img src='assets/img/avatar2.jpg' alt='Avatar utilisateur'>
                                </label>
                                <label>
                                <input type='radio' name='avatar' value='avatar3'>
                                <img src='assets/img/avatar3.jpg' alt='Avatar utilisateur'>
                                </label>
                                <label>
                                <input type='radio' name='avatar' value='avatar4'>
                                <img src='assets/img/avatar4.jpg' alt='Avatar utilisateur'>
                                </label>
                                <label>
                                <input type='radio' name='avatar' value='avatar5'>
                                <img src='assets/img/avatar5.jpg' alt='Avatar utilisateur'>
                                </label>
                                <label>
                                <input type='radio' name='avatar' value='avatar6'>
                                <img src='assets/img/avatar6.jpg' alt='Avatar utilisateur'>
                                </label>
                                </div>                          
                            <button class='reply-button' type='submit'>Appliquer</button>
                            </form>
                          
                            </br>
                            </br>
                            </br>
                        </form>
                        </div>
                    </div>
                    <script>
                        function openavatar() {
                            document.getElementById('popupavatar').style.display = 'flex';
                        }
                    </script>

                    <button class='reply-button' onclick='openPopup()'>Change Name Color</button>
                    <div id='popupContainer' class='popup-container' style='display: none;'>
                        <div class='popup'>
                        <form id='colorForm' method='post'>
                            <h2>Pick a color</h2>
                            </br>
                            <input name='color' type='color' id='colorInput' class='color-picker'>
                            </br>
                            <button class='reply-button' onclick='applyColor()'>Appliquer</button>
                            </br>
                        </form>
                        </div>
                    </div>
                    <script>
                        function openPopup() {
                            document.getElementById('popupContainer').style.display = 'flex';
                        }

                        function applyColor() {
                            var selectedColor = document.getElementById('colorPicker').value;
                            document.getElementById('colorInput').value = selectedColor;
                            document.getElementById('popupContainer').style.display = 'none';
                            document.getElementById('colorForm').submit(); 
                          }
                    </script>
                </div>";

                if (isset($_POST['color'])) {
                    $selectedColor = $_POST['color'];
                    $user = $_SESSION['name'];
                include("config/db_config.php"); 
                    $connection = new PDO("mysql:host=$servername;dbname=$dbname",$username, $password); 
                    $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = $connection->prepare("UPDATE user SET color = :color WHERE username = :user");
                    $sql->bindParam(':color', $selectedColor);
                    $sql->bindParam(':user', $user);
                    $sql->execute(); 
                    $redirectUrl = 'http://dev.sport-market.shop/easyannounce/settings';
                        echo '<script>
                                window.location.href = "' . $redirectUrl . '";
                            </script>';
                  }



                  if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST["avatar"])) {
                      $avatarChoisi = $_POST["avatar"];
                      $user = $_SESSION['name'];
                      $connection = new PDO("mysql:host=$servername;dbname=$dbname",$username, $password); 
                      $connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                      $sql = $connection->prepare("UPDATE user SET avatar = :avatar WHERE username = :user");
                      $sql->bindParam(':avatar', $avatarChoisi);
                      $sql->bindParam(':user', $user);
                      $sql->execute(); 
                      $redirectUrl = 'http://dev.sport-market.shop/easyannounce/settings';
                        echo '<script>
                                window.location.href = "' . $redirectUrl . '";
                            </script>';
                    }
                  }
                  
            }else{
                header('Location: http://dev.sport-market.shop/easyannounce/login');
                exit();
            } 
        }
        catch(PDOException $e){
            echo $e->getMessage();
        } 
    ?>


















