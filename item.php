<?php
    require_once 'baza.php';
    require_once 'seja.php';

    if (!isset($_GET['id'])) {
        header("Location: index.php");
        exit();
    }
    
    $recept_id = mysqli_real_escape_string($link, $_GET['id']);
    $sql = "SELECT r.id, r.ime, r.opis, r.sestavine, s.url AS slika_url, s.ime AS slika_alt, 
                    IFNULL(AVG(o.ocena), 0) AS average_rating
                    FROM recepti r 
                    INNER JOIN slike s ON r.id = s.recept_id 
                    LEFT JOIN ocene o ON r.id = o.recept_id 
                    WHERE r.id = $recept_id";

    $result = mysqli_query($link, $sql);
    
    if (mysqli_num_rows($result) == 0) {
        echo "Recipe doesn't exist.";
        exit();
    }
    
    $row = mysqli_fetch_array($result);
    $average_rating = round($row['average_rating'], 1);
    
    $userId = $_SESSION['uporabnik_id'];
    $userRatingSql = "SELECT ocena FROM ocene WHERE recept_id = $recept_id AND uporabnik_id = $userId";
    $userRatingResult = mysqli_query($link, $userRatingSql);
    $userRating = mysqli_num_rows($userRatingResult) ? mysqli_fetch_assoc($userRatingResult)['ocena'] : 0;
    
    echo "<script>var currentRating = " . $userRating . ";</script>";

    
    echo "<script>var isLoggedIn = " . (isset($_SESSION['log']) ? 'true' : 'false') . ";</script>";
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
        <div class="YummiesRecipesDesktopItem w-[1920px] h-[1796px] relative bg-[#99431f]">
            <?php include 'header.php'; //header ?>
            <?php include 'footer.php'; //footer ?>
            <div class="TitleNormal w-[1300px] h-12 left-[252px] top-[207px] absolute">
                <div class="HeaderNormal left-0 top-0 absolute text-white text-[32px] font-medium font-['Poppins'] capitalize">Recipe : <?php echo htmlspecialchars($row['ime']); ?></div>
            </div>
            <div class="Image w-[950px] h-[350px] left-[252px] top-[295px] absolute bg-[#c4c4c4] rounded-br-[15px] overflow-hidden">
                <img src="<?php echo htmlspecialchars($row['slika_url']); ?>" alt="<?php echo htmlspecialchars($row['slika_alt']); ?>" class="w-full h-full object-cover">
            </div>
            <div class="Ingredients w-[375px] h-auto h-min-[678px] p-[35px] left-[1282px] top-[295px] absolute rounded-[15px] border border-[#ffd633] flex-col justify-start items-start gap-[35px] inline-flex">
                <div class="Frame27 self-stretch h-auto h-min-[678px] flex-col justify-start items-start gap-[15px] flex">
                    <div class="Ingredients w-[137px] text-[#fefefe] text-2xl font-medium font-['Poppins'] capitalize">ingredients</div>
                    <div class="FirstSecondThirdForthFifthSixth self-stretch opacity-80 text-[#fefefe] text-xl font-normal font-['Poppins']"><?php echo nl2br(htmlspecialchars($row['sestavine'])); ?></div>
                </div>
            </div>
            <div class="Procedure w-[950px] h-auto h-min-[496px] p-[35px] left-[252px] top-[685px] absolute rounded-[15px] border border-[#ffd633] flex-col justify-start items-start gap-[35px] inline-flex">
                <div class="Frame27 self-stretch h-auto h-min-[496px] flex-col justify-start items-start gap-[15px] flex">
                    <div class="Procedure w-[137px] text-[#fefefe] text-2xl font-medium font-['Poppins'] capitalize">Procedure</div>
                    <div class="FirstYouDoThisSecondThenYouDoThisThirdThenYouDoThisForthThenYouDoThisFifthThenYouDoThisSixthAtTheEndYouDoThis self-stretch h-[375px] opacity-80 text-[#fefefe] text-xl font-normal font-['Poppins']"><?php echo nl2br(htmlspecialchars($row['opis'])); ?></div>
                </div>
            </div>
            <div class="StarRating w-[326px] h-[50px] left-[1310px] top-[1011px] absolute flex items-center">
                <!-- Star Icons for Rating -->
                <img src="slike/star.png" class="star px-2" alt="1 Star" data-rating="1">
                <img src="slike/star.png" class="star px-2" alt="2 Stars" data-rating="2">
                <img src="slike/star.png" class="star px-2" alt="3 Stars" data-rating="3">
                <img src="slike/star.png" class="star px-2" alt="4 Stars" data-rating="4">
                <img src="slike/star.png" class="star px-2" alt="5 Stars" data-rating="5">
            </div>
            <div class="TitleNormal w-[239px] h-12 left-[1282px] top-[1101px] absolute">
                <div class="HeaderNormal left-0 top-[7px] absolute text-white text-[24px] font-medium font-['Poppins'] capitalize">
                    Average : <?php echo $average_rating; ?> / 5
                </div>
            </div>

            <button class="w-[113px] h-[42px] px-5 py-2.5 left-[1544px] top-[1104px] absolute bg-[#ffd633] rounded-[100px] flex items-center justify-center" onclick="oceniRecept(<?php echo $row['id']; ?>)">
                <div class="Submit text-[#010012] text-xl font-normal font-['Poppins'] capitalize">Submit</div>
            </button>

        </div>
    </div>
  </div>
  <div class="mobile-view">
    <div class="YummiesRecipesPhoneItem w-[360px] h-[1040px] relative bg-[#99431f]">
        <?php include 'phone-header.php'; //header ?>

        <div class="Group28 w-[272px] pt-[100px] pb-[10px] mx-auto flex flex-col items-center gap-8">

          <!-- Image Section -->
          <div class="Images w-[270px] h-[215px] bg-[#c4c4c4] rounded-[10px] overflow-hidden">
            <img src="<?php echo htmlspecialchars($row['slika_url']); ?>" alt="<?php echo htmlspecialchars($row['slika_alt']); ?>" class="w-full h-full object-cover">
          </div>
        
          <!-- Title Section -->
          <div class="Title w-full text-center text-[#fefefe] text-xl font-bold font-['Poppins'] capitalize">
            <?php echo htmlspecialchars($row['ime']); ?>
          </div>
        
          <!-- Ingredients Section -->
          <div class="Frame27 w-full p-[23.75px] bg-[#99431f] rounded-[10.18px] border border-[#ffd633] flex flex-col gap-[23.75px]">
            <h2 class="Ingredients text-[#fefefe] text-base font-medium font-['Poppins'] capitalize">Ingredients</h2>
            <p class="opacity-80 text-[#fefefe] text-sm font-normal font-['Poppins']">
              <?php echo nl2br(htmlspecialchars($row['sestavine'])); ?>
            </p>
          </div>
        
          <!-- Procedure Section -->
          <div class="Frame28 w-full p-[23.75px] bg-[#99431f] rounded-[10.18px] border border-[#ffd633] flex flex-col gap-[23.75px]">
            <h2 class="Procedure text-[#fefefe] text-base font-medium font-['Poppins'] capitalize">Procedure</h2>
            <p class="opacity-80 text-[#fefefe] text-sm font-normal font-['Poppins']">
              <?php echo nl2br(htmlspecialchars($row['opis'])); ?>
            </p>
          </div>
        
          <!-- Star Rating Section -->
          <div class="StarRating w-full flex items-center justify-center gap-2 mt-4">
            <img src="slike/star.png" class="star w-[38.50px] h-[38.50px]" alt="1 Star" data-rating="1">
            <img src="slike/star.png" class="star w-[38.50px] h-[38.50px]" alt="2 Stars" data-rating="2">
            <img src="slike/star.png" class="star w-[38.50px] h-[38.50px]" alt="3 Stars" data-rating="3">
            <img src="slike/star.png" class="star w-[38.50px] h-[38.50px]" alt="4 Stars" data-rating="4">
            <img src="slike/star.png" class="star w-[38.50px] h-[38.50px]" alt="5 Stars" data-rating="5">
          </div>
        
          <!-- Rating Title -->
          <div class="TitleNormal w-full text-center mt-2">
            <div class="HeaderNormal text-white text-[25.60px] font-medium font-['Poppins'] capitalize">
              <?php echo $average_rating; ?> / 5
            </div>
          </div>
        
          <!-- Submit Button -->
          <button class="PhoneButtonVariant2 w-[141.75px] h-[42px] bg-[#ffd633] rounded-[10.50px] flex items-center justify-center mt-4" onclick="oceniRecept(<?php echo $row['id']; ?>)">
            <span class="Button text-center text-[#010012] text-sm font-normal font-['Poppins'] capitalize">
              Submit
            </span>
          </button>
        </div>
  </div>
  <script src="js/phone-menu.js"></script>
    <script>
    var isLoggedIn = <?php echo isset($_SESSION['log']) ? 'true' : 'false'; ?>;
    var currentRating = isLoggedIn === false ? 0 : someOtherValue;

    // Add event listeners to each star
    document.querySelectorAll('.star').forEach(star => {
        star.addEventListener('click', function() {
            if (!isLoggedIn) {
                alert("You must be logged in to rate a recipe.");
                return;
            }
    
            currentRating = this.dataset.rating; // Set current rating based on the clicked star
            highlightStars(currentRating); // Highlight stars up to the clicked one
        });
    
        star.addEventListener('mouseover', function() {
            highlightStars(this.dataset.rating); // Highlight stars up to the hovered one
        });
    
        star.addEventListener('mouseout', function() {
            highlightStars(currentRating); // Return to the selected rating when not hovering
        });
    });
    
    // Function to highlight stars based on the rating
    function highlightStars(rating) {
        document.querySelectorAll('.star').forEach(star => {
            star.src = (star.dataset.rating <= rating) ? 'slike/star-filled.png' : 'slike/star.png'; // Highlight the selected rating stars
        });
    }

    // Initialize stars based on previous rating after DOM loads
    document.addEventListener("DOMContentLoaded", function() {
        highlightStars(currentRating); // Highlights stars based on previous rating
    });

    // Submit rating when the submit button is clicked
    function oceniRecept(receptId) {
        if (currentRating === 0) {
            alert("Please select a rating before submitting.");
            return;
        }

        // Send rating to the server using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "submit_rating.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                alert("Rating submitted successfully!");
            }
        };
        xhr.send("recept_id=" + receptId + "&rating=" + currentRating);
    }
</script>


</body>
</html>