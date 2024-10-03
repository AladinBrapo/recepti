document.getElementById('menu-toggle').addEventListener('click', function (event) {
  console.log("Menu toggle clicked");
  
  const menu = document.getElementById('side-menu');
  if (menu.classList.contains('hidden-menu')) {
      console.log("Opening menu");
      menu.classList.remove('menu-slide-in');
      menu.classList.add('menu-slide-out');
      menu.classList.remove('hidden-menu');
      
      // Prevent the click event from propagating to the document click listener
      event.stopPropagation();
      
      // Add click outside event listener
      document.addEventListener('click', closeMenuOnClickOutside);
  }
});

document.getElementById('menu-close').addEventListener('click', function () {
  console.log("Menu close button clicked");
  closeMenu();
});

function closeMenu() {
  console.log("Closing menu");
  const menu = document.getElementById('side-menu');
  menu.classList.remove('menu-slide-out');
  menu.classList.add('menu-slide-in');
  
  setTimeout(() => {
      console.log("Menu is now hidden");
      menu.classList.add('hidden-menu');
  }, 300);
  
  // Remove the outside click event listener
  document.removeEventListener('click', closeMenuOnClickOutside);
}

function closeMenuOnClickOutside(event) {
  console.log("Checking if click is outside menu");
  
  const menu = document.getElementById('side-menu');
  const menuToggle = document.getElementById('menu-toggle');

  // Close menu if click happens outside the menu and not on the toggle button
  if (!menu.contains(event.target) && !menuToggle.contains(event.target)) {
      console.log("Click was outside, closing menu");
      closeMenu();
  }
}

document.getElementById('side-menu').addEventListener('click', function(event) {
  console.log("Click inside the menu");
  event.stopPropagation();
});

document.addEventListener('DOMContentLoaded', function() {
const categoriesBtn = document.getElementById('categories-btn');
const categoriesList = document.getElementById('categories-list');
const arrowIcon = document.getElementById('arrow-icon');

const homeBtn = document.getElementById('home-btn');
const popularBtn = document.getElementById('popular-btn');
const submitBtn = document.getElementById('submit-btn');
const searchBtn = document.getElementById('search-btn');

let isOpen = false;

categoriesBtn.addEventListener('click', function() {
  isOpen = !isOpen;

  if (isOpen) {
    categoriesList.classList.remove('hidden');
    arrowIcon.classList.add('rotate-180');
    categoriesList.style.top = '310px';
    slimButton(categoriesBtn, '245px');
    slimButton(homeBtn, '180px');
    slimButton(popularBtn, '608px');
    slimButton(submitBtn, '673px');
    slimButton(searchBtn, '738px');
  } else {
    categoriesList.classList.add('hidden');
    arrowIcon.classList.remove('rotate-180');
    categoriesList.style.top = '390px';
    restoreButton(categoriesBtn, '305px');
    restoreButton(homeBtn, '180px');
    restoreButton(popularBtn, '430px');
    restoreButton(submitBtn, '555px');
    restoreButton(searchBtn, '680px');
  }
});

function slimButton(button, topPosition) {
  button.style.top = topPosition;
  button.style.height = '40px';
  const buttonText = button.querySelector('.PopularRecipes');
  if (buttonText) {
    buttonText.style.top = '5px';
    buttonText.style.fontSize = '18px';
  }
}

function restoreButton(button, topPosition) {
  button.style.top = topPosition;
  button.style.height = '78px';
  const buttonText = button.querySelector('.PopularRecipes');
  if (buttonText) {
    buttonText.style.top = '24.70px';
    buttonText.style.fontSize = '21.77px';
  }
}
});
