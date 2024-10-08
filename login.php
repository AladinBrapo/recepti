<?php 
require_once 'baza.php';
include_once 'seja.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$message = "";

if (isset($_POST['sub'])) {
    // Filtriranje vhodnih podatkov
    $m = filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL);
    $p = htmlspecialchars($_POST['geslo']);

    // Preverjanje veljavnosti emaila
    if (filter_var($m, FILTER_VALIDATE_EMAIL) === false) {
        $message = '<div class="error-msg">Invalid email address.</div>';
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'login.php';
                }, 2000); // Redirect after 2 seconds
              </script>";
    } else {
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

                $message = '<div class="success-msg">Login was successful.</div>';
                echo "<script>
                        setTimeout(function() {
                            window.location.href = 'index.php';
                        }, 2000);
                      </script>";
            } else {
                $message = '<div class="error-msg">Wrong password.</div>';
                echo "<script>
                        setTimeout(function() {
                            window.location.href = 'login.php';
                        }, 2000);
                      </script>";
            }
        } else {
            $message = '<div class="error-msg">The user with this email does not exist.</div>';
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'login.php';
                    }, 2000);
                  </script>";
        }
    }
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
        <div class="YummiesRecipesDesktopLogin w-[1920px] h-[1796px] relative bg-[#99431f]">
            <?php include 'header.php'; //header ?>
            <?php include 'footer.php'; //footer ?>

            <div class="Frame427320870 w-[258px] h-[504px] left-[251px] top-[451px] absolute">
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

            <div class="BigTitle w-[707px] h-[626px] left-[622px] top-[156px] absolute">
                <div class="Bg w-[707px] h-[630px] left-0 top-0 absolute "><img src="../slike/BG.png" alt="BG"></div>
                <div class="BigTitle w-[639.82px] left-[34px] top-[217px] absolute text-center text-[#fefefe] text-[64px] font-medium font-['Poppins'] capitalize">Log in</div>
            </div>

            <form method="post" action="login.php">
            <div class="TitleNormal w-[103px] h-12 left-[839px] top-[638px] absolute">
                <div class="HeaderNormal left-0 top-0 absolute text-white text-[32px] font-medium font-['Poppins'] capitalize">E-mail</div>
            </div>
            <div class="Frame427320858 w-[323px] h-[57px] left-[839px] top-[686px] absolute bg-white rounded-[3px] shadow border border-black">
                <div class="MailUndefinedGlyphUndefined w-6 h-6 left-[285px] top-[17px] absolute"><img src="../slike/mail-icon.png" alt="mail-icon"></div>
                <input type="email" class="Search w-[265px] h-[33px] left-[10px] top-[12px] absolute text-black/50 text-2xl font-medium font-['Poppins']" name="mail" placeholder="Email" required autofocus>
            </div>
            
            <div class="TitleNormal w-[156px] h-12 left-[839px] top-[777px] absolute">
                <div class="HeaderNormal left-0 top-0 absolute text-white text-[32px] font-medium font-['Poppins'] capitalize">Password</div>
            </div>
            <div class="Frame427320859 w-[323px] h-[57px] left-[839px] top-[825px] absolute bg-white rounded-[3px] shadow border border-black">
                <div class="EyeUndefinedGlyphUndefined w-6 h-6 left-[285px] top-[17px] absolute cursor-pointer" onclick="togglePasswordVisibility()">
                    <img src="../slike/eye-closed.png" id="toggle-desktop-eye" alt="eye-icon">
                </div>
                <input type="password" name="geslo" id="desktop-password-field" class="Search w-[265px] h-[33px] left-[10px] top-[12px] absolute text-black/50 text-2xl font-medium font-['Poppins']" placeholder="Password" required>
            </div>
            
            <button type="submit" name="sub" class="ButtonVariant2 w-[323px] h-[45.52px] px-[21.68px] py-[10.84px] left-[839px] top-[934px] absolute bg-[#ffd633] rounded-[108.39px] justify-between items-center inline-flex">
                <img class="Yummies2 w-[32.52px] h-[32.52px] rounded-[33.03px]" src="../slike/button-logo.png" alt="button-logo"/>
                <span class="Button text-[#010012] text-[21.68px] font-normal font-['Poppins'] capitalize">Login</span>
                <div class="ArrowForward w-[26.01px] h-[26.01px] relative">
                    <div class="BoundingBox w-[17px] h-[17px] left-1 top-1 absolute"><img src="../slike/arrow_forward.png" alt="arrow_forward"></div>
                </div>
            </button>

            </form>
            
            <div class="Frame427320860 w-[323px] h-[57px] left-[839px] top-[1090px] absolute bg-white rounded-[3px] shadow border border-black">
                <div class="GoogleLogin w-[292px] h-[39px] left-[21px] top-[9px] absolute text-black text-[21.68px] font-normal font-['Poppins'] capitalize">Google login</div>
              </div>
            <div class="TitleSmall w-[222px] h-6 left-[839px] top-[1006px] absolute">
                <div class="TextSmall left-0 top-0 absolute text-white text-base font-medium font-['Poppins'] capitalize">Don't have an account yet?</div>
            </div>
            <div class="TitleSmall w-[109px] h-6 left-[1061px] top-[1006px] absolute">
                <a href="register.php" class="TextSmall left-0 top-0 absolute text-[#ffd633] text-base font-medium font-['Poppins'] capitalize">Register now.</a>
            </div>
            
        </div>
    </div>
  </div>
  <div class="mobile-view">
    <div class="YummiesRecipesPhoneLogin w-[360px] h-[800px] relative bg-[#99431f]">
        <?php include 'phone-header.php'; //header ?>

        <div class="Frame427320871 w-[311px] h-[71px] left-[24px] top-[79px] absolute">
            <div class="TitleNormal w-[284px] h-[55px] left-[14px] top-[8px] absolute">
                <div class="HeaderNormal left-[54px] top-0 absolute text-center text-[#ffd633] text-base font-medium font-['Poppins'] capitalize">
                    <?php if ($message): ?>
                        <div class="message">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="PhoneBigTitle w-[347px] h-[249px] left-[6px] top-[79px] absolute">
            <div class="Bg w-[347px] h-[249px] left-0 top-0 absolute"><img src="../slike/BG-phone.2.png" alt="BG"></div>
            <div class="DiscoverTastyCreationsForEveryMeal w-[220px] left-[64px] top-[62px] absolute text-center text-[#fefefe] text-[28px] font-medium font-['Poppins'] capitalize"><br/>Log in<br/></div>
        </div>
        
        <form method="post" action="login.php">
        <div class="TitleNormal w-[73.98px] h-[34.48px] left-[64px] top-[294px] absolute">
            <div class="HeaderNormal left-0 top-0 absolute text-white text-[22.98px] font-medium font-['Poppins'] capitalize">E-mail</div>
        </div>
        <div class="TitleNormal w-28 h-[34.48px] left-[64px] top-[420.42px] absolute">
            <div class="HeaderNormal left-0 top-0 absolute text-white text-[22.98px] font-medium font-['Poppins'] capitalize">Password</div>
        </div>
        <div class="Frame427320860 w-[232px] h-[40.94px] left-[64px] top-[342.84px] absolute bg-white rounded-sm shadow border border-black">
            <div class="MailUndefinedGlyphUndefined w-[17.24px] h-[17.24px] left-[204.71px] top-[12.21px] absolute"><img src="../slike/mail-icon.png" alt="mail-icon"></div>
            <input type="email" class="Search w-[191px] h-[25px] left-[6px] top-[7.16px] absolute text-black/50 text-xl font-medium font-['Poppins']" name="mail" placeholder="Email" required autofocus>
        </div>
        <div class="Frame427320861 w-[232px] h-[40.94px] left-[64px] top-[464.95px] absolute bg-white rounded-sm shadow border border-black">
            <div class="EyeUndefinedGlyphUndefined w-[17.24px] h-[17.24px] left-[204.71px] top-[12.21px] absolute cursor-pointer" onclick="togglePhonePasswordVisibility()">
                <img src="../slike/eye-closed.png" id="toggle-phone-eye" alt="eye-icon">
            </div>
            <input type="password" name="geslo" id="phone-password-field" class="Search w-[191px] h-[25px] left-[6px] top-[7.16px] absolute text-black/50 text-xl font-medium font-['Poppins']" placeholder="Password" required>
        </div>
        
        <button type="submit" name="sub" class="PhoneSmallButtonVariant2 w-[150px] h-10 px-[12.38px] py-[6.19px] left-[105px] top-[526px] absolute bg-[#ffd633] rounded-xl flex items-center justify-center">
            <div class="Button text-center text-[#010012] text-xs font-normal font-['Poppins'] capitalize">Log In</div>
        </button>
        
        </form>
        
        <div class="TitleSmall w-[195px] h-5 left-[35px] top-[586px] absolute">
            <div class="TextSmall left-0 top-[-0.67px] absolute text-white text-sm font-medium font-['Poppins'] capitalize">Don't have an account yet?</div>
        </div>
        <div class="TitleSmall w-[95px] h-[17px] left-[235px] top-[587px] absolute">
            <a href="register.php" class="TextSmall left-0 top-[-2.17px] absolute text-[#ffd633] text-sm font-medium font-['Poppins'] capitalize">Register Now.</a>
        </div>
        <div class="Frame427320861 w-[232px] h-[40.94px] left-[64px] top-[677px] absolute bg-white rounded-sm shadow border border-black">
            <div class="GoogleLogin w-[209.73px] h-7 left-[15.08px] top-[6.46px] absolute text-black text-base font-normal font-['Poppins'] capitalize">Google login</div>
        </div>
    </div>
  </div>
  <script src="js/phone-menu.js"></script>
  <script>
    function togglePasswordVisibility() {
        var passwordField = document.getElementById("desktop-password-field");
        var eyeIcon = document.getElementById("toggle-desktop-eye");
        
        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeIcon.src = "../slike/eye-icon.png"; // The open eye image
        } else {
            passwordField.type = "password";
            eyeIcon.src = "../slike/eye-closed.png"; // The closed eye image
        }
    }
    
    function togglePhonePasswordVisibility() {
        var passwordField = document.getElementById("phone-password-field");
        var eyeIcon = document.getElementById("toggle-phone-eye");
        
        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeIcon.src = "../slike/eye-icon.png"; // The open eye image
        } else {
            passwordField.type = "password";
            eyeIcon.src = "../slike/eye-closed.png"; // The closed eye image
        }
    }

    </script>

</body>
</html>