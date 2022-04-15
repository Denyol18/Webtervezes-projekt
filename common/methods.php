<?php

function loadData(string $filename): array {
    $file = fopen($filename, "r");
    $arraydata = [];

    if (!$file) {
        die("Nem sikerült a fájl megnyitása!");
    }

    while (($row = fgets($file)) !== false) {
        $data = unserialize($row);
        $arraydata[] = $data;
    }

    fclose($file);
    return $arraydata;
}

function saveData(string $filename, array $arraydata) {
    $file = fopen($filename, "w");

    if (!$file) {
        die("Nem sikerült a fájl megnyitása!");
    }

    foreach ($arraydata as $data) {
        fwrite($file, serialize($data) . "\n");
    }

    fclose($file);
}

function generateNavigation(string $currentPage) {
    echo "<nav><ul>" .
        "<li" . ($currentPage === "index" ? " class='active'" : "") . ">" .
        "<a href='index.php'>Főoldal</a>" .
        "</li>" .
        "<li" . ($currentPage === "pizza" ? " class='active'" : "") . ">" .
        "<a href='pizza.php'>Pizzák</a>" .
        "</li>";

    if (isset($_SESSION["user"])) {
        echo "<li" . ($currentPage === "cart" ? " class='active'" : "") . ">" .
            "<a href='cart.php'>Kosaram</a>" .
            "</li>" .
            "<li" . ($currentPage === "profile" ? " class='active'" : "") . ">" .
            "<a href='profile.php'>Profilom</a>" .
            "</li>" .
            "</ul></nav>";
    } else {
        echo "<li" . ($currentPage === "login" ? " class='active'" : "") . ">" .
            "<a href='login.php'>Bejelentkezés</a>" .
            "</li>" .
            "<li" . ($currentPage === "signup" ? " class='active'" : "") . ">" .
            "<a href='signup.php'>Regisztráció</a>" .
            "</li>" .
            "</ul></nav>";
    }
}

function uploadProfilePicture(array &$errors, string $username) {

    if (isset($_FILES["profile-picture"]) && is_uploaded_file($_FILES["profile-picture"]["tmp_name"])) {
        if ($_FILES["profile-picture"]["error"] !== 0) {
            $errors[] = "Hiba történt a fájlfeltöltés során!";
        }

        $allowedExtensions = ["png", "jpg"];

        $extension = strtolower(pathinfo($_FILES["profile-picture"]["name"], PATHINFO_EXTENSION));

        if (!in_array($extension, $allowedExtensions)) {
            $errors[] = "A profilkép kiterjesztése hibás! Engedélyezett formátumok: " .
                implode(", ", $allowedExtensions) . "!";
        }

        if ($_FILES["profile-picture"]["size"] > 5242880) {
            $errors[] = "A fájl mérete túl nagy!";
        }

        if (count($errors) === 0) {
            $utvonal = "assets/img/profile-pictures/$username.$extension";
            $flag = move_uploaded_file($_FILES["profile-picture"]["tmp_name"], $path);

            if (!$flag) {
                $errors[] = "A profilkép elmentése nem sikerült!";
            }
        }
    }
}
