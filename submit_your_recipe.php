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
            <div class="TitleNormal w-[314px] h-12 left-[252px] top-[207px] absolute">
                <div class="HeaderNormal left-0 top-0 absolute text-white text-[32px] font-medium font-['Poppins'] capitalize">Submit your Recipe</div>
            </div>
            <div class="Group27 w-[736px] h-[804px] left-[608px] top-[337px] absolute">
                <div class="TitleNormal w-[195px] h-9 left-0 top-0 absolute">
                <div class="NameOfRecipe left-0 top-0 absolute text-white text-2xl font-medium font-['Poppins'] capitalize">Name of Recipe</div>
                </div>
                <div class="TitleNormal w-[137px] h-9 left-0 top-[96px] absolute">
                <div class="Ingredients left-0 top-0 absolute text-white text-2xl font-medium font-['Poppins'] capitalize">Ingredients</div>
                </div>
                <div class="Frame427320862 w-[340px] h-10 left-0 top-[36px] absolute bg-white rounded-sm shadow border border-black"></div>
                <div class="Frame427320863 w-[736px] h-[199px] left-0 top-[132px] absolute bg-white rounded-sm shadow border border-black"></div>
                <div class="TitleNormal w-[124px] h-9 left-0 top-[351px] absolute">
                <div class="Procedure left-0 top-0 absolute text-white text-2xl font-medium font-['Poppins'] capitalize">Procedure</div>
                </div>
                <div class="Frame427320864 w-[736px] h-[206px] left-0 top-[387px] absolute bg-white rounded-sm shadow border border-black"></div>
                <div class="TitleNormal w-[84px] h-9 left-0 top-[613px] absolute">
                <div class="Picture left-0 top-0 absolute text-white text-2xl font-medium font-['Poppins'] capitalize">Picture</div>
                </div>
                <div class="Frame427320865 w-[736px] h-[57px] left-0 top-[649px] absolute bg-white rounded-sm shadow border border-black"></div>
                <div class="ButtonVariant2 w-[298px] h-[42px] px-5 py-2.5 left-[202px] top-[762px] absolute bg-[#ffd633] rounded-[100px] justify-between items-center inline-flex">
                <img class="Yummies2 w-[30px] h-[30px] rounded-[30.48px]" src="../slike/button-logo.png" alt="button-logo"/>
                <div class="Button text-[#010012] text-xl font-normal font-['Poppins'] capitalize">Submit</div>
                <div class="ArrowForward w-6 h-6 relative">
                <div class="BoundingBox w-[17px] h-[17px] left-1 top-1 absolute"><img src="../slike/arrow_forward.png" alt="arrow_forward"></div>
                </div>
                </div>
                <div class="TitleNormal w-[212px] h-9 left-[396px] top-0 absolute">
                <div class="SmallDescription left-0 top-0 absolute text-white text-2xl font-medium font-['Poppins'] capitalize">Small Description</div>
                </div>
                <div class="Frame427320866 w-[340px] h-10 left-[396px] top-[36px] absolute bg-white rounded-sm shadow border border-black"></div>
            </div>
        </div>
    </div>
  </div>
  <div class="mobile-view">
    <div class="YummiesRecipesPhoneSearch w-[360px] h-[800px] relative bg-[#99431f]">
        <?php include 'phone-header.php'; //header ?>
        <div class="PhoneButtonVariant2 w-[141.75px] h-[42px] px-[9.51px] py-[4.76px] left-[109px] top-[678px] absolute bg-[#ffd633] rounded-[10.50px] flex items-center justify-center">
            <div class="Button text-center text-[#010012] text-sm font-normal font-['Poppins'] capitalize">Submit</div>
        </div>
        <div class="Form w-[232px] h-[444.94px] left-[64px] top-[178px] absolute">
            <div class="Frame427320864 w-[232px] h-[40.94px] left-0 top-[40px] absolute bg-white rounded-sm shadow border border-black"></div>
            <div class="Frame427320865 w-[232px] h-[40.94px] left-0 top-[131px] absolute bg-white rounded-sm shadow border border-black"></div>
            <div class="Frame427320866 w-[232px] h-[40.94px] left-0 top-[222px] absolute bg-white rounded-sm shadow border border-black"></div>
            <div class="Frame427320867 w-[232px] h-[40.94px] left-0 top-[313px] absolute bg-white rounded-sm shadow border border-black"></div>
            <div class="Frame427320868 w-[232px] h-[40.94px] left-0 top-[404px] absolute bg-white rounded-sm shadow border border-black"></div>
            <div class="NameOfRecipe w-[173px] left-0 top-0 absolute text-[#fefefe] text-xl font-normal font-['Poppins'] capitalize">Name Of Recipe</div>
            <div class="SmallDescription w-[184px] left-0 top-[91px] absolute text-[#fefefe] text-xl font-normal font-['Poppins'] capitalize">Small Description</div>
            <div class="Ingredients w-[122px] left-0 top-[182px] absolute text-[#fefefe] text-xl font-normal font-['Poppins'] capitalize">Ingredients</div>
            <div class="Procedure w-28 left-0 top-[273px] absolute text-[#fefefe] text-xl font-normal font-['Poppins'] capitalize">Procedure</div>
            <div class="Picture w-[88px] left-0 top-[364px] absolute text-[#fefefe] text-xl font-normal font-['Poppins'] capitalize">Picture</div>
        </div>
        <div class="TitleNormal w-[228px] h-[34px] left-[66px] top-[105px] absolute">
            <div class="HeaderNormal left-0 top-0 absolute text-white text-[22.98px] font-medium font-['Poppins'] capitalize">Submit Your Recipe</div>
        </div>
    </div>
  </div>
  <script src="js/phone-menu.js"></script>
</body>
</html>