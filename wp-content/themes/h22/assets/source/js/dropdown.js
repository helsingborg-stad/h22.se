export default () => {
  const toggleElements = document.querySelectorAll(".js-dropdown");
  toggleElements.forEach(function (element) {
    const toggleClass = e => {
      e.preventDefault();
      element.classList.toggle('is-active');
    };
    
    const dropdownToggleAttribute = element.getAttribute('data-dropdown-toggle');

    let dropdownToggle = false;

    if (dropdownToggleAttribute) {
      const toggleElements = element.querySelectorAll(dropdownToggleAttribute);
      dropdownToggle = toggleElements.length > 0 ? toggleElements[0] : false;
    }

    if (!dropdownToggle && element.children.length > 0) {
      const defaultToggleElements = element.querySelectorAll('.c-dropdown__toggle');
      dropdownToggle = defaultToggleElements.length > 0 ? defaultToggleElements[0] : false;
    }

    if (dropdownToggle) {
      dropdownToggle.addEventListener('click', toggleClass);
      dropdownToggle.addEventListener('touchstart', toggleClass);
    }
  });
}
