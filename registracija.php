<?php
require_once 'baza.php';

$sqls = "SELECT * FROM kraji";
$results = mysqli_query($link, $sqls);

$message = "";

if (isset($_POST['sub'])) {
    // Filtriranje vhodnih podatkov
    $m = filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL);
    $t = htmlspecialchars($_POST['tel'], ENT_QUOTES, 'UTF-8');
    $n = htmlspecialchars($_POST['naslov'], ENT_QUOTES, 'UTF-8');
    $g = htmlspecialchars($_POST['geslo'], ENT_QUOTES, 'UTF-8');
    $i = htmlspecialchars($_POST['ime'], ENT_QUOTES, 'UTF-8');
    $p = htmlspecialchars($_POST['pri'], ENT_QUOTES, 'UTF-8');
    $k = filter_var($_POST['kraj'], FILTER_SANITIZE_NUMBER_INT);
    
    // Preverjanje veljavnosti emaila
    if (!filter_var($m, FILTER_VALIDATE_EMAIL)) {
        $message = '<div class="error-msg">Napačen email naslov.</div>';
        header("Refresh: 1; URL=registracija.php");
        exit();
    }

    $g2 = password_hash($g, PASSWORD_DEFAULT);

    // Preverjanje, če uporabnik že obstaja
    $sql = "SELECT * FROM uporabniki WHERE email = ?";
    $stmt = mysqli_prepare($link, $sql);
    if (!$stmt) {
        $message = '<div class="error-msg">Napaka pri pripravi SQL stavka: ' . mysqli_error($link) . '</div>';
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $m);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if (mysqli_num_rows($result) === 1) {
            $message = '<div class="error-msg">Imamo že uporabnika pod tem e-mailom. Uporabite drugega.</div>';
            header("Refresh: 2; URL=registracija.php");
        } else {
            mysqli_stmt_close($stmt); // Close the statement before reusing the variable
            $stmt = mysqli_prepare($link, "INSERT INTO uporabniki (ime, priimek, email, telefon, geslo, naslov, kraj_id, vrsta_up_id) VALUES (?, ?, ?, ?, ?, ?, ?, 2)");
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssssssi", $i, $p, $m, $t, $g2, $n, $k);
                $executed = mysqli_stmt_execute($stmt);
                if ($executed) {
                    $id_up = mysqli_insert_id($link);

                    $sqlk = "INSERT INTO kosarica (up_id) VALUES ($id_up)";
                    $resultk = mysqli_query($link, $sqlk);

                    if ($resultk) {
                        $message = '<div class="success-msg">Registracija uspešna</div>';
                        header("Refresh: 2; URL=prijava.php");
                    } else {
                        $message = '<div class="error-msg">Ustvarjanje košarice neuspešno: ' . mysqli_error($link) . '</div>';
                    }
                } else {
                    $message = '<div class="error-msg">Vstavljanje neuspešno: ' . mysqli_stmt_error($stmt) . '</div>';
                }
                mysqli_stmt_close($stmt);
            } else {
                $message = '<div class="error-msg">Napaka pri pripravi SQL stavka: ' . mysqli_error($link) . '</div>';
            }
        }
    } else {
        $message = '<div class="error-msg">Napaka pri izvajanju poizvedbe: ' . mysqli_error($link) . '</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija</title>
    <link rel="stylesheet" href="css_files/main.css">
    <link rel="stylesheet" href="css_files/registracija.css">
    <link rel="icon" href="slike/icon.png" type="image/png">
</head>
<body>
    <div class="container">
        <?php if ($message): ?>
            <div class="message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <h2>Registracija</h2>
        <form method="post" action="registracija.php">
            <input type="text" name="ime" placeholder="Ime" required>
            <input type="text" name="pri" placeholder="Priimek" required>
            <input type="email" name="mail" placeholder="Email" required>
            <input type="tel" name="tel" placeholder="Telefon">
            <input type="text" name="naslov" placeholder="Naslov" required>
            <input type="password" name="geslo" placeholder="Geslo" required>
            <select name="kraj" required>
                <?php
                    while ($row = mysqli_fetch_array($results)) {
                        echo '<option value="'.$row['id'].'">'.$row['ime'].'</option>';
                    }
                ?>
            </select>
            <input type="submit" name="sub" value="Registriraj se">
        </form>
        <div class="links">
            <a href="index.php">Domov</a>
            <a href="prijava.php">Prijava</a>
        </div>
    </div>
</body>
</html>
