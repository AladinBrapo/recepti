<?php
require_once 'baza.php';
include_once 'seja.php';

$sqlk = "SELECT * FROM kategorije";
$resultk = mysqli_query($link, $sqlk);

$message = '';

$categories = []; // Array to store categories

// Store categories in an array
while ($row = mysqli_fetch_array($resultk)) {
    $categories[] = $row;
}

// Check if the user is logged in and has a valid uporabnik_id
if (isset($_SESSION['log']) && isset($_SESSION['uporabnik_id'])) {
    $uporabnik_id = $_SESSION['uporabnik_id'];

    if (isset($_POST['Po分lji'])) {
        $i = htmlspecialchars($_POST['ime'], ENT_QUOTES, 'UTF-8');
        $s = htmlspecialchars($_POST['sestavine'], ENT_QUOTES, 'UTF-8');
        $o = htmlspecialchars($_POST['opis'], ENT_QUOTES, 'UTF-8');
        $k_o = htmlspecialchars($_POST['kratek_opis'], ENT_QUOTES, 'UTF-8');
        $k = htmlspecialchars($_POST['kategorija']);

        // Image upload handling
        $target_dir = "slike/izdelki/";
        $target_file = $target_dir . basename($_FILES["slika"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["slika"]["tmp_name"]);
        if ($check === false) {
            $message = '<div class="error-msg">The file is not an image.</div>';
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $message = '<div class="error-msg">This file already exists.</div>';
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["slika"]["size"] > 500000) {
            $message = '<div class="error-msg">The file is too big.</div>';
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            $message = '<div class="error-msg">Only JPG, JPEG, PNG & GIF are allowed.</div>';
            $uploadOk = 0;
        }

        // If image checks pass, proceed with upload and insert recipe
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["slika"]["tmp_name"], $target_file)) {

                // Insert into recepti table
                $sql = "INSERT INTO recepti (ime, uporabnik_id, sestavine, opis, kratek_opis, kategorija_id) VALUES ('$i', '$uporabnik_id', '$s', '$o', '$k_o', '$k')";
                if (mysqli_query($link, $sql)) {
                    $recept_id = mysqli_insert_id($link);

                    // Insert into slike table
                    $slika_ime = htmlspecialchars(basename($_FILES["slika"]["name"]));
                    $sql = "INSERT INTO slike (ime, url, recept_id) VALUES ('$slika_ime', '$target_file', '$recept_id')";

                    if (mysqli_query($link, $sql)) {
                        $message = '<div class="success-msg">Recipe and image inserted successfully.</div>';
                        echo "<script>
                            setTimeout(function() {
                                window.location.href = 'search.php';
                            }, 2000);
                        </script>";
                    } else {
                        $message = '<div class="error-msg">Insert image failed.</div>';
                    }
                } else {
                    $message = '<div class="error-msg">Recipe insertion failed.</div>';
                }
            } else {
                $message = '<div class="error-msg">There was an error uploading the file.</div>';
            }
        }
    }
} else {
    // Display an error message if user is not logged in or uporabnik_id is missing
    $message = '<div class="error-msg">You must be logged in to submit a recipe.</div>';
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
        <div class="YummiesRecipesDesktopEditItem w-[1920px] h-[1796px] relative bg-[#99431f]">

            <?php include 'header.php'; //header ?>
            <?php include 'footer.php'; //footer ?>
            
            <div class="Frame427320870 w-[258px] h-[504px] left-[227px] top-[472px] absolute">
                <div class="TitleNormal w-[196px] h-[436px] left-[31px] top-[34px] absolute">
                    <div class="HeaderNormal left-0 top-0 absolute text-[#ffd633] text-[32px] font-medium font-['Poppins'] capitalize">
                        <?php if ($message): ?>
                            <div class="message">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="TitleNormal w-[314px] h-12 left-[252px] top-[207px] absolute">
                <div class="HeaderNormal left-0 top-0 absolute text-white text-[32px] font-medium font-['Poppins'] capitalize">Submit your Recipe</div>
            </div>
            <div class="Form w-[736px] h-[917px] left-[607px] top-[264px] absolute">
            <form action="#" method="post" enctype="multipart/form-data">  
                <div class="TitleNormal w-[195px] h-9 left-0 top-0 absolute">
                    <div class="NameOfRecipe left-0 top-0 absolute text-white text-2xl font-medium font-['Poppins'] capitalize">Name of Recipe</div>
                </div>
                <div class="Frame427320862 w-[340px] h-10 left-0 top-[36px] absolute bg-white rounded-sm shadow border border-black">
                    <input type="text" name="ime" value="<?php echo isset($_POST['ime']) ? htmlspecialchars($_POST['ime'], ENT_QUOTES, 'UTF-8') : ''; ?>" class="Search w-[316px] h-[33px] left-[12px] top-[3px] absolute text-black/50 text-2xl font-medium font-['Poppins']" required>
                </div>
            
                <div class="TitleNormal w-[212px] h-9 left-[396px] top-0 absolute">
                    <div class="Category left-0 top-0 absolute text-white text-2xl font-medium font-['Poppins'] capitalize">Category</div>
                </div>
                <div class="Frame427320866 w-[340px] h-10 left-[396px] top-[36px] absolute bg-white rounded-sm shadow border border-black">
                    <select name="kategorija" class="Search w-[319px] h-[33px] left-[12px] top-[3px] absolute text-black/50 text-2xl font-medium font-['Poppins']" required>
                        <?php
                            foreach ($categories as $row) {
                                $selected = (isset($_POST['kategorija']) && $_POST['kategorija'] == $row['id']) ? 'selected' : '';
                                echo '<option value="'.$row['id'].'" '.$selected.'>'.htmlspecialchars($row['ime']).'</option>';
                            }
                        ?>
                    </select>
                </div>
            
                <div class="TitleNormal w-[137px] h-9 left-0 top-[209px] absolute">
                    <div class="Ingredients left-0 top-0 absolute text-white text-2xl font-medium font-['Poppins'] capitalize">Ingredients</div>
                </div>
                <div class="Frame427320863 w-[736px] h-[199px] left-0 top-[245px] absolute bg-white rounded-sm shadow border border-black">
                    <textarea name="sestavine" class="Search w-[704px] h-[168px] left-[16px] top-[16px] absolute text-black/50 text-2xl font-medium font-['Poppins'] resize-none overflow-auto" rows="20" required><?php echo isset($_POST['sestavine']) ? htmlspecialchars($_POST['sestavine'], ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
                </div>
                
                <div class="TitleNormal w-[124px] h-9 left-0 top-[464px] absolute">
                    <div class="Procedure left-0 top-0 absolute text-white text-2xl font-medium font-['Poppins'] capitalize">Procedure</div>
                </div>
                <div class="Frame427320864 w-[736px] h-[206px] left-0 top-[500px] absolute bg-white rounded-sm shadow border border-black">
                    <textarea name="opis" class="Search w-[704px] h-[168px] left-[16px] top-[19px] absolute text-black/50 text-2xl font-medium font-['Poppins'] resize-none overflow-auto" rows="12" required><?php echo isset($_POST['opis']) ? htmlspecialchars($_POST['opis'], ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
                </div>
            
                <div class="TitleNormal w-[84px] h-9 left-0 top-[726px] absolute">
                    <div class="Picture left-0 top-0 absolute text-white text-2xl font-medium font-['Poppins'] capitalize">Picture</div>
                </div>
                <div class="Frame427320865 w-[736px] h-[57px] left-0 top-[762px] absolute bg-white rounded-sm shadow border border-black">
                    <input type="file" name="slika" accept="image/*" class="Search w-[704px] h-[40px] left-[16px] top-[10px] absolute text-black/50 text-2xl font-medium font-['Poppins']" required>
                </div>
                
                <div class="TitleNormal w-[212px] h-9 left-0 top-[96px] absolute">
                    <div class="SmallDescription left-0 top-0 absolute text-white text-2xl font-medium font-['Poppins'] capitalize">Small Description</div>
                </div>
                <div class="Frame427320866 w-[736px] h-[57px] left-0 top-[132px] absolute bg-white rounded-sm shadow border border-black">
                    <input type="text" name="kratek_opis" value="<?php echo isset($_POST['kratek_opis']) ? htmlspecialchars($_POST['kratek_opis'], ENT_QUOTES, 'UTF-8') : ''; ?>" class="Search w-[704px] h-9 left-[16px] top-[11px] absolute text-black/50 text-2xl font-medium font-['Poppins']" required>
                </div>
                
                <button type="submit" name="Po分lji" class="ButtonVariant2 w-[298px] h-[42px] px-5 py-2.5 left-[219px] top-[875px] absolute bg-[#ffd633] rounded-[100px] justify-between items-center inline-flex">
                    <img class="Yummies2 w-[30px] h-[30px] rounded-[30.48px]" src="../slike/button-logo.png" alt="button-logo"/>
                    <div class="Button text-[#010012] text-xl font-normal font-['Poppins'] capitalize">Submit</div>
                    <div class="ArrowForward w-6 h-6 relative">
                        <div class="BoundingBox w-[17px] h-[17px] left-1 top-1 absolute">
                            <img src="../slike/arrow_forward.png" alt="arrow_forward">
                        </div>
                    </div>
                </button>
            </form>

    
            </div>
        </div>
    </div>
  </div>
  <div class="mobile-view">
    <div class="YummiesRecipesPhoneSearch w-[360px] h-[800px] relative bg-[#99431f]">
        <?php include 'phone-header.php'; //header ?>
        <div class="Form w-[232px] h-[598px] left-[64px] top-[188px] absolute">
        <form action="#" method="post" enctype="multipart/form-data"> 
            <div class="Frame427320864 w-[232px] h-[40.94px] left-0 top-[40px] absolute bg-white rounded-sm shadow border border-black">
              <input type="text" name="ime" class="Search w-[220.99px] h-[25.41px] left-[6px] top-[7px] absolute text-black/50 text-xl font-medium font-['Poppins']" required>
            </div>
            <div class="Frame427320865 w-[232px] h-[40.94px] left-0 top-[131px] absolute bg-white rounded-sm shadow border border-black">
              <input type="text" name="kratek_opis" class="Search w-[220.99px] h-[25.41px] left-[6px] top-[7px] absolute text-black/50 text-xl font-medium font-['Poppins']" required>
            </div>
            <div class="Frame427320866 w-[232px] h-[40.94px] left-0 top-[222px] absolute bg-white rounded-sm shadow border border-black">
              <textarea name="sestavine" class="Search w-[220.99px] h-[25.41px] left-[6px] top-[7px] absolute text-black/50 text-xl font-medium font-['Poppins'] resize-none" required></textarea>
            </div>
            <div class="Frame427320867 w-[232px] h-[40.94px] left-0 top-[313px] absolute bg-white rounded-sm shadow border border-black">
              <textarea name="opis" class="Search w-[220.99px] h-[25.41px] left-[6px] top-[7px] absolute text-black/50 text-xl font-medium font-['Poppins'] resize-none" required></textarea>
            </div>
            <div class="Frame427320868 w-[232px] h-[40.94px] left-0 top-[404px] absolute bg-white rounded-sm shadow border border-black">
              <input type="file" name="slika" accept="image/*" class="Search w-[220.99px] h-[25px] left-[6px] top-[5px] absolute text-black/50 text-xl font-medium font-['Poppins']" required>
            </div>
            <div class="Frame427320869 w-[232px] h-[40.94px] left-0 top-[495px] absolute bg-white rounded-sm shadow border border-black">
              <select name="kategorija" class="Search w-[218px] h-[25px] left-[6px] top-[7px] absolute text-black/50 text-xl font-medium font-['Poppins']" required>
                <?php
                    foreach ($categories as $row) {
                        echo '<option value="'.$row['id'].'">'.htmlspecialchars($row['ime']).'</option>';
                    }
                ?>
              </select>
            </div>
            
            <div class="NameOfRecipe w-[173px] left-0 top-0 absolute text-[#fefefe] text-xl font-normal font-['Poppins'] capitalize">Name Of Recipe</div>
            <div class="SmallDescription w-[184px] left-0 top-[91px] absolute text-[#fefefe] text-xl font-normal font-['Poppins'] capitalize">Small Description</div>
            <div class="Ingredients w-[122px] left-0 top-[182px] absolute text-[#fefefe] text-xl font-normal font-['Poppins'] capitalize">Ingredients</div>
            <div class="Procedure w-28 left-0 top-[273px] absolute text-[#fefefe] text-xl font-normal font-['Poppins'] capitalize">Procedure</div>
            <div class="Picture w-[88px] left-0 top-[364px] absolute text-[#fefefe] text-xl font-normal font-['Poppins'] capitalize">Picture</div>
            <div class="Category w-[184px] left-0 top-[455px] absolute text-[#fefefe] text-xl font-normal font-['Poppins'] capitalize">Category</div>
            
            <button type="submit" name="Po分lji" class="PhoneButtonVariant2 w-[141.75px] h-[42px] px-[9.51px] py-[4.76px] left-[44px] top-[556px] absolute bg-[#ffd633] rounded-[10.50px] flex items-center justify-center">
              <div class="Button text-center text-[#010012] text-sm font-normal font-['Poppins'] capitalize">Submit</div>
            </butto>
        </form>
        </div>
        <div class="TitleNormal w-[228px] h-[34px] left-[64px] top-[145px] absolute">
            <div class="HeaderNormal left-0 top-0 absolute text-white text-[22.98px] font-medium font-['Poppins'] capitalize">Submit Your Recipe</div>
        </div>
        <div class="TitleNormal w-[284px] h-[55px] left-[38px] top-[81px] absolute">
            <div class="HeaderNormal left-[27px] top-0 absolute text-center text-[#ffd633] text-base font-medium font-['Poppins'] capitalize">
                <?php if ($message): ?>
                    <div class="message">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
  </div>
  <script src="js/phone-menu.js"></script>
</body>
</html>