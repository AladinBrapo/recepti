// Preprosta animacija odpiranja in zapiranja menija
document.getElementById('menu-toggle').addEventListener('click', function () {
    const menu = document.getElementById('side-menu');
    menu.classList.remove('menu-slide-in');
    menu.classList.add('menu-slide-out');
    menu.classList.remove('hidden-menu');
});

document.getElementById('menu-close').addEventListener('click', function () {
    const menu = document.getElementById('side-menu');
    menu.classList.remove('menu-slide-out');
    menu.classList.add('menu-slide-in');
    setTimeout(() => {
        menu.classList.add('hidden-menu');
    }, 300); // Enako kot trajanje animacije v CSS (0.3s)
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

    // Toggle the dropdown height and reposition buttons
    if (isOpen) {
      categoriesList.classList.remove('hidden');
      
      arrowIcon.classList.add('rotate-180');  // Rotate the arrow up

      // Adjust positions and slim down buttons:
      categoriesList.style.top = '310px';

      slimButton(categoriesBtn, '245px');
      slimButton(homeBtn, '180px');  // Slim down the Home button
      slimButton(popularBtn, '608px');  // Slim down Popular Recipes
      slimButton(submitBtn, '673px');  // Slim down Submit Your Recipe
      slimButton(searchBtn, '738px');  // Slim down Search

    } else {
      categoriesList.classList.add('hidden');
      
      arrowIcon.classList.remove('rotate-180');  // Rotate the arrow down

      // Restore default positions and size
      categoriesList.style.top = '390px';

      restoreButton(categoriesBtn, '305px');
      restoreButton(homeBtn, '180px');  // Restore Home button size
      restoreButton(popularBtn, '430px');  // Restore Popular Recipes
      restoreButton(submitBtn, '555px');  // Restore Submit Your Recipe
      restoreButton(searchBtn, '680px');  // Restore Search button
    }
  });

  // Function to slim down buttons
  function slimButton(button, topPosition) {
    button.style.top = topPosition;
    button.style.height = '40px';  // Slim height
    const buttonText = button.querySelector('.PopularRecipes');
    if (buttonText) {
      buttonText.style.top = '5px';  // Adjust text position to center in slim button
      buttonText.style.fontSize = '18px';  // Optionally adjust font size
    }
  }

  // Function to restore buttons to their original size
  function restoreButton(button, topPosition) {
    button.style.top = topPosition;
    button.style.height = '78px';  // Original height
    const buttonText = button.querySelector('.PopularRecipes');
    if (buttonText) {
      buttonText.style.top = '24.70px';  // Restore original text position
      buttonText.style.fontSize = '21.77px';  // Restore original font size
    }
  }
});