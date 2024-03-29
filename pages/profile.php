<?php
    include_once "../classes/User.php";
    include_once "../common/methods.php";
    session_start();

    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
    }

    const DEFAULT_PROFILEPICTURE = "../images/profile-pictures/default.png";
    $profilePicture = DEFAULT_PROFILEPICTURE;

    $path = "../images/profile-pictures/" . $_SESSION["user"]->getUsername();
    $allowedExtension = ["png", "jpg"];

    foreach ($allowedExtension as $who) {
        if (file_exists("$path.$who")) {
            $profilePicture = "$path.$who";
        }
    }

    $errors = [];


    if (isset($_POST["upload-btn"]) && is_uploaded_file($_FILES["profile-picture"]["tmp_name"])) {
        uploadProfilePicture($errors, $_SESSION["user"]->getUsername());

        if (count($errors) === 0) {
            $who = strtolower(pathinfo($_FILES["profile-picture"]["name"], PATHINFO_EXTENSION));
            $path = "../images/profile-pictures/" . $_SESSION["user"]->getUsername . "." . $who;

            if ($path !== $profilePicture && $profilePicture !== DEFAULT_PROFILEPICTURE) {
                unlink($profilePicture);
            }
            header("Location: ../pages/profile.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Profilom</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/controller.jpg">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php
        include_once "../common/header.php";
        generateNavigation("profile");

        $user = $_SESSION["user"];
    ?>

    <main class="fadeIn">
        <section>
        <h1 class="kozepre">Profilom</h1>

        <?php
            if (count($errors) > 0) {
                echo "<div class='errors broder'>";

                foreach ($errors as $error) {
                    echo "<p>" . $error . "</p>";
                }

                echo "</div>";
            }
        ?>

        <table id="profile-table">
            <tr>
                <th colspan="2">Felhasználói adatok</th>
            </tr>
            <tr>
                <td colspan="2">
                    <img src="<?php echo $profilePicture; ?>" alt="Profilkép" class="broder" height="200">
                    <form action="profile.php" method="POST" enctype="multipart/form-data">
                        <fieldset>
                        <input type="file" name="profile-picture">
                        <input type="submit" name="upload-btn" value="Profilkép módosítása">
                    </fieldset>
                    </form>
                </td>
            </tr>
            <tr>
                <th>Felhasználónév</th>
                <td><?php echo $user->getUsername(); ?></td>
            </tr>
            <tr>
                <th>E-mail cím</th>
                <td><?php echo $user->getEmail(); ?></td>
            </tr>
            <tr>
                <th>Születési év</th>
                <td><?php echo $user->getAge(); ?></td>
            </tr>
            <tr>
                <th>Nem</th>
                <td><?php echo $user->getSex(); ?></td>
            </tr>
        </table>

        <form action="logout.php" method="POST">
            <fieldset>
            <input type="submit" name="logout-btn" value="Kijelentkezés">
            </fieldset>
        </form>
        </section>
    </main>

    <?php
        include_once "../common/footer.php";
    ?>
</body>
</html>
