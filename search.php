<?php
require_once 'baza.php';
require_once 'seja.php';

$search_query = '';

if (isset($_POST['search']) || isset($_POST['cuisine']) || isset($_GET['cuisine'])) {
    // Get the search query if set
    $search_query = isset($_POST['search']) ? mysqli_real_escape_string($link, $_POST['search']) : '';

    // Get the selected cuisine category from POST or GET
    $selected_cuisine = isset($_POST['cuisine']) ? mysqli_real_escape_string($link, $_POST['cuisine']) : '';
    if (isset($_GET['cuisine'])) {
        $selected_cuisine = mysqli_real_escape_string($link, $_GET['cuisine']);
    }

    // Base SQL query
    $sql = "SELECT r.id, r.ime as recept, r.kratek_opis, s.ime as alt, s.url 
            FROM recepti r 
            INNER JOIN slike s ON r.id = s.recept_id";

    // Add conditions for search and category
    $conditions = [];

    // Add search condition
    if (!empty($search_query)) {
        $conditions[] = "(r.ime LIKE '%$search_query%' OR r.kratek_opis LIKE '%$search_query%')";
    }

    // Add cuisine category condition
    if (!empty($selected_cuisine)) {
        $sql_cuisine = "SELECT id FROM kategorije WHERE ime = '$selected_cuisine'";
        $cuisine_result = mysqli_query($link, $sql_cuisine);
        $cuisine_row = mysqli_fetch_array($cuisine_result);

        if ($cuisine_row) {
            $cuisine_id = $cuisine_row['id'];
            $conditions[] = "r.kategorija_id = $cuisine_id";
        } else {
            echo "Kategorija ne obstaja.";
            exit;
        }
    }

    // Append conditions to the main query if there are any
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }

    // Execute the query
    $result = mysqli_query($link, $sql);
    $result_mobile = mysqli_query($link, $sql);

} else {
    // Default query to show all recipes ordered by rating
    $sql = "SELECT r.id, r.ime as recept, r.kratek_opis, s.ime as alt, s.url 
            FROM recepti r 
            INNER JOIN slike s ON r.id = s.recept_id
            LEFT JOIN ocene o ON r.id = o.recept_id 
            ORDER BY o.ocena ASC";
    $result = mysqli_query($link, $sql);
    $result_mobile = mysqli_query($link, $sql);
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
    <style>
        input[type="radio"]:checked + label {
            background-color: #FFD633;
            color: #010012;
        }
    
        label {
            transition: background-color 0.3s, color 0.3s;
        }
    </style>
</head>
<body class="bg-[#99431f] font-['Poppins']">
  <div class="desktop-view"> 
    <div class="w-full sm:w-[1920px]">
        <div class="YummiesRecipesDesktopSearch w-[1920px] h-[1900px] relative bg-[#99431f]">
            <?php include 'header.php'; //header ?>
            <div class="Footer w-[1920px] h-[615px] px-[229px] pt-[135px] pb-[100px] left-0 top-[1281px] absolute bg-[#99431f] justify-between items-start inline-flex">
                <div class="Frame51 h-[380px] flex-col justify-start items-start gap-[50px] inline-flex">
                    <div class="Frame45 flex-col justify-start items-start gap-[43px] flex">
                    <div class="InfoYummiesCom text-[#fefefe] text-[32px] font-normal font-['Poppins']">info@yummies.com</div>
                    <div class="386123456789 text-[#fefefe] text-2xl font-normal font-['Poppins']">+386 123 456 789</div>
                    <div class="SweetStreet121000LjubljanaSlovenia text-[#fefefe] text-2xl font-normal font-['Poppins']">Sweet street 12, 1000 Ljubljana, Slovenia</div>
                    <div class="WeAreACommunityOfFoodLoversSharingDeliciousRecipesTipsAndTricksForEveryoneWhoLovesToCookAndEnjoyFoodOurMissionIsToGiveEveryoneAccessToTheBestRecipesAndCookingInspiration w-[561px] opacity-70 text-[#fefefe] text-base font-normal font-['Poppins'] capitalize">We are a community of food lovers sharing delicious recipes, tips and tricks for everyone who loves to cook and enjoy food. Our mission is to give everyone access to the best recipes and cooking inspiration.</div>
                    </div>
                </div>
                <div class="Frame52 justify-start items-start gap-[94px] flex">
                    <div class="Frame47 flex-col justify-start items-start gap-12 inline-flex">
                    <div class="Categories text-[#fefefe] text-[28px] font-normal font-['Poppins'] capitalize leading-[30px]">Categories</div>
                    <div class="Frame46 opacity-80 flex-col justify-start items-start gap-5 flex">
                        <a href="search.php?cuisine=Italian" class="Italian opacity-80 text-[#fefefe] text-base font-normal font-['Poppins'] capitalize leading-[30px]">Italian</a>
                        <a href="search.php?cuisine=Mexican" class="Mexican opacity-80 text-[#fefefe] text-base font-normal font-['Poppins'] capitalize leading-[30px]">Mexican</a>
                        <a href="search.php?cuisine=Indian" class="Indian opacity-80 text-[#fefefe] text-base font-normal font-['Poppins'] capitalize leading-[30px]">Indian</a>
                        <a href="search.php?cuisine=Asian" class="Asian opacity-80 text-[#fefefe] text-base font-normal font-['Poppins'] capitalize leading-[30px]">Asian</a>
                        <a href="search.php?cuisine=Mediterranean" class="Mediterranean opacity-80 text-[#fefefe] text-base font-normal font-['Poppins'] capitalize leading-[30px]">Mediterranean</a>
                        <a href="search.php?cuisine=American" class="American opacity-80 text-[#fefefe] text-base font-normal font-['Poppins'] capitalize leading-[30px]">American</a>
                    </div>
                    </div>
                    <div class="Frame48 flex-col justify-start items-start gap-12 inline-flex">
                    <div class="HelpSupport text-[#fefefe] text-[28px] font-normal font-['Poppins'] capitalize leading-[30px]">Help & Support</div>
                    <div class="Frame46 opacity-80 flex-col justify-start items-start gap-5 flex">
                        <a href="#" class="Faq opacity-80 text-[#fefefe] text-base font-normal font-['Poppins'] capitalize leading-[30px]">FAQ</a>
                        <a href="#" class="ContactUs opacity-80 text-[#fefefe] text-base font-normal font-['Poppins'] capitalize leading-[30px]">Contact Us</a>
                        <a href="#" class="GeneralTermsAndConditions opacity-80 text-[#fefefe] text-base font-normal font-['Poppins'] capitalize leading-[30px]">General Terms and Conditions</a>
                        <a href="#" class="PrivacyPolicy opacity-80 text-[#fefefe] text-base font-normal font-['Poppins'] capitalize leading-[30px]">Privacy Policy</a>
                        <a href="#" class="Cookies opacity-80 text-[#fefefe] text-base font-normal font-['Poppins'] capitalize leading-[30px]">Cookies</a>
                    </div>
                    </div>
                    <div class="Frame49 flex-col justify-start items-start gap-12 inline-flex">
                    <div class="Community text-[#fefefe] text-[28px] font-normal font-['Poppins'] capitalize leading-[30px]">Community</div>
                    <div class="Frame46 opacity-80 flex-col justify-start items-start gap-5 flex">
                        <a href="#" class="JoinUs opacity-80 text-[#fefefe] text-base font-normal font-['Poppins'] capitalize leading-[30px]">Join us</a>
                        <a href="#" class="PostYourRecipe opacity-80 text-[#fefefe] text-base font-normal font-['Poppins'] capitalize leading-[30px]">Post your recipe</a>
                        <a href="#" class="FollowUsOnSocialMedia opacity-80 text-[#fefefe] text-base font-normal font-['Poppins'] capitalize leading-[30px]">Follow us on social media</a>
                        <a href="#" class="NewsAndUpdates opacity-80 text-[#fefefe] text-base font-normal font-['Poppins'] capitalize leading-[30px]">News and updates</a>
                    </div>
                    </div>
                </div>
            </div>
              <?php
              if (mysqli_num_rows($result) > 0) {
                echo '<div class="Frame427320865 w-[1415px] h-auto left-[249px] top-[436px] absolute">';
                $x=0;
                $y=0;
                $count=0;

                while ($row = mysqli_fetch_array($result)) {
                  if($count == 5){
                    $x=0;
                    $y=$y + 409;
                    $count=0;
                  }
                  echo '<div class="Item w-[215px] h-[381px] left-['.$x.'px] top-['.$y.'] absolute flex-col justify-center items-center gap-3.5 inline-flex">
                          <a href="item.php?id='.$row['id'].'" style="text-decoration:none;">
                            <img src="'.$row['url'].'" alt="'.$row['alt'].'" class="Images w-full max-w-[215px] max-h-[215px] aspect-square left-0 top-0 absolute bg-[#c4c4c4] rounded-[10px]">
                            <div class="Title w-[185px] left-[15px] top-[229px] absolute text-[#fefefe] text-xl font-bold font-['.'Poppins'.']">' . $row['recept'] . '</div>
                            <div class="Description w-[185px] left-[15px] top-[333px] absolute text-[#fefefe] text-base font-normal font-['.'Poppins'.']">' . $row['kratek_opis'] . '</div>
                          </a>
                        </div>';
                  $x=$x + 240;
                }
                echo '</div>';
              }else{
                  echo '
                    <div class="ErrorCircleUndefinedGlyphUndefined w-12 h-12 left-[506px] top-[767px] absolute">
                        <img src="../slike/error.png" alt="error" />
                    </div>
                    <div class="TitleNormal w-[784px] h-12 left-[568px] top-[767px] absolute">
                        <div class="HeaderNormal left-0 top-0 absolute text-[#ffd633] text-[32px] font-medium font-['.'Poppins'.'] capitalize">There are no recipes in this category or search.</div>
                    </div>';
              }
              ?>
            
            <div class="Frame427320872 w-[1167px] h-[57px] left-[252px] top-[304px] absolute">
              <form method="post" action="search.php" id="searchForm">
                <div class="Frame427320862 w-[323px] h-[57px] px-[18px] py-3 left-0 top-0 absolute bg-white rounded-[3px] shadow border border-black justify-center items-center inline-flex">
                    <input type="text" id="search" name="search" placeholder="Search..." class="Search w-[287px] h-[33px] text-black/50 text-2xl font-medium font-['Poppins']">
                </div>
                <button type="submit" id="hiddenSubmit" class="Frame w-[45px] h-[45px] left-[333px] top-[6px] absolute">
                    <img src="slike/search.png" alt="search">
                </button>

                <div class="cuisine-buttons w-[712px] h-[42px] left-[455px] top-[9px] absolute flex gap-3">
                    <input type="radio" id="italian" name="cuisine" value="Italian" class="hidden" />
                    <label for="italian" class="ButtonVariant1 w-[92px] h-[42px] rounded-[100px] border border-[#fefefe] flex items-center justify-center cursor-pointer"> 
                        <span class="text-[#fefefe] text-xl font-normal font-['Poppins'] capitalize">Italian</span>
                    </label>
                
                    <input type="radio" id="mexican" name="cuisine" value="Mexican" class="hidden" />
                    <label for="mexican" class="ButtonVariant1 w-[114px] h-[42px] rounded-[100px] border border-[#fefefe] flex items-center justify-center cursor-pointer">
                        <span class="text-[#fefefe] text-xl font-normal font-['Poppins'] capitalize">Mexican</span>
                    </label>
                
                    <input type="radio" id="indian" name="cuisine" value="Indian" class="hidden" />
                    <label for="indian" class="ButtonVariant1 w-[88px] h-[42px] rounded-[100px] border border-[#fefefe] flex items-center justify-center cursor-pointer">
                        <span class="text-[#fefefe] text-xl font-normal font-['Poppins'] capitalize">Indian</span>
                    </label>
                
                    <input type="radio" id="asian" name="cuisine" value="Asian" class="hidden" />
                    <label for="asian" class="ButtonVariant1 w-[88px] h-[42px] rounded-[100px] border border-[#fefefe] flex items-center justify-center cursor-pointer">
                        <span class="text-[#fefefe] text-xl font-normal font-['Poppins'] capitalize">Asian</span>
                    </label>
                
                    <input type="radio" id="mediterranean" name="cuisine" value="Mediterranean" class="hidden" />
                    <label for="mediterranean" class="ButtonVariant1 w-[165px] h-[42px] rounded-[100px] border border-[#fefefe] flex items-center justify-center cursor-pointer">
                        <span class="text-[#fefefe] text-lg font-normal font-['Poppins'] capitalize">Mediterranean</span>
                    </label>
                
                    <input type="radio" id="american" name="cuisine" value="American" class="hidden" />
                    <label for="american" class="ButtonVariant1 w-[115px] h-[42px] rounded-[100px] border border-[#fefefe] flex items-center justify-center cursor-pointer">
                        <span class="text-[#fefefe] text-lg font-normal font-['Poppins'] capitalize">American</span>
                    </label>
                </div>
              </form>
              
            </div>
            <div class="TitleNormal w-[1412px] h-12 left-[252px] top-[207px] absolute">
              <div class="HeaderNormal left-0 top-0 absolute text-white text-[32px] font-medium font-['Poppins']">
                Recipes 
                <?php 
                  if (!empty($search_query)) {
                      echo "in search: " . htmlspecialchars($search_query);
                  } else if (!empty($selected_cuisine)) {
                      echo "in category: " . htmlspecialchars($selected_cuisine);
                  }
                ?>
              </div>
            </div>
            
        </div>
    </div>
  </div>
  <div class="mobile-view">
      <div class="YummiesRecipesPhoneSearch w-[360px] h-auto min-h-[800px] relative bg-[#99431f]">
        <?php include 'phone-header.php'; //header ?>
        <div class="TitleNormal w-[270px] h-[70px] left-[45px] top-[69px] absolute">
            <div class="HeaderNormal left-0 top-0 absolute text-white text-[22.98px] font-medium font-['Poppins'] capitalize">
                Recipes
                <?php 
                  if (!empty($search_query)) {
                      echo "in search: " . htmlspecialchars($search_query);
                  } else if (!empty($selected_cuisine)) {
                      echo "in category: " . htmlspecialchars($selected_cuisine);
                  }
                ?>
            </div>
        </div>
        
        <form method="post" action="search.php" id="searchForm">
            <div class="Frame427320864 w-[232px] h-[40.94px] left-[45px] top-[142px] absolute bg-white rounded-sm shadow border border-black">
                <input type="text" id="search" name="search" placeholder="Search..." class="Search w-[220.99px] h-[25.41px] left-[6px] top-[7px] absolute text-black/50 text-xl font-medium font-['Poppins']">
            </div>
            <button type="submit" id="hiddenSubmit" class="Frame w-[29px] h-[29px] left-[286px] top-[147px] absolute">
                <img src="slike/search.png" alt="search">
            </button>

            <input type="radio" id="italian_p" name="cuisine" value="Italian" class="hidden" />
            <label for="italian_p" class="ButtonVariant1 w-[92px] h-[42px] px-5 left-[49px] top-[195px] absolute rounded-[100px] border border-[#fefefe] flex items-center justify-center"> 
                <span class="Italian text-center text-[#fefefe] text-xl font-normal font-['Poppins'] capitalize">Italian</span>
            </label>
        
            <input type="radio" id="mexican_p" name="cuisine" value="Mexican" class="hidden" />
            <label for="mexican_p" class="ButtonVariant1 w-[114px] h-[42px] px-5 left-[153px] top-[195px] absolute rounded-[100px] border border-[#fefefe] flex items-center justify-center">
                <span class="Mexican text-[#fefefe] text-xl font-normal font-['Poppins'] capitalize">Mexican</span>
            </label>
        
            <input type="radio" id="indian_p" name="cuisine" value="Indian" class="hidden" />
            <label for="indian_p" class="ButtonVariant1 w-[88px] h-[42px] px-5 left-[47px] top-[249px] absolute rounded-[100px] border border-[#fefefe] flex items-center justify-center">
                <span class="Indian text-[#fefefe] text-xl font-normal font-['Poppins'] capitalize">Indian</span>
            </label>
        
            <input type="radio" id="asian_p" name="cuisine" value="Asian" class="hidden" />
            <label for="asian_p" class="ButtonVariant1 px-4 py-1.5 left-[47px] top-[303px] absolute rounded-[100px] border border-[#fefefe] flex items-center justify-center">
                <span class="Asian text-[#fefefe] text-xl font-normal font-['Poppins'] capitalize">Asian</span>
            </label>
        
            <input type="radio" id="mediterranean_p" name="cuisine" value="Mediterranean" class="hidden" />
            <label for="mediterranean_p" class="ButtonVariant1 w-[165px] h-[42px] px-5 left-[150px] top-[249px] absolute rounded-[100px] border border-[#fefefe] flex items-center justify-center">
                <span class="Mediterranean text-[#fefefe] text-lg font-normal font-['Poppins'] capitalize">Mediterranean</span>
            </label>
        
            <input type="radio" id="american_p" name="cuisine" value="American" class="hidden" />
            <label for="american_p" class="ButtonVariant1 w-[115px] h-[42px] px-5 left-[150px] top-[303px] absolute rounded-[100px] border border-[#fefefe] flex items-center justify-center">
                <span class="American text-[#fefefe] text-lg font-normal font-['Poppins'] capitalize">American</span>
            </label>
        </form>
        
        <?php
          if (mysqli_num_rows($result_mobile) > 0) {
            $y=381;

            while ($row = mysqli_fetch_array($result_mobile)) {
              echo '<div class="Item w-[270px] h-[381px] left-[45px] top-['.$y.'px] absolute">
                      <a href="item.php?id='.$row['id'].'" style="text-decoration:none;">
                        <img src="'.$row['url'].'" alt="'.$row['alt'].'" class="Images w-full max-w-[270px] max-h-[215px] aspect-square left-0 top-0 absolute bg-[#c4c4c4] rounded-[10px]">
                        <div class="Title w-[232.33px] left-[18.84px] top-[229px] absolute text-[#fefefe] text-xl font-bold font-['.'Poppins'.']">' . $row['recept'] . '</div>
                        <div class="Description w-[232.33px] left-[18.84px] top-[333px] absolute text-[#fefefe] text-base font-normal font-['.'Poppins'.']">' . $row['kratek_opis'] . '</div>
                      </a>
                    </div>';
              $y=$y + 400;
            }
          }else{
              echo '
                <div class="ErrorCircleUndefinedGlyphUndefined w-12 h-12 left-[156px] top-[403px] absolute">
                    <img src="../slike/error.png" alt="error" />
                </div>
                <div class="TitleNormal w-[245px] h-48 left-[57px] top-[478px] absolute">
                    <div class="HeaderNormal left-0 top-0 absolute text-[#ffd633] text-[32px] font-medium font-['.'Poppins'.'] capitalize">There are no recipes in this category or search.</div>
                </div>';
          }
        ?>
      </div>
  </div>
  <script src="js/phone-menu.js"></script>
  <script>
    document.getElementById('search').addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Da ne po分lje prazno
            document.getElementById('searchForm').submit();
        }
    });
  </script>
</body>
</html>