
export default () => {
  Object.values(document.querySelectorAll('a[href^="#"]')).forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
  
        // if (this.getAttribute('href') === '#') {
        //   return;
        // }
  
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
  })
}
