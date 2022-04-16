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
    echo "<nav id='lent'><ul>" .
        "<li" . ($currentPage === "kezdo" ? " id='active'" : "") . ">" .
        "<a href='kezdo.php'>Kezdőlap</a>" .
        "</li>" .
        "<li" . ($currentPage === "danigame1" ? " id='active'" : "") . ">" .
        "<a href='danigame1.php'>Dani Kedvencei part 1</a>" .
        "</li>" .
        "<li" . ($currentPage === "danigame2" ? " id='active'" : "") . ">" .
        "<a href='danigame2.php'>Dani Kedvencei part 2</a>" .
        "</li>" .
        "<li" . ($currentPage === "ferigame1" ? " id='active'" : "") . ">" .
        "<a href='ferigame1.php'>Feri Kedvencei part 1</a>" .
        "</li>" .
        "<li" . ($currentPage === "ferigame2" ? " id='active'" : "") . ">" .
        "<a href='ferigame2.php'>Feri Kedvencei part 2</a>" .
        "</li>";

    if (isset($_SESSION["user"])) {
        echo "<li" . ($currentPage === "profile" ? " id='active'" : "") . ">" .
            "<a href='profile.php'>Profilom</a>" .
            "</li>" .
            "</ul></nav>";
    } else {
        echo "<li" . ($currentPage === "login" ? " id='active'" : "") . ">" .
            "<a href='login.php'>Bejelentkezés</a>" .
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
            $path = "../images/profile-pictures/$username.$extension";
            $flag = move_uploaded_file($_FILES["profile-picture"]["tmp_name"], $path);

            if (!$flag) {
                $errors[] = "A profilkép elmentése nem sikerült!";
            }
        }
    }
}
