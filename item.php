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
            <div class="TitleNormal w-[201px] h-12 left-[252px] top-[207px] absolute">
                <div class="HeaderNormal left-0 top-0 absolute text-white text-[32px] font-medium font-['Poppins'] capitalize">Recipe : Title</div>
            </div>
            <div class="Image w-[950px] h-[350px] left-[252px] top-[295px] absolute bg-[#c4c4c4] rounded-br-[15px]"><img src="slike/image.png" alt="image of the recipe"></div><!--you need the image -->
            <div class="Ingredients w-[375px] h-[678px] p-[35px] left-[1282px] top-[295px] absolute rounded-[15px] border border-[#ffd633] flex-col justify-start items-start gap-[35px] inline-flex">
                <div class="Frame27 self-stretch h-[280px] flex-col justify-start items-start gap-[15px] flex">
                <div class="Ingredients w-[137px] text-[#fefefe] text-2xl font-medium font-['Poppins'] capitalize">ingredients</div>
                <div class="FirstSecondThirdForthFifthSixth self-stretch opacity-80 text-[#fefefe] text-xl font-normal font-['Poppins'] capitalize">First<br/>Second<br/>Third<br/>Forth<br/>Fifth<br/>Sixth...</div>
                </div>
            </div>
            <div class="Procedure w-[950px] h-[496px] p-[35px] left-[252px] top-[685px] absolute rounded-[15px] border border-[#ffd633] flex-col justify-start items-start gap-[35px] inline-flex">
                <div class="Frame27 self-stretch h-[426px] flex-col justify-start items-start gap-[15px] flex">
                <div class="Procedure w-[137px] text-[#fefefe] text-2xl font-medium font-['Poppins'] capitalize">Procedure</div>
                <div class="FirstYouDoThisSecondThenYouDoThisThirdThenYouDoThisForthThenYouDoThisFifthThenYouDoThisSixthAtTheEndYouDoThis self-stretch h-[375px] opacity-80 text-[#fefefe] text-xl font-normal font-['Poppins'] capitalize">First you do This...<br/>Second Then you do this...<br/>Third Then you do this...<br/>Forth Then you do this...<br/>Fifth Then you do this...<br/>Sixth At the end you do this...</div>
                </div>
            </div>
            <div class="StarUndefined w-[50px] h-[50px] left-[1297px] top-[1121px] absolute"><img src="slike/star.png" alt="star"></div>
            <div class="TitleNormal w-[103px] h-12 left-[1382px] top-[1122px] absolute">
                <div class="HeaderNormal left-0 top-0 absolute text-white text-[32px] font-medium font-['Poppins'] capitalize">4.5 / 5</div>
            </div>
            <div class="ButtonVariant2 w-[113px] h-[42px] px-5 py-2.5 left-[1528px] top-[1125px] absolute bg-[#ffd633] rounded-[100px] flex items-center justify-center">
                <div class="Submit text-[#010012] text-xl font-normal font-['Poppins'] capitalize">Submit</div>
            </div>
        </div>
    </div>
  </div>
  <div class="mobile-view">
    <div class="YummiesRecipesPhoneItem w-[360px] h-[1040px] relative bg-[#99431f]">
        <?php include 'phone-header.php'; //header ?>
        <div class="Group28 w-[272px] h-[762.68px] left-[43px] top-[114px] absolute">
            <div class="Frame28 w-[272px] h-[207.68px] p-[23.75px] left-0 top-[555px] absolute rounded-[10.18px] border border-[#ffd633] flex-col justify-start items-start gap-[23.75px] inline-flex">
            <div class="Frame29 self-stretch h-[160.18px] flex-col justify-start items-start gap-[10.18px] flex">
                <div class="Procedure w-[254.46px] text-[#fefefe] text-base font-medium font-['Poppins'] capitalize">Procedure</div>
                <div class="FirstYouDoThisSecondThenYouDoThisThirdThenYouDoThisForthThenYouDoThisFifthThenYouDoThisSixthAtTheEndYouDoThis self-stretch opacity-80 text-[#fefefe] text-sm font-normal font-['Poppins'] capitalize">First you do This...<br/>Second Then you do this...<br/>Third Then you do this...<br/>Forth Then you do this...<br/>Fifth Then you do this...<br/>Sixth At the end you do this...</div>
            </div>
            </div>
            <div class="Frame27 w-[272px] h-[207.68px] p-[23.75px] left-0 top-[333px] absolute rounded-[10.18px] border border-[#ffd633] flex-col justify-start items-start gap-[23.75px] inline-flex">
            <div class="Frame29 self-stretch h-[160.18px] flex-col justify-start items-start gap-[10.18px] flex">
                <div class="Ingredients w-[254.46px] text-[#fefefe] text-base font-medium font-['Poppins'] capitalize">Ingredients</div>
                <div class="FirstSecondThirdForthFifthSixth self-stretch opacity-80 text-[#fefefe] text-sm font-normal font-['Poppins'] capitalize">First<br/>Second<br/>Third<br/>Forth<br/>Fifth<br/>Sixth...</div>
            </div>
            </div>
            <div class="Images w-[270px] h-[215px] left-0 top-0 absolute bg-[#c4c4c4] rounded-[10px]"><img src="slike/image.png" alt="image of the recipe"></div>
            <div class="Title w-[232.33px] h-[90px] left-[18.84px] top-[229px] absolute text-[#fefefe] text-xl font-bold font-['Poppins'] capitalize">Title<br/><br/></div>
        </div>
        <div class="StarUndefined w-[38.50px] h-[38.50px] left-[109px] top-[916px] absolute"><img src="slike/star.png" alt="star"></div>
        <div class="TitleNormal w-[82.40px] h-[38.40px] left-[169px] top-[917px] absolute">
            <div class="HeaderNormal left-0 top-0 absolute text-white text-[25.60px] font-medium font-['Poppins'] capitalize">4.5 / 5</div>
        </div>
        <div class="PhoneButtonVariant2 w-[141.75px] h-[42px] px-[9.51px] py-[4.76px] left-[109px] top-[968px] absolute bg-[#ffd633] rounded-[10.50px] flex items-center justify-center">
            <div class="Button text-center text-[#010012] text-sm font-normal font-['Poppins'] capitalize">Submit</div>
        </div>
    </div>
  </div>
  <script src="js/phone-menu.js"></script>
</body>
</html>