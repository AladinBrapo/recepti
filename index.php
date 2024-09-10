<?php include_once 'seja.php'; ?>

<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Techy trgovina</title>
    
    <link rel="stylesheet" href="css_files/header.css">
    <link rel="stylesheet" href="css_files/main.css">
    <link rel="icon" href="slike/icon.png" type="image/png">
    
    <style>
        #gif-image {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; //header ?>

    <div id="container">
        <img id="gif-image" src="slike/TECHY.gif" alt="naslovni GIF">
        <img id="gif-image-mobile" src="slike/TECHY-telefon.gif" alt="naslovni GIF za telefone" style="display: none;">
        <!-- Produkti z sql pobrani-->
    </div>
    
    <?php include 'footer.php'; //footer ?>

    <script>
        var screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

        var gifImage = document.getElementById('gif-image');
        var gifImageMobile = document.getElementById('gif-image-mobile');

        // Preveri ali gre za telefon in prikaži ustrezno sliko
        if (screenWidth <= 600) {
            gifImage.style.display = 'none';
            gifImageMobile.style.display = 'block';
        } else {
            gifImage.style.display = 'block';
            gifImageMobile.style.display = 'none';
        }
    </script>
</body>
</html>
