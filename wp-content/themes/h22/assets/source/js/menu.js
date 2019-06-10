var mobileMenu = document.querySelector('.c-header-mobile');
var mobileMenuTrigger = document.querySelector('.c-header-mobile__menu-trigger');
var mobileMenuTriggerIcon = document.querySelector('.c-header-mobile__menu-icon');


mobileMenuTrigger.addEventListener('click', function(e) {

  var mobileMenuItems = document.querySelector('.c-header-mobile__bottom');

  mobileMenuItems.classList.toggle('hidden');

  if(!mobileMenuItems.classList.contains('hidden')) {
    mobileMenu.classList.add('c-header-mobile--open');
    mobileMenuTriggerIcon.classList.add('c-header-mobile__menu-icon--close');
  } else {
    mobileMenu.classList.remove('c-header-mobile--open');
    mobileMenuTriggerIcon.classList.remove('c-header-mobile__menu-icon--close');
  }
});
