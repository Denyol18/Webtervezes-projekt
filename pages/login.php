<?php
    include_once "../classes/User.php";
    include_once "../common/methods.php";
    session_start();

    $users = loadData("../data/users.txt");

    $successfulLogin = true;

    if (isset($_POST["login-btn"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        foreach ($users as $user) {
            if ($user->getUsername() === $username && password_verify($password, $user->getPassword())) {
                $_SESSION["user"] = $user;
                header("Location: profile.php");
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
    <link rel="icon" href="../images/controller.jpg">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php
        include_once "../common/header.php";
        generateNavigation("login");
    ?>

    <main class="fadeIn">

        <section class="form-container">
            <?php
            if (!$successfulLogin) {
                echo "<div class='errors broder'><p>A belépési adatok nem megfelelők!</p></div>";
            }
            ?>
            <h1 class="kozepre">Bejelentkezés</h1>
            <img src="../images/profile-pictures/default.png" alt="Avatar" class="broder">
            <form action="login.php" method="POST" autocomplete="off">
                <fieldset>
                <label for="uname">Felhasználónév: </label>
                <input type="text" name="username" id="uname" required>

                <label for="pswd">Jelszó: </label>
                <input type="password" name="password" id="pswd" required>

                <input type="submit" name="login-btn" value="Bejelentkezés">
                </fieldset>
            </form>
        </section>
    </main>

    <?php
        include_once "../common/footer.php";
    ?>
</body>
</html>
