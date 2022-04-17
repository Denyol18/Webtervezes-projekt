<?php
    include_once "../classes/User.php";
    include_once "../common/methods.php";
    include_once "../classes/Comment.php";
    session_start();

    $users = loadData("../data/users.txt");
    $comments = loadComments("../data/comments.txt");
    $comments = array_reverse($comments);

    $errors = [];

    if (isset($_POST["send"])) {
        $errors1 = [];

    if (!isset($_POST["opinion"]) || trim($_POST["opinion"]) === "") {
        $errors1[] = "HIBA: Add meg a véleményed szövegét!";
    }

    if (strlen($_POST["opinion"]) > 500) {
        $errors1[] = "HIBA: A véleményed nem lehet hosszabb 500 karakternél!";
    }

    $username1 = $_SESSION["user1"]["username1"];
    $date = new DateTime();
    $date->setTimezone(new DateTimeZone("Europe/Budapest"));
    $text = trim($_POST["opinion"]);

    if (count($errors1) === 0) {
        $new_comment = new Comment($username1, $date, $text);
        $comments[] = $new_comment;
        saveComments("../data/comments.txt", $comments);

        header("Location: kezdo.php");
    }
}

    if(isset($_POST["signup"])) {
        $username = $_POST["username"];
        $age = $_POST["age"];
        $sex = "egyéb";
        $password = $_POST["psswd"];
        $checker = $_POST["psswd1"];
        $email = $_POST["email"];

        if (isset($_POST["sex"])) {
            $sex = $_POST["sex"];
        }

        if (trim($username) === "" || trim($age) === "" || trim($password) === "" || trim($checker) === ""
            || trim($email) === "") {
            $errors[] = "Minden kötelezően kitöltendő mezőt ki kell tölteni!";
        }

        foreach ($users as $user) {
            if ($user->getUsername() === $username) {
                $errors[] = "A felhasználónév már foglalt!";
            }
        }

        if (strlen($password) < 4) {
            $errors[] = "A jelszónak legalább 4 karakter hosszúnak kell lennie!";
        }

        if (!preg_match("/[A-Za-z]/", $password) || !preg_match("/[0-9]/", $password)) {
            $errors[] = "A jelszónak tartalmaznia kell betűt és számjegyet is!";
        }

        if (!preg_match("/[0-9a-z.-]+@([0-9a-z-]+\.)+[a-z]{2,4}/", $email)) {
            $errors[] = "A megadott e-mail cím formátuma nem megfelelő!";
        }

        if ($password !== $checker) {
            $errors[] = "A két megadott jelszó nem egyezik!";
        }

        foreach ($users as $user) {
            if ($user->getEmail() === $email) {
                $errors[] = "Az e-mail cím már foglalt!";
            }
        }

        if (count($errors) === 0) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $user = new User($username, $age, $sex, $password, $email);
            $users[] = $user;
            saveData("../data/users.txt", $users);
        }

    }
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kedvenc játékaink | Kezdőlap</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../images/controller.jpg">
</head>
<body>
    <?php
    include_once "../common/header.php";
    ?>

    <nav id="fent">

        <ul>
            <li>
                <a href="#udvozlo">Üdvözlő</a>
            </li>
            <li>
                <a href="#games">The games</a>
            </li>
            <li>
                <a href="#opinions">Vélemények</a>
            </li>
            <li>
                <a href="#signup">Regisztráció és vélemény írás</a>
            </li>
        </ul>
    </nav>

    <main class="fadeIn">

        <section id="udvozlo">

            <?php
            if (count($errors) > 0) {
                echo "<div class='errors broder'>";

                foreach ($errors as $error) {
                    echo "<p>" . $error . "</p>";
                }
                echo "</div>";
            }
            ?>

            <?php
            if (isset($errors1) && count($errors1) > 0) {
                echo "<div class='errors broder'>";

                    foreach ($errors1 as $error2) {
                        echo "<p>" . $error2 . "</p>";
                    }
                echo "</div>";
            }
            ?>


            <h2>Üdvözlő</h2>

            <p>
            Üdvözlünk minden kedves idelátogatót az oldalunkon! Ezen az oldalon megosztunk veletek egy pár, általunk nagyon
            kedvelt és imádott videojátékokról infótkat és azt is, miért is szeretjük őket igazán.<br>
            Számunkra a videojátékozás egy fontos szabadidős tevékenység, mert ez az egyik legjobb médium arra, hogy
            <strong>történeteket meséljen, világokat építsen és embereket kössön össze.</strong>
            </p>

            <p>
            A következő négy oldalon kiválasztottunk 2-2 játékot amikről olvashattok és nagyon örülnénk, ha ti is kipróbálnátok őket,
            ha kedvet adtunk nektek a felfedezésükre. Az egyes játékokról szóló oldalakat a képekre kattintva érhetitek el, vagy az alsó
                navigációs menü használatával.
            </p>

            <p>
            Ha esetleg már játszottatok a játékok valamelyikével vagy azután próbáltátok ki, miután kedvet adtunk nektek, akkor
            lehetőségetek van a lap alján lévő űrlapon keresztül leírni mi a véleményetek az adott játékról. Meglátásaitokat kíváncsian
                várjuk! :)
            </p>

            <p>
                <strong>REGISZTRÁLNI CSAK EZEN AZ OLDALON LEHET! Véleményt írni csak bejelentkezve lehet.
                Ha nem látod a vélemény íráshoz szükséges textfieldet, akkot nem vagy bejelentkezve!</strong>
            </p>

        </section>

        <section id="games">

            <h2>The games</h2>

            <a href="danigame1.php">
                <img class="kezdo" src="../images/wolfkezdo.jpg" alt="Where wolf" title="Wolfenstein: The New Order | Dani kedvencei part 1">
            </a>

            <a href="danigame2.php">
                <img class="kezdo" src="../images/halokezdo.jpg" alt="Where halo" title="Halo: Combat Evolved | Dani kedvencei part 2">
            </a>

            <a href="ferigame1.php">
                <img class="kezdo" src="../images/larakezdo.jpg" alt="Where lara" title="Shadow of the Tomb Raider | Feri kedvencei part 1">
            </a>

            <a href="ferigame2.php">
                <img class="kezdo" src="../images/huntkezdo.jpg" alt="Where hunt" title="Hunt: Showdown | Feri kedvencei part 2">
            </a>

        </section>

        <section id="opinions">

            <h2>Vélemények</h2>

            <?php  if (count($comments) === 0) { ?>
                <p>Még nem érkezett vélemény.</p>
            <?php }
            else { ?>

                <?php foreach ($comments as $comment) { ?>
                    <div class="comment broder">
                        <img src="<?php echo getProfilePicture('../images/profile-pictures', $comment->getAuthor(), ['png', 'jpg']); ?>" alt="Profilkép" class="profile"/>
                        <div><?php echo $comment->getAuthor(); ?></div>
                        <div><?php echo $comment->getDate()->format('Y-m-d H:i:s'); ?></div>
                        <div><?php echo $comment->getText(); ?></div>
                    </div>
                <?php } ?>
            <?php } ?>



        </section>

        <section id="signup">

            <h2>Regisztráció és vélemény írás</h2>

            <form action="kezdo.php" method="POST" autocomplete="off">

                <fieldset>

                    <legend>Regisztráció</legend>
                    <br/>

                    <label>Felhasználónév:<input type="text" name="username" required></label>
                    <br/><br/>

                    <label>Kor:<input type="number" name="age" required></label>
                    <br/><br/>

                    Nem: <label for="option1">Férfi:</label>
                    <input type="radio" id="option1" name="sex" value="férfi"/>

                    <label for="option2">Nő:</label>
                    <input type="radio" id="option2" name="sex" value="nő"/>

                    <label for="option3">Egyéb:</label>
                    <input type="radio" id="option3" name="sex" value="egyéb" checked/>
                    <br/><br/>

                    <label>Jelszó:<input type="password" name="psswd" required></label>
                    <br/><br/>

                    <label>Jelszó ismét:<input type="password" name="psswd1" required></label>
                    <br/><br/>

                    <label>E-mail:<input type="email" name="email" placeholder="valaki@valami.com" required></label>
                    <br/><br/>

                    <input type="reset" name="reset" value="Visszaállítás">
                    <input type="submit" name="signup" value="Küldés">

                </fieldset>
            </form>


            <?php if (isset($_SESSION["user"])) { ?>
            <form action="kezdo.php" method="POST">
                <fieldset>
                    <legend>Vélemény írás</legend>
                    <br/>

                    Mely játékokat próbáltad ki? Mik tetszettek bennük és mik nem? Itt ezt mind leírhatod :) (max. 500 karakter)
                    <label for="opin"></label> <br/><br/>
                    <textarea id="opin" name="opinion" rows="20" cols="60" maxlength="500"></textarea>
                    <br/><br/>

                    <input type="reset" name="reset" value="Visszaállítás">
                    <input type="submit" name="send" value="Küldés">

                </fieldset>
            </form>
            <?php } ?>

        </section>

    </main>

    <?php
    include_once "../common/methods.php";
    generateNavigation("kezdo");
    ?>

    <?php
    include_once "../common/footer.php";
    ?>

</body>
</html>

