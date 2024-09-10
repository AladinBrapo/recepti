<?php 
require_once 'baza.php';
include_once 'seja.php';

if (isset($_POST['sub'])) {
    // Filtriranje vhodnih podatkov
    $m = filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL);
    $p = filter_var($_POST['geslo'], FILTER_SANITIZE_STRING);

    // Preverjanje veljavnosti emaila
    if (filter_var($m, FILTER_VALIDATE_EMAIL) === false) {
        echo "Napačen email naslov.";
        header("Refresh: 1; URL=prijava.php");
        exit();
    }

    // Pobeg nevarnih znakov za SQL poizvedbe
    $m = mysqli_real_escape_string($link, $m);

    $sql = "SELECT ime, priimek, geslo, vrsta_up_id, id FROM uporabniki WHERE email = '$m'";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Preverjanje gesla
        if (password_verify($p, $row['geslo'])) {
            $_SESSION['im'] = $row['ime'];
            $_SESSION['pr'] = $row['priimek'];
            $_SESSION['log'] = true;
            $_SESSION['vrsta_up'] = $row['vrsta_up_id'];
            $_SESSION['uporabnik_id'] = $row['id'];
            
            $up_id = $row['id'];
            $sql_kos = "SELECT id FROM kosarica WHERE up_id = $up_id ORDER BY id DESC LIMIT 1";
            $result_kos = mysqli_query($link, $sql_kos);
            
            if ($result_kos && mysqli_num_rows($result_kos) > 0) {
                $row_kos = mysqli_fetch_assoc($result_kos);
                $_SESSION['kos_id'] = $row_kos['id'];
            } else {
                // Ustvari novo kosarico, če ne obstaja
                $sql_create_kos = "INSERT INTO kosarica (up_id) VALUES ('$up_id')";
                if (mysqli_query($link, $sql_create_kos)) {
                    $_SESSION['kos_id'] = mysqli_insert_id($link);
                }
            }
            
            // Če je admin
            if ($row['vrsta_up_id'] == 1) {
                header("Location: admin/admin.php");
                exit();
            } else {
                header("Location: index.php");
                exit(); 
            }
        } else {
            echo "Napačno geslo.";
            header("Refresh: 1; URL=prijava.php");
            exit();
        }
    } else {
        echo "Uporabnik s tem emailom ne obstaja.";
        header("Refresh: 1; URL=prijava.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijava</title>
    <link rel="stylesheet" href="css_files/main.css">
    <link rel="stylesheet" href="css_files/prijava.css">
    <link rel="icon" href="slike/icon.png" type="image/png">
</head>
<body>
    <div class="container">
        <h2>Prijava</h2>
        <form method="post" action="prijava.php">
            <input type="email" name="mail" placeholder="Email" required autofocus>
            <input type="password" name="geslo" placeholder="Geslo" required>
            <input type="submit" name="sub" value="Prijava">
        </form>
        <div class="links">
            <a href="index.php">Domov</a>
            <a href="registracija.php">Registracija</a>
        </div>
    </div>
</body>
</html>
