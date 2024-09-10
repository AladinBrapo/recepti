<?php 
include_once 'seja.php'; 
include_once 'baza.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Log errors to a specific file
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');

if (!isset($_SESSION['kos_id'])) {
    $_SESSION['kos_id'] = 0; //Če ni noben prijavljen
}

$kos_id= $_SESSION['kos_id'];

// Preveri število izdelkov v košarici
function pridobiSteviloIzdelkovVKosarici($link, $uporabnik_id, $kos_id) {
    $sql = "SELECT SUM(kolicina) as stevilo FROM izdelek_kosarica ik
            INNER JOIN kosarica k ON ik.kosarica_id = k.id
            WHERE k.up_id = $uporabnik_id AND k.id = $kos_id";
    $result = mysqli_query($link, $sql);

    // Preveri, ali je prišlo do napake pri izvajanju poizvedbe
    if (!$result) {
        // Pridobi in vrni opis napake
        return mysqli_error($link);
    }

    $row = mysqli_fetch_assoc($result);

    // Preveri, ali ni bilo najdenih rezultatov v poizvedbi
    if ($row === null || $row['stevilo'] === null) {
        // Obravnava primera, ko ni bilo najdenih rezultatov ali je rezultat NULL
        return 0;
    }

    return $row['stevilo'];
}

$steviloIzdelkovVKosarici = 0;
if (isset($_SESSION['log'])) {
    $uporabnik_id = $_SESSION['uporabnik_id'];
    $steviloIzdelkovVKosarici = pridobiSteviloIzdelkovVKosarici($link, $uporabnik_id, $kos_id);
}
?>

<div id="header">
    <div id="header_top">
        <!-- logo, search bar, prijava -->
        <a href="index.php"><img src="slike/logo.png" alt="logo" style="height: 45px; width: auto; margin-bottom: -15px; padding-right: 30px;"></a>
        
        <div id="header_search">
            <form method="post" action="kategorija.php" id="searchForm">
                <input type="text" id="search" name="search" placeholder="Search..." style="background-color: #333; color:white;">
                <button type="submit" id="hiddenSubmit" style="display: none;"></button>
                <img id="search_glass" src="slike/search_glass.png" alt="magnifying glass">
            </form>
        </div>


        
        <div id="prijava">
            <?php
                if (isset($_SESSION['log'])) {
                    $i = $_SESSION['im'];
                    $p = $_SESSION['pr'];
                    echo '<a href="odjava.php">Odjava</a>'; 
                } else {
                    echo '<a href="prijava.php">PRIJAVA</a>';
                }
            ?>
        </div>
    </div>
    <div id="header_bottom">
        <!--user, nav, košarica-->
        <div id="prijavljeni">
            <?php
                if (isset($_SESSION['log'])) {
                    echo 'Prijavljeni: ' . htmlspecialchars($i) . ' ' . htmlspecialchars($p); // Proti XSS napadom
                }
            ?>
        </div>
        <ul>
            <li><a href="index.php">Doma</a></li>
            <li class="dropdown">
                <a href="#" class="dropbtn">Produkti</a>
                <div class="dropdown-content">
                    <a href="kategorija.php?kategorija=Monitorji">Monitorji</a>
                    <a href="kategorija.php?kategorija=Tipkovnice">Tipkovnice</a>
                    <a href="kategorija.php?kategorija=Miške">Miške</a>
                    <a href="kategorija.php?kategorija=Slušalke">Slušalke</a>
                    <a href="kategorija.php?kategorija=Zvočniki">Zvočniki</a>
                    <a href="kategorija.php?kategorija=Kamere">Kamere</a>
                </div>
            </li>
            <li>O nas</li>
            <li>Kontakt</li>
        </ul>
        <div id="kosarica_container">
            <a href="kosarica.php"><img id="kosarica" src="slike/cart.png" alt="kosarica"></a>
            <span id="st_kosarica"><?php echo $steviloIzdelkovVKosarici; ?></span>
        </div>   
    </div>
</div>

<script>
    document.getElementById('search').addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Da ne pošlje prazno
            document.getElementById('searchForm').submit();
        }
    });
</script>
