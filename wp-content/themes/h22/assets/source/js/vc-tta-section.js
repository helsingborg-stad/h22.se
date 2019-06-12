function setupTabs(tabList) {
  let header = tabList.querySelector('.c-tabs__header');
  let sections = tabList.querySelectorAll('.c-tabs__content');

  Array.from(sections).forEach((section, index) => {
    let sectionId = section.id;
    let sectionTitle = section.querySelector('.c-tabs__title');
    sectionTitle.style.display = "none";

    if (index != 0) {
      section.setAttribute('aria-hidden', 'true');
    }

    let button = document.createElement('button');
    button.setAttribute('role', 'tab');
    button.setAttribute('aria-controls', sectionId);
    button.setAttribute('aria-expanded', String(index === 0));
    button.setAttribute('js-expand-button', '');
    button.classList.add('c-tabs__button');
    button.innerHTML = `<span class="c-tabs__button-wrapper" tabindex="-1">${
      sectionTitle.innerText
    }</span>`;
    button.addEventListener('click', onTabButtonClick);

    header.appendChild(button);
  });
}

function onTabButtonClick(event) {
  event.preventDefault();
  let targetButton = event.currentTarget;
  let header = targetButton.parentNode;
  let tabList = header.parentNode;
  let sections = tabList.querySelectorAll('.c-tabs__content');

  Array.from(header.children).forEach((button, index) => {
    let buttonId = targetButton.getAttribute('aria-controls');
    button.setAttribute('aria-expanded', String(button === targetButton));

    Array.from(sections).forEach((section, index) => {
      section.setAttribute('aria-hidden', String(buttonId !== section.id));
    });
  });
}

window.addEventListener('load', () => {
  let tabLists = document.querySelectorAll('.c-tabs');
  Array.from(tabLists).forEach(tabList => {
    setupTabs(tabList);
  });
});
