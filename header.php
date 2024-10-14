<?php 
    include_once 'baza.php';
    include_once 'seja.php';
    
    // Enable error reporting
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    // Log errors to a specific file
    ini_set('log_errors', 1);
    ini_set('error_log', 'error.log');
    ?>
    
    <div class="Header w-[1465px] h-[50px] left-[227px] top-[66px] absolute justify-center items-center gap-[243.50px] inline-flex z-[1000]">
        <div class="Frame2 w-[203px] h-[50px] justify-start items-center gap-5 inline-flex">
            <a href="index.php">
            <div class="Frame17 w-[50px] h-[50px] bg-[#ffd633] rounded-[100px] justify-start items-center gap-2.5 flex">
                <img class="Yummies1 w-[50px] h-[50px] rounded-[25px]" src="../slike/yummies-logo.png" alt="yummies-logo" />
            </div>
            </a>
            <a href="index.php">
            <div class="Yummies text-[#fefefe] text-[28px] font-medium font-['Poppins'] capitalize">Yummies</div>
            </a>
        </div>
        <div class="Frame1 w-[740px] h-[27px] justify-between items-start inline-flex">
            <a href="index.php" class="Home text-[#fefefe] text-lg font-normal font-['Poppins'] capitalize">Home</a>
            <div class="relative group">
            <div class="Categories text-[#fefefe] text-lg font-normal font-['Poppins'] capitalize cursor-default">
                Categories
            </div>
            <div class="absolute left-1/2 -translate-x-1/2 mt-0 w-48 bg-[#99431f] text-white rounded-md shadow-lg hidden group-hover:block group-focus-within:block">
                <a href="search.php?cuisine=Italian" class="block px-4 py-2 text-sm text-center hover:text-[#ffd633]">Italian</a>
                <a href="search.php?cuisine=Mexican" class="block px-4 py-2 text-sm text-center hover:text-[#ffd633]">Mexican</a>
                <a href="search.php?cuisine=Indian" class="block px-4 py-2 text-sm text-center hover:text-[#ffd633]">Indian</a>
                <a href="search.php?cuisine=Asian" class="block px-4 py-2 text-sm text-center hover:text-[#ffd633]">Asian</a>
                <a href="search.php?cuisine=Mediterranean" class="block px-4 py-2 text-sm text-center hover:text-[#ffd633]">Mediterranean</a>
                <a href="search.php?cuisine=American" class="block px-4 py-2 text-sm text-center hover:text-[#ffd633]">American</a>
            </div>
            </div>
            <a href="search.php" class="TrendingRecipes text-[#fefefe] text-lg font-normal font-['Poppins'] capitalize">Trending Recipes</a>
            <a href="submit_your_recipe.php" class="SubmitYourRecipe text-[#fefefe] text-lg font-normal font-['Poppins'] capitalize">Submit your Recipe</a>
            <a href="search.php" class="Search text-[#fefefe] text-lg font-normal font-['Poppins'] capitalize">Search</a>
        </div>
        <div class="AccountCircle w-[35px] h-[35px] relative">
            
            <?php
                if (isset($_SESSION['log'])) {
                    $i = $_SESSION['im'];
                    $p = $_SESSION['pr'];
                    echo '<a href="your_recipes.php" class="BoundingBox w-[35px] h-[35px] left-0.5 top-0.5 absolute bg-[#99431f]">
                            <img src="../slike/account_circle.png" alt="user-circle">
                        </a>'; 
                } else {
                    echo '<a href="login.php" class="BoundingBox w-[35px] h-[35px] left-0.5 top-0.5 absolute bg-[#99431f]">
                            <img src="../slike/account_circle.png" alt="user-circle">
                        </a>';
                }
            ?>
        </div>
        
            <?php
                if (isset($_SESSION['log'])) {
                    $i = $_SESSION['im'];
                    $p = $_SESSION['pr'];
                    echo '
                    <a href="logout.php" class="ButtonVariant2 w-[77.86px] h-[30px] px-[14.29px] py-[7.14px] left-[1337px] top-[10px] absolute bg-[#ffd633] rounded-[71.43px] flex items-center justify-center">
                    <div class="Button text-[#010012] text-[15px] font-normal font-['.'Poppins'.'] capitalize">
                    Logout
                    </div></a>'; 
                } else {
                    echo '
                    <a href="login.php" class="ButtonVariant2 w-[77.86px] h-[30px] px-[14.29px] py-[7.14px] left-[1337px] top-[10px] absolute bg-[#ffd633] rounded-[71.43px] flex items-center justify-center">
                    <div class="Button text-[#010012] text-[15px] font-normal font-['.'Poppins'.'] capitalize">
                    Login
                    </div></a>';
                }
            ?>
        
    </div>