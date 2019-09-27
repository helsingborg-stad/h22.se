export default () => {
  const toggleElements = document.querySelectorAll(".js-dropdown");
  toggleElements.forEach(function (element) {

    const hideOnClickOutside = e => {
      if (!element.contains(e.target)) {
        toggleClass();
      }
    }

    const toggleClass = e => {
      if (e) {
        e.preventDefault();
      }
      
      element.classList.toggle('is-active');

      if (Object.values(element.classList).includes('is-active')) {
        document.addEventListener('click', hideOnClickOutside);
      } else {
        document.removeEventListener('click', hideOnClickOutside)
      }
    };

    let dropdownToggle = false;

    const dropdownToggleAttribute = element.getAttribute('data-dropdown-toggle');
    if (dropdownToggleAttribute) {
      const toggleElements = element.querySelectorAll(dropdownToggleAttribute);
      dropdownToggle = toggleElements.length > 0 ? toggleElements[0] : false;
    }

    if (!dropdownToggle && element.children.length > 0) {
      const defaultToggleElements = element.querySelectorAll('.c-dropdown__toggle');
      dropdownToggle = defaultToggleElements.length > 0 ? defaultToggleElements[0] : false;
    }

    if (!dropdownToggle) {
      return;
    }    
      
    dropdownToggle.addEventListener('click', toggleClass);
  });
}
