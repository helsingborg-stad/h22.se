import objectFitVideos from 'object-fit-videos';
import objectFitImages from 'object-fit-images';

import './menu.js';
import './video-popup';
import './vc-tta-section';
import './smoothScroll';




window.addEventListener('DOMContentLoaded', function(event) {
  objectFitVideos();
  objectFitImages(false, {
    watchMQ: true,
    skipTest: false
  });
});


