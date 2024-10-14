<?php
require_once 'baza.php';
include_once 'seja.php';

$message = '';

if (isset($_SESSION['log']) && isset($_SESSION['uporabnik_id'])) {
    if (isset($_GET['izbrisi'])) {
        $deleteID = $_GET['izbrisi'];
        $deleteQuery = "DELETE FROM slike WHERE recept_id = $deleteID";
        $deleteQuery2 = "DELETE FROM ocene WHERE recept_id = $deleteID";
        $deleteQuery3 = "DELETE FROM recepti WHERE id = $deleteID";
        
        // Brisanje slike iz mape
        $getImageQuery = "SELECT ime FROM slike WHERE recept_id = $deleteID";
        $imageResult = mysqli_query($link, $getImageQuery);
        $imageRow = mysqli_fetch_assoc($imageResult);
        $imageToDelete = $imageRow['ime'];
        if ($imageToDelete) {
            $imagePath = "slike/izdelki/$imageToDelete"; // Pot do slike
            if (file_exists($imagePath)) {
                unlink($imagePath); // Izbri分i sliko
            }
        }
        
        mysqli_query($link, $deleteQuery);
        mysqli_query($link, $deleteQuery2);
        mysqli_query($link, $deleteQuery3);
        
        $message = 'Recipe deleted successfully.';
        echo "<script>
            setTimeout(function() {
                window.location.href = 'your_recipes.php';
            }, 2000);
        </script>";
    }

    $id = $_SESSION['uporabnik_id'];

    $sql = "SELECT r.id, r.ime, s.url AS slika_url, s.ime AS slika_alt
                        FROM recepti r 
                        INNER JOIN slike s ON r.id = s.recept_id 
                        WHERE r.uporabnik_id = $id";

    $result = mysqli_query($link, $sql);
    $result_mobile = mysqli_query($link, $sql);
    
    if (mysqli_num_rows($result) == 0) {
        $message = "You have not submitted any recipes yet.";
    }

} else {
    // Display an error message if user is not logged in or uporabnik_id is missing
    $message = '<div class="error-msg">You must be logged in to view your recipes.</div>';
    echo "<script>
            setTimeout(function() {
                window.location.href = 'login.php';
            }, 2000);
        </script>";
}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Yummies - Discover Tasty Creations</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="icon" href="../slike/yummies-logo.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/main.css">
</head>
<body class="bg-[#99431f] font-['Poppins']">
  <div class="desktop-view"> 
    <div class="w-full sm:w-[1920px]">
        <?php include 'header.php'; //header ?>
        <?php include 'footer.php'; //footer ?>
        <div class="Frame31 left-[252px] top-[207px] absolute justify-start items-start gap-[850px] inline-flex">
            <div class="TitleNormal w-[210px] h-12 relative">
                <div class="HeaderNormal left-0 top-0 absolute text-white text-[32px] font-medium font-['Poppins'] capitalize">Your Recipes</div>
            </div>
            <div class="TitleNormal w-[380px] h-12 relative">
                <div class="HeaderNormal left-0 top-0 absolute text-white text-[32px] font-medium font-['Poppins'] capitalize"><?php  echo $_SESSION['im'].' '.$_SESSION['pr']; ?></div>
            </div>
        </div>
        <div class="Ingredients w-[1465px] p-[35px] left-[227px] top-[320px] absolute rounded-[15px] border border-[#ffd633] justify-center items-start gap-[35px] inline-flex">
            <?php if ($message): ?>
                <div class="Frame427320871 w-[800px] h-[200px] relative">
                    <div class="TitleNormal w-[700px] h-[180px] left-[31px] top-[34px] absolute">
                        <div class="HeaderNormal left-0 top-0 absolute text-[#ffd633] text-[32px] font-medium font-['Poppins'] capitalize">
                                <div class="message">
                                    <?php echo $message; ?>
                                </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php
                while ($row = mysqli_fetch_array($result)) {
                    echo '
                    <div class="Group w-[315px] h-[345px] relative">
                        <div>
                            <img src="'. htmlspecialchars($row['slika_url']) .'" alt=" '. htmlspecialchars($row['slika_alt']) .'" class="Images w-[315px] h-[215px] object-cover rounded-lg">
                        </div>
                        <div class="Title w-[286px] h-[60px] left-[15px] top-[229px] absolute text-[#fefefe] text-xl font-bold font-['.'Poppins'.']">
                            '. htmlspecialchars($row['ime']) .'
                        </div>
                        <form method="get" action="update_your_recipe.php"><input type="hidden" name="posodobi" value="' . htmlspecialchars($row['id']) . '">
                            <button class="ButtonVariant2 w-[113px] h-[42px] px-5 py-2.5 left-0 top-[303px] absolute bg-[#ffd633] rounded-[100px] flex items-center justify-center">
                                <div class="Edit text-[#010012] text-xl font-normal font-['.'Poppins'.'] capitalize">Edit</div>
                            </button>
                        </form>
                        
                        <form method="get" action="#"><input type="hidden" name="izbrisi" value="' . htmlspecialchars($row['id']) . '">
                            <button class="ButtonVariant2 w-[113px] h-[42px] px-5 py-2.5 left-[202px] top-[303px] absolute bg-[#ffd633] rounded-[100px] flex items-center justify-center">
                                <div class="Delete text-[#010012] text-xl font-normal font-['.'Poppins'.'] capitalize">Delete</div>
                            </button>
                        </form>
                    </div>';
                }
            ?>
        </div>
    </div>
  </div>
  <div class="mobile-view">
    <div class="YummiesRecipesPhoneViewRecipes w-[360px] h-[800px] relative bg-[#99431f]">
        <?php include 'phone-header.php'; //header ?>

        <?php if ($message): ?>
            <div class="Frame427320871 w-[800px] h-[200px] relative">
                <div class="TitleNormal w-[700px] h-[180px] left-[31px] top-[34px] absolute">
                    <div class="HeaderNormal left-0 top-0 absolute text-[#ffd633] text-[32px] font-medium font-['Poppins'] capitalize">
                            <div class="message">
                                <?php echo $message; ?>
                            </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php
            while ($row = mysqli_fetch_array($result_mobile)) {
                echo '
                <div class="Group28 w-[270px] h-[338px] left-[45px] top-[242px] absolute">
                    <div>
                        <img src="'. htmlspecialchars($row['slika_url']) .'" alt=" '. htmlspecialchars($row['slika_alt']) .'" class="Images object-cover w-[270px] h-[215px] left-0 top-0 absolute bg-[#c4c4c4] rounded-[10px]">
                    </div>
                    <div class="Title w-[232px] h-[67px] left-[19px] top-[229px] absolute text-[#fefefe] text-xl font-bold font-['.'Poppins'.']">
                        '. htmlspecialchars($row['ime']) .'
                    </div>
                    <form method="get" action="update_your_recipe.php"><input type="hidden" name="posodobi" value="' . htmlspecialchars($row['id']) . '">
                        <button class="PhoneButtonVariant2 w-[90px] h-[42px] px-[9.51px] py-[4.76px] left-[19px] top-[296px] absolute bg-[#ffd633] rounded-[10.50px] flex items-center justify-center">
                            <div class="Edit text-[#010012] text-sm font-normal font-['.'Poppins'.'] capitalize">Edit</div>
                        </button>
                    </form>
                    
                    <form method="get" action="#"><input type="hidden" name="izbrisi" value="' . htmlspecialchars($row['id']) . '">
                        <button class="PhoneButtonVariant2 w-[90px] h-[42px] px-[9.51px] py-[4.76px] left-[163px] top-[296px] absolute bg-[#ffd633] rounded-[10.50px] flex items-center justify-center">
                            <div class="Delete text-[#010012] text-sm font-normal font-['.'Poppins'.'] capitalize">Delete</div>
                        </button>
                    </form>
                </div>';
            }
        ?>
        <div class="TitleNormal w-[152px] h-[34px] left-[104px] top-[88px] absolute">
            <div class="HeaderNormal left-0 top-0 absolute text-white text-[22.98px] font-medium font-['Poppins'] capitalize">Your Recipes</div>
        </div>
        <div class="TitleNormal w-[308px] h-[74px] left-[26px] top-[145px] absolute flex items-center justify-center">
            <div class="YourName top-[3px] absolute text-center text-white text-[22.98px] font-medium font-['Poppins'] capitalize flex items-center justify-center"><?php  echo $_SESSION['im'].' '.$_SESSION['pr']; ?></div>
        </div>
    </div>
  </div>
  <script src="js/phone-menu.js"></script>
</body>
</html>