<?php
require_once 'baza.php';
include_once 'seja.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);


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

    if (isset($_GET['posodobi'])) {
        $id = $_GET['posodobi'];
    
        //LEFT JOIN, zato če ni slik...
        $sql = "SELECT r.id, r.ime, r.kratek_opis, r.opis, r.sestavine, r.kategorija_id, s.url AS slika_url, s.ime AS slika_alt
                        FROM recepti r 
                        INNER JOIN slike s ON r.id = s.recept_id 
                        WHERE r.id = $id";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_array($result);
    
        // Preverimo, ali so podatki na voljo
        if ($row) {
            $ime = $row['ime'];
            $s = $row['sestavine'];
            $o = $row['opis'];
            $k_o = $row['kratek_opis'];
            $k = $row['kategorija_id'];
            $slika_url = $row['slika_url'];
        } else {
            echo "Izdelek s tem ID-jem ne obstaja ali nima povezanih podatkov.";
        }
    }

    if (isset($_POST['sub'])) {
        $novi_i = htmlspecialchars($_POST['ime'], ENT_QUOTES, 'UTF-8');
        $novi_s = htmlspecialchars($_POST['sestavine'], ENT_QUOTES, 'UTF-8');
        $novi_o = htmlspecialchars($_POST['opis'], ENT_QUOTES, 'UTF-8');
        $novi_k_o = htmlspecialchars($_POST['kratek_opis'], ENT_QUOTES, 'UTF-8');
        $novi_k = $_POST['kategorija'];
        $novi_id = $_POST['id'];
    
        // Update text fields in recepti table
        $sql = "UPDATE recepti SET ime = '$novi_i', sestavine = '$novi_s', opis = '$novi_o', kratek_opis = '$novi_k_o', kategorija_id = '$novi_k' WHERE id = '$novi_id'";
    
        if (!mysqli_query($link, $sql)) {
            $message = '<div class="error-msg">Recipe update failed.</div>';
        } else {
            $message = '<div class="success-msg">Recipe updated successfully.</div>';
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'your_recipes.php';
                    }, 2000);
                </script>";
        }
    
        // Check if an image was uploaded
        if (!empty($_FILES["slika"]["name"])) {
            $target_dir = "slike/izdelki/";
            $target_file = $target_dir . basename($_FILES["slika"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
            // Validate image file
            $check = getimagesize($_FILES["slika"]["tmp_name"]);
            if ($check === false) {
                $message = '<div class="error-msg">The file is not an image.</div>';
                $uploadOk = 0;
            }
    
            if (file_exists($target_file)) {
                $message = '<div class="error-msg">This file already exists.</div>';
                $uploadOk = 0;
            }
    
            if ($_FILES["slika"]["size"] > 500000) {
                $message = '<div class="error-msg">The file is too big.</div>';
                $uploadOk = 0;
            }
    
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                $message = '<div class="error-msg">Only JPG, JPEG, PNG & GIF are allowed.</div>';
                $uploadOk = 0;
            }
    
            // If image checks pass, upload and update database
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["slika"]["tmp_name"], $target_file)) {
                    $slika_ime = htmlspecialchars(basename($_FILES["slika"]["name"]));
    
                    $sql_check = "SELECT id FROM slike WHERE recept_id = '$novi_id'";
                    $result_check = mysqli_query($link, $sql_check);
    
                    if (mysqli_num_rows($result_check) > 0) {
                        $sql = "UPDATE slike SET ime = '$slika_ime', url = '$target_file' WHERE recept_id = '$novi_id'";
                    } else {
                        $sql = "INSERT INTO slike (ime, url, recept_id) VALUES ('$slika_ime', '$target_file', '$novi_id')";
                    }
    
                    if (mysqli_query($link, $sql)) {
                        $message = '<div class="success-msg">Recipe and image updated successfully.</div>';
                        echo "<script>
                            setTimeout(function() {
                                window.location.href = 'your_recipes.php';
                            }, 2000);
                        </script>";
                    } else {
                        $message = '<div class="error-msg">Update of image failed.</div>';
                    }
                } else {
                    $message = '<div class="error-msg">There was an error uploading the file.</div>';
                }
            }
        }
    }

} else {
    // Display an error message if user is not logged in or uporabnik_id is missing
    $message = '<div class="error-msg">You must be logged in to update a recipe.</div>';
    echo "<script>
            setTimeout(function() {
                window.location.href = 'login.php';
            }, 100);
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
                <div class="HeaderNormal left-0 top-0 absolute text-white text-[32px] font-medium font-['Poppins'] capitalize">Update your Recipe</div>
            </div>
            <div class="Form w-[736px] h-[917px] left-[607px] top-[264px] absolute">
            <form action="#" method="post" enctype="multipart/form-data"> 
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>"> 
                <div class="TitleNormal w-[195px] h-9 left-0 top-0 absolute">
                    <div class="NameOfRecipe left-0 top-0 absolute text-white text-2xl font-medium font-['Poppins'] capitalize">Name of Recipe</div>
                </div>
                <div class="Frame427320862 w-[340px] h-10 left-0 top-[36px] absolute bg-white rounded-sm shadow border border-black">
                    <input type="text" name="ime" value="<?php echo htmlspecialchars($ime); ?>" class="Search w-[316px] h-[33px] left-[12px] top-[3px] absolute text-black/50 text-2xl font-medium font-['Poppins']" required>
                </div>

                <div class="TitleNormal w-[212px] h-9 left-[396px] top-0 absolute">
                    <div class="Category left-0 top-0 absolute text-white text-2xl font-medium font-['Poppins'] capitalize">Category</div>
                </div>
                <div class="Frame427320866 w-[340px] h-10 left-[396px] top-[36px] absolute bg-white rounded-sm shadow border border-black">
                    <select name="kategorija" class="Search w-[319px] h-[33px] left-[12px] top-[3px] absolute text-black/50 text-2xl font-medium font-['Poppins']" required>
                        <?php
                            foreach ($categories as $rowk) {
                                $selected = ($rowk['id'] == $k) ? 'selected' : '';
                                echo '<option value="'.htmlspecialchars($rowk['id']).'" '.$selected.'>'.htmlspecialchars($rowk['ime']).'</option>';
                            }
                        ?>
                    </select>
                </div>

                <div class="TitleNormal w-[137px] h-9 left-0 top-[209px] absolute">
                    <div class="Ingredients left-0 top-0 absolute text-white text-2xl font-medium font-['Poppins'] capitalize">Ingredients</div>
                </div>
                <div class="Frame427320863 w-[736px] h-[199px] left-0 top-[245px] absolute bg-white rounded-sm shadow border border-black">
                    <textarea name="sestavine" class="Search w-[704px] h-[168px] left-[16px] top-[16px] absolute text-black/50 text-2xl font-medium font-['Poppins'] resize-none" required><?php echo $s; ?></textarea>
                </div>
                
                <div class="TitleNormal w-[124px] h-9 left-0 top-[464px] absolute">
                    <div class="Procedure left-0 top-0 absolute text-white text-2xl font-medium font-['Poppins'] capitalize">Procedure</div>
                </div>
                <div class="Frame427320864 w-[736px] h-[206px] left-0 top-[500px] absolute bg-white rounded-sm shadow border border-black">
                    <textarea name="opis" class="Search w-[704px] h-[168px] left-[16px] top-[19px] absolute text-black/50 text-2xl font-medium font-['Poppins'] resize-none" required><?php echo $o; ?></textarea>
                </div>

                <div class="TitleNormal w-[84px] h-9 left-0 top-[726px] absolute">
                    <div class="Picture left-0 top-0 absolute text-white text-2xl font-medium font-['Poppins'] capitalize">Picture</div>
                </div>
                <div class="Frame427320865 w-[736px] h-[57px] left-0 top-[762px] absolute bg-white rounded-sm shadow border border-black">
                    <input type="file" name="slika" class="Search w-[704px] h-[40px] left-[16px] top-[10px] absolute text-black/50 text-2xl font-medium font-['Poppins']">
                </div>
                
                <div class="TitleNormal w-[212px] h-9 left-0 top-[96px] absolute">
                    <div class="SmallDescription left-0 top-0 absolute text-white text-2xl font-medium font-['Poppins'] capitalize">Small Description</div>
                </div>
                <div class="Frame427320866 w-[736px] h-[57px] left-0 top-[132px] absolute bg-white rounded-sm shadow border border-black">
                    <input type="text" name="kratek_opis" value="<?php echo htmlspecialchars($k_o); ?>" class="Search w-[704px] h-9 left-[16px] top-[11px] absolute text-black/50 text-2xl font-medium font-['Poppins']" required>
                </div>
                
                <button type="submit" name="sub" class="ButtonVariant2 w-[298px] h-[42px] px-5 py-2.5 left-[219px] top-[875px] absolute bg-[#ffd633] rounded-[100px] justify-between items-center inline-flex">
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
              <input type="text" name="ime" value="<?php echo htmlspecialchars($ime); ?>" class="Search w-[220.99px] h-[25.41px] left-[6px] top-[7px] absolute text-black/50 text-xl font-medium font-['Poppins']" required>
            </div>
            <div class="Frame427320865 w-[232px] h-[40.94px] left-0 top-[131px] absolute bg-white rounded-sm shadow border border-black">
              <input type="text" name="kratek_opis" value="<?php echo htmlspecialchars($k_o); ?>" class="Search w-[220.99px] h-[25.41px] left-[6px] top-[7px] absolute text-black/50 text-xl font-medium font-['Poppins']" required>
            </div>
            <div class="Frame427320866 w-[232px] h-[40.94px] left-0 top-[222px] absolute bg-white rounded-sm shadow border border-black">
              <textarea name="sestavine" class="Search w-[220.99px] h-[25.41px] left-[6px] top-[7px] absolute text-black/50 text-xl font-medium font-['Poppins'] resize-none" required><?php echo $s; ?></textarea>
            </div>
            <div class="Frame427320867 w-[232px] h-[40.94px] left-0 top-[313px] absolute bg-white rounded-sm shadow border border-black">
              <textarea name="opis" class="Search w-[220.99px] h-[25.41px] left-[6px] top-[7px] absolute text-black/50 text-xl font-medium font-['Poppins'] resize-none" required><?php echo $o; ?></textarea>
            </div>
            <div class="Frame427320868 w-[232px] h-[40.94px] left-0 top-[404px] absolute bg-white rounded-sm shadow border border-black">
              <input type="file" name="slika" class="Search w-[220.99px] h-[25px] left-[6px] top-[5px] absolute text-black/50 text-xl font-medium font-['Poppins']">
            </div>
            <div class="Frame427320869 w-[232px] h-[40.94px] left-0 top-[495px] absolute bg-white rounded-sm shadow border border-black">
              <select name="kategorija" class="Search w-[218px] h-[25px] left-[6px] top-[7px] absolute text-black/50 text-xl font-medium font-['Poppins']" required>
                <?php
                    foreach ($categories as $row) {
                        $selected = ($row['id'] == $k) ? 'selected' : '';
                        echo '<option value="'.$row['id'].'" '.$selected.'>'.htmlspecialchars($row['ime']).'</option>';
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
            
            <button type="submit" name="Pošlji" class="PhoneButtonVariant2 w-[141.75px] h-[42px] px-[9.51px] py-[4.76px] left-[44px] top-[556px] absolute bg-[#ffd633] rounded-[10.50px] flex items-center justify-center">
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