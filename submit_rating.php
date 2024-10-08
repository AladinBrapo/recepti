<?php
require_once 'baza.php';
require_once 'seja.php';

if (!isset($_SESSION['log'])) {
    echo "You must be logged in to rate.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recept_id = mysqli_real_escape_string($link, $_POST['recept_id']);
    $rating = mysqli_real_escape_string($link, $_POST['rating']);
    $user_id = $_SESSION['uporabnik_id'];

    // Check if user has already rated this recipe
    $sql_check = "SELECT * FROM ocene WHERE uporabnik_id = $user_id AND recept_id = $recept_id";
    $result_check = mysqli_query($link, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        // Update the existing rating
        $sql_update = "UPDATE ocene SET ocena = $rating WHERE uporabnik_id = $user_id AND recept_id = $recept_id";
        mysqli_query($link, $sql_update);
    } else {
        // Insert a new rating
        $sql_insert = "INSERT INTO ocene (uporabnik_id, recept_id, ocena) VALUES ($user_id, $recept_id, $rating)";
        mysqli_query($link, $sql_insert);
    }
    
    echo "Rating submitted successfully.";
}
?>