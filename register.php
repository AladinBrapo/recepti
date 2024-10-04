<?php
require_once 'baza.php';

$message = "";

if (isset($_POST['sub'])) {
    // Filtriranje vhodnih podatkov
    $m = filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL);
    $g = htmlspecialchars($_POST['geslo'], ENT_QUOTES, 'UTF-8');
    $i = htmlspecialchars($_POST['ime'], ENT_QUOTES, 'UTF-8');
    $p = htmlspecialchars($_POST['pri'], ENT_QUOTES, 'UTF-8');
    
    // Preverjanje veljavnosti emaila
    if (!filter_var($m, FILTER_VALIDATE_EMAIL)) {
        $message = '<div class="error-msg">Wrong email address.</div>';
        header("Refresh: 1; URL=register.php");
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
            $message = '<div class="error-msg">We already have a user under this email. Use another.</div>';
            header("Refresh: 2; URL=register.php");
        } else {
            mysqli_stmt_close($stmt); // Close the statement before reusing the variable
            $stmt = mysqli_prepare($link, "INSERT INTO uporabniki (ime, priimek, email, geslo, vrsta_up_id) VALUES (?, ?, ?, ?, 1)");
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssss", $i, $p, $m, $g2);
                $executed = mysqli_stmt_execute($stmt);
                if ($executed) {
                    $id_up = mysqli_insert_id($link);

                    $message = '<div class="success-msg">Registration was successful.</div>';
                    header("Refresh: 2; URL=login.php");
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
    
    <title>Yummies - Discover Tasty Creations</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="icon" href="../slike/yummies-logo.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/main.css">
</head>
<body class="bg-[#99431f] font-['Poppins']">
  <div class="desktop-view"> 
    <div class="w-full sm:w-[1920px]">
        <div class="YummiesRecipesDesktopRegister w-[1920px] h-[1796px] relative bg-[#99431f]">
            <?php include 'header.php'; //header ?>
            <?php include 'footer.php'; //footer ?>
            
            <div class="Frame427320869 w-[258px] h-[504px] left-[251px] top-[451px] absolute">
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
                <div class="Bg w-[707px] h-[630px] left-0 top-0 absolute"><img src="../slike/BG.png" alt="BG"></div>
                <div class="BigTitle w-[639.82px] left-[34px] top-[217px] absolute text-center text-[#fefefe] text-[64px] font-medium font-['Poppins'] capitalize">Register</div>
            </div>
            
            <form method="post" action="register.php">

                <div class="TitleNormal w-[103px] h-12 left-[673px] top-[634px] absolute">
                    <div class="HeaderNormal left-0 top-0 absolute text-white text-[32px] font-medium font-['Poppins'] capitalize">Name</div>
                </div>
                <div class="TitleNormal w-[103px] h-12 left-[1043px] top-[634px] absolute">
                    <div class="HeaderNormal left-0 top-0 absolute text-white text-[32px] font-medium font-['Poppins'] capitalize">Surname</div>
                </div>
                <div class="TitleNormal w-[156px] h-12 left-[673px] top-[810px] absolute">
                    <div class="HeaderNormal left-0 top-0 absolute text-white text-[32px] font-medium font-['Poppins'] capitalize">E-Mail</div>
                </div>
                <div class="TitleNormal w-[156px] h-12 left-[1043px] top-[810px] absolute">
                    <div class="HeaderNormal left-0 top-0 absolute text-white text-[32px] font-medium font-['Poppins'] capitalize">Password</div>
                </div>

                <div class="Frame427320860 w-[323px] h-[57px] left-[1043px] top-[702px] absolute bg-white rounded-[3px] shadow border border-black">
                    <input type="text" name="ime" placeholder="Name" class="Search w-[287px] h-[33px] left-[18px] top-[12px] absolute text-black/50 text-2xl font-medium font-['Poppins']" required>
                </div>
                <div class="Frame427320859 w-[323px] h-[57px] left-[673px] top-[702px] absolute bg-white rounded-[3px] shadow border border-black">
                    <input type="text" name="pri" placeholder="Surname" class="Search w-[287px] h-[33px] left-[18px] top-[12px] absolute text-black/50 text-2xl font-medium font-['Poppins']" required>
                </div>
                <div class="Frame427320858 w-[323px] h-[57px] left-[673px] top-[871px] absolute bg-white rounded-[3px] shadow border border-black">
                    <input type="email" name="mail" placeholder="Email" class="Search w-[265px] h-[33px] left-[10px] top-[12px] absolute text-black/50 text-2xl font-medium font-['Poppins']" required>
                    <div class="MailUndefinedGlyphUndefined w-6 h-6 left-[285px] top-[17px] absolute"><img src="../slike/mail-icon.png" alt="mail-icon"></div>
                </div>
                <div class="Frame427320861 w-[323px] h-[57px] left-[1043px] top-[872px] absolute bg-white rounded-[3px] shadow border border-black">
                    <div class="EyeUndefinedGlyphUndefined w-6 h-6 left-[285px] top-[17px] absolute cursor-pointer" onclick="togglePasswordVisibility()">
                        <img src="../slike/eye-closed.png" id="toggle-desktop-eye" alt="eye-icon">
                    </div>
                    <input type="password" name="geslo" id="desktop-password-field" placeholder="Password" class="Search w-[265px] h-[33px] left-[10px] top-[12px] absolute text-black/50 text-2xl font-medium font-['Poppins']" required>
                </div>

                <button type="submit" name="sub" class="ButtonVariant2 w-[323px] h-[45.52px] px-[21.68px] py-[10.84px] left-[839px] top-[973.24px] absolute bg-[#ffd633] rounded-[108.39px] justify-between items-center inline-flex">
                    <img class="Yummies2 w-[32.52px] h-[32.52px] rounded-[33.03px]" src="../slike/button-logo.png" alt="button-logo" />
                    <div class="Button text-[#010012] text-[21.68px] font-normal font-['Poppins'] capitalize">Register</div>
                    <div class="ArrowForward w-[26.01px] h-[26.01px] relative">
                        <div class="BoundingBox w-[17px] h-[17px] left-1 top-1 absolute"><img src="../slike/arrow_forward.png" alt="arrow_forward"></div>
                    </div>
                </button>

            </form>
            
            <div class="TitleSmall w-[214px] h-6 left-[865px] top-[1047px] absolute">
                <div class="TextSmall left-0 top-0 absolute text-white text-base font-medium font-['Poppins'] capitalize">Already have an account?</div>
            </div>
            <div class="TitleSmall w-[58px] h-6 left-[1085px] top-[1047px] absolute">
                <a href="login.php" class="TextSmall left-0 top-0 absolute text-[#ffd633] text-base font-medium font-['Poppins'] capitalize">Sign in.</a>
            </div>
            
        </div>
    </div>
  </div>
  <div class="mobile-view">
    <div class="YummiesRecipesPhoneRegister w-[360px] h-[800px] relative bg-[#99431f]">

        <?php include 'phone-header.php'; //header ?>

        <div class="Frame427320870 w-[311px] h-[71px] left-[24px] top-[79px] absolute">
            <div class="TitleNormal w-[284px] h-[55px] left-[14px] top-[8px] absolute">
                <div class="HeaderNormal left-[27px] top-0 absolute text-center text-[#ffd633] text-base font-medium font-['Poppins'] capitalize">
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
            <div class="DiscoverTastyCreationsForEveryMeal w-[220px] left-[64px] top-[62px] absolute text-center text-[#fefefe] text-[28px] font-medium font-['Poppins'] capitalize"><br/>Register</div>
        </div>

        <form method="post" action="register.php">

            <div class="TitleNormal w-[80px] h-[34.48px] left-[64px] top-[474.47px] absolute">
                <div class="HeaderNormal left-0 top-0 absolute text-white text-[22.98px] font-medium font-['Poppins'] ">E-mail</div>
            </div>
            <div class="TitleNormal w-[73.98px] h-[34.48px] left-[60px] top-[264px] absolute">
                <div class="HeaderNormal left-0 top-0 absolute text-white text-[22.98px] font-medium font-['Poppins'] ">Name</div>
            </div>
            <div class="TitleNormal w-28 h-[34.48px] left-[64px] top-[579.89px] absolute">
                <div class="HeaderNormal left-0 top-0 absolute text-white text-[22.98px] font-medium font-['Poppins'] ">Password</div>
            </div>
            <div class="TitleNormal w-28 h-[34.48px] left-[60px] top-[369px] absolute">
                <div class="HeaderNormal left-0 top-0 absolute text-white text-[22.98px] font-medium font-['Poppins'] ">Surname</div>
            </div>

            <div class="Frame427320860 w-[232px] h-[40.94px] left-[60px] top-[518.95px] absolute bg-white rounded-sm shadow border border-black">
                <div class="MailUndefinedGlyphUndefined w-[17.24px] h-[17.24px] left-[204.71px] top-[12.21px] absolute"><img src="../slike/mail-icon.png" alt="mail-icon"></div>
                <input type="email" name="mail" placeholder="Email" class="Search w-[191px] h-[25px] left-[6px] top-[7.16px] absolute text-black/50 text-xl font-medium font-['Poppins']" required>
            </div>
            <div class="Frame427320862 w-[232px] h-[40.94px] left-[60px] top-[308px] absolute bg-white rounded-sm shadow border border-black">
                <input type="text" name="ime" placeholder="Name" class="Search w-[220.99px] h-[25.41px] left-[6px] top-[7px] absolute text-black/50 text-xl font-medium font-['Poppins']" required>
            </div>
            <div class="Frame427320861 w-[232px] h-[40.94px] left-[64px] top-[624.37px] absolute bg-white rounded-sm shadow border border-black">
                <div class="EyeUndefinedGlyphUndefined w-[17.24px] h-[17.24px] left-[204.71px] top-[12.21px] absolute" onclick="togglePhonePasswordVisibility()">
                    <img src="../slike/eye-closed.png" id="toggle-phone-eye" alt="eye-icon">
                </div>
                <input type="password" name="geslo" id="phone-password-field" placeholder="Password" class="Search w-[191px] h-[25px] left-[6px] top-[7.16px] absolute text-black/50 text-xl font-medium font-['Poppins']" required>
            </div>
            <div class="Frame427320863 w-[232px] h-[40.94px] left-[60px] top-[413.53px] absolute bg-white rounded-sm shadow border border-black">
                <input type="text" name="pri" placeholder="Surname" class="Search w-[220.99px] h-[25.41px] left-[6px] top-[7px] absolute text-black/50 text-xl font-medium font-['Poppins']" required>
            </div>

            <button type="submit" name="sub" class="PhoneSmallButtonVariant2 w-[150px] h-10 px-[12.38px] py-[6.19px] left-[105px] top-[699px] absolute bg-[#ffd633] rounded-xl flex items-center justify-center">
                <div class="Button text-center text-[#010012] text-xs font-normal font-['Poppins'] capitalize">Register</div>
            </button>

        </form>

        <div class="TitleSmall w-[187px] h-5 left-[56px] top-[759px] absolute">
            <div class="TextSmall left-0 top-[-0.66px] absolute text-white text-sm font-medium font-['Poppins'] capitalize">Already have an account?</div>
        </div>
        <div class="TitleSmall w-[51px] h-5 left-[254.60px] top-[759px] absolute">
            <a href="login.php" class="TextSmall left-0 top-[-0.66px] absolute text-[#ffd633] text-sm font-medium font-['Poppins'] capitalize">Sign in.</a>
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