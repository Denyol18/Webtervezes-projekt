<?php
    include_once "../classes/User.php";
    include_once "../common/methods.php";

    $users = loadData("../data/users.txt");

    $errors = [];

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
                <a href="#urlap">Vélemény megosztó</a>
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

            <h2>Üdvözlő</h2>

            <p>
            Üdvözlünk minden kedves idelátogatót az oldalunkon! Ezen az oldalon megosztunk veletek egy pár, általunk nagyon
            kedvelt és imádott videojátékokról infótkat és azt is, miért is szeretjük őket igazán.<br>
            Számunkra a videojátékozás egy fontos szabadidős tevékenység, mert ez az egyik legjobb médium arra, hogy
            <strong>történeteket meséljen, világokat építsen és embereket kössön össze.</strong>
            </p>

            <p>
            A következő négy oldalon kiválasztottunk 2-2 játékot amikről olvashattok és nagyon örülnénk, ha ti is kipróbálnátok őket,
            ha kedvet adtunk nektek a felfedezésükre. Az egyes játékokról szóló oldalakat a képekre kattintva érhetitek el.
            </p>

            <p>
            Ha esetleg már játszottatok a játékok valamelyikével vagy azután próbáltátok ki, miután kedvet adtunk nektek, akkor
            lehetőségetek van a lap alján lévő űrlapon keresztül leírni mi a véleményetek az adott játékról. Meglátásaitokat kíváncsian
            várjuk! :)
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

        <section id="urlap">

            <h2>Vélemény megosztó</h2>

            <form action="kezdo.php" method="POST" autocomplete="off">

                <fieldset>

                    <legend>Regisztrációs adatok</legend>
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

                </fieldset>

                <fieldset>

                    <legend>Játékok</legend>
                    <br/>
                    Mely játékot/játékokat próbáltad ki? <br/><br/>

                    <label for="game1">Wolfenstein: The New Order</label>
                    <input type="checkbox" id="game1" name="Wolfenstein: The New Order" checked/> <br/>

                    <label for="game2">Halo: Combat Evolved</label>
                    <input type="checkbox" id="game2" name="Halo: Combat Evolved"/> <br/>

                    <label for="game3">Shadow of the Tomb Raider</label>
                    <input type="checkbox" id="game3" name="Shadow of the Tomb Raider"/> <br/>

                    <label for="game4">Hunt: Showdown</label>
                    <input type="checkbox" id="game4" name="Hunt: Showdown"/> <br/><br/>

                    Mik tetszettek benne/bennük?
                    <label for="pos"></label> <br/><br/>
                    <textarea id="pos" name="positives" rows="20" cols="60" maxlength="1000"></textarea>
                    <br/><br/>

                    Mik NEM tetszettek benne/bennük?
                    <label for="neg"></label> <br/><br/>
                    <textarea id="neg" name="negatives" rows="20" cols="60" maxlength="1000"></textarea>
                    <br/><br/>

                    <input type="reset" name="reset" value="Visszaállítás">
                    <input type="submit" name="signup" value="Küldés">

                </fieldset>
            </form>

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

