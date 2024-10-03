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
    
    <div class="PhoneHeader w-80 h-11 left-[24px] top-[20px] absolute justify-center items-center gap-24 inline-flex">
        <div class="Frame2 self-stretch justify-start items-center gap-4 inline-flex">
            <a href="index.php">
            <div class="Frame17 w-11 h-11 bg-[#ffd633] rounded-3xl justify-start items-center gap-2 flex">
                <img class="Yummies1 w-11 h-11 rounded-3xl" src="../slike/yummies-logo.png" alt="yummies-logo" />
            </div>
            </a>
            <a href="index.php">
            <div class="Yummies text-[#fefefe] text-2xl font-medium font-['Poppins'] capitalize">Yummies</div>
            </a>
        </div>
        <div class="Frame1 w-8 h-8 justify-between items-start inline-flex">
            <button id="menu-toggle" class="LineHorizontal3UndefinedGlyphUndefined w-7 h-7 px-0.5 py-1.5 justify-center items-center flex">
                <img src="../slike/Menu-phone.png" alt="Menu-phone" />
            </button>
        </div>
    </div>
    <!-- Menu-->
    <div id="side-menu" class="PhoneMenu hidden-menu fixed top-0 right-0 w-[280px] h-screen bg-[#ff7033] z-50">
        <div class="PhoneMenuComponent1PhoneHeader w-[266px] h-[50px] left-0 top-[17px] absolute">
            <a href="index.php">
            <div class="Frame2 left-[20px] top-[6px] absolute flex gap-[18px]">
                <div class="Yummies text-[#fefefe] text-[25px] font-medium font-['Poppins'] capitalize">Yummies</div>
            </div>
            </a>
            <div class="Frame1 w-[26px] h-[33px] absolute right-0 top-[9px]">
                <button id="menu-close" class="w-8 h-8 flex justify-center items-center">
                    <img src="../slike/Menu-phone.png" alt="Menu-phone" />
                </button>
            </div>
        </div>
    
        <!-- Home Button -->
        <a href="index.php">
        <div id="home-btn" class="PhoneBigButtonVariant w-[247px] h-[78px] left-[16px] top-[180px] absolute bg-[#ffd633] rounded-2xl border border-[#fefefe] flex justify-center items-center">
            <div class="text-[#010012] text-[21.77px] font-normal font-['Poppins'] capitalize">Home</div>
        </div>
        </a>
        
        <!-- Categories Button -->
        <div id="categories-btn" class="PhoneBigButtonVariant w-[247px] h-[78px] left-[16px] top-[305px] absolute bg-[#ffd633] rounded-2xl border border-[#fefefe] flex justify-between items-center px-6 cursor-pointer">
            <div class="text-[#010012] text-[21px] font-normal capitalize">Categories</div>
            <img id="arrow-icon" src="../slike/arrow-down.png" alt="arrow-down" class="transition-transform">
        </div>
    
        <!-- Categories List (initially hidden) -->
        <ul id="categories-list" class="hidden w-[247px] mx-auto bg-[#ff7033] transition-all duration-300 ease-in-out overflow-hidden absolute left-[16px] top-[390px] rounded-2xl border border-[#fefefe] list-disc">
            <li class="text-[#fefefe] text-xl font-normal capitalize py-2 px-4">Italian</li>
            <li class="text-[#fefefe] text-xl font-normal capitalize py-2 px-4">Mexican</li>
            <li class="text-[#fefefe] text-xl font-normal capitalize py-2 px-4">Indian</li>
            <li class="text-[#fefefe] text-xl font-normal capitalize py-2 px-4">Asian</li>
            <li class="text-[#fefefe] text-xl font-normal capitalize py-2 px-4">Mediterranean</li>
            <li class="text-[#fefefe] text-xl font-normal capitalize py-2 px-4">American</li>
        </ul>
    
        <!-- Other buttons -->
        <a href="search.php">
            <div id="popular-btn" class="PhoneBigButtonVariant w-[247px] h-[78px] left-[16px] top-[430px] absolute bg-[#ffd633] rounded-2xl border border-[#fefefe] flex justify-center items-center">
                <div class="text-[#010012] text-[21.77px] font-normal font-['Poppins'] capitalize">Popular recipes</div><!-- search.php/... Fix -->
            </div>
        </a>
        <a href="submit_your_recipe.php">
            <div id="submit-btn" class="PhoneBigButtonVariant w-[247px] h-[78px] left-[16px] top-[555px] absolute bg-[#ffd633] rounded-2xl border border-[#fefefe] flex justify-center items-center">
                <div class="text-[#010012] text-[21.77px] font-normal font-['Poppins'] capitalize">Submit Your Recipe</div>
            </div>
        </a>
        <a href="search.php">
            <div id="search-btn" class="PhoneBigButtonVariant w-[247px] h-[78px] left-[16px] top-[680px] absolute bg-[#ffd633] rounded-2xl border border-[#fefefe] flex justify-center items-center">
                <div class="text-[#010012] text-[21.77px] font-normal font-['Poppins'] capitalize">Search</div><!-- search.php/... Fix -->
            </div>
        </a>
        
        
        
        <!-- Account Icon -->
        <div class="AccountCircle w-10 h-10 left-[213px] top-[93px] absolute">
            <?php
                if (isset($_SESSION['log'])) {
                    $i = $_SESSION['im'];
                    $p = $_SESSION['pr'];
                    echo '<a href="logout.php" class="BoundingBox w-[35px] h-[35px] left-0 top-1 absolute">
                            <img src="../slike/account_circle.png" alt="user-circle">
                          </a>'; 
                } else {
                    echo '<a href="login.php" class="BoundingBox w-[35px] h-[35px] left-0 top-1 absolute">
                            <img src="../slike/account_circle.png" alt="user-circle">
                          </a>';
                }
            ?>
        </div>
        
        <!-- Login Button -->
        <?php
            if (isset($_SESSION['log'])) {
                $i = $_SESSION['im'];
                $p = $_SESSION['pr'];
                echo '
                <a href="logout.php" class="PhoneSmallButtonVariant2 w-[150px] h-10 px-[12.38px] py-[6.19px] left-[17.24px] top-[93px] absolute bg-[#ffd633] rounded-[13px] items-center">
                <div class="Button text-center text-[#010012] pt-1.5 text-xs font-normal font-['.'Poppins'.'] capitalize">
                Logout
                </div></a>'; 
            } else {
                echo '
                <a href="login.php" class="PhoneSmallButtonVariant2 w-[150px] h-10 px-[12.38px] py-[6.19px] left-[17.24px] top-[93px] absolute bg-[#ffd633] rounded-[13px] items-center">
                <div class="Button text-center text-[#010012] pt-1.5 text-xs font-normal font-['.'Poppins'.'] capitalize">
                Login
                </div></a>';
            }
        ?>
        
    </div>