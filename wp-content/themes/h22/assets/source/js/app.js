import objectFitVideos from 'object-fit-videos';
import objectFitImages from 'object-fit-images';

import './menu.js';
import './video-popup';
import './vc-tta-section';

objectFitVideos();
objectFitImages();

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});