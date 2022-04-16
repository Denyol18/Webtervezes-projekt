<?php
    include_once "classes/User.php";
    include_once "common/methods.php";
    session_start();

    $users = loadData("data/users.txt");

    $successfulLogin = true;

    if (isset($_POST["login-btn"])) {
        $felhasznalonev = $_POST["username"];
        $jelszo = $_POST["password"];

        foreach ($users as $user) {
            if ($user->getUsername() === $felhasznalonev && password_verify($jelszo, $user->getPassword())) {
                $_SESSION["user"] = $user;
                header("Location: User.php");
            }
        }

        $successfulLogin = false;
    }
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Bejelentkezés</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/icon.png">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
        include_once "common/header.php";
        generateNavigation("login");
    ?>

    <main>
        <h1 class="center">Bejelentkezés</h1>

        <?php
                if (!$successfulLogin) {
                echo "<div class='errors'><p>A belépési adatok nem megfelelők!</p></div>";
            }
        ?>

        <div class="form-container">
            <img src="images/profile-pictures/default.png" alt="Avatar" class="avatar-icon">
            <form action="login.php" method="POST" autocomplete="off">
                <label for="uname" class="required-label">Felhasználónév: </label>
                <input type="text" name="username" id="uname" required>

                <label for="pswd" class="required-label">Jelszó: </label>
                <input type="password" name="password" id="pswd" required>

                <input type="submit" name="login-btn" value="Bejelentkezés">
            </form>
        </div>
    </main>

    <?php
        include_once "common/footer.php";
    ?>
</body>
</html>
