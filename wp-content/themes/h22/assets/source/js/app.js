import objectFitVideos from 'object-fit-videos';
import objectFitImages from 'object-fit-images';
import dropdownComponents from './dropdown';
import smoothScroll from './smoothScroll';
import socialShare from './socialShare';

import './menu.js';
import './video-popup';
import './vc-tta-section';




window.addEventListener('DOMContentLoaded', function(event) {
  smoothScroll();
  dropdownComponents();
  objectFitVideos();
  objectFitImages(false, {
    watchMQ: true,
    skipTest: false
  });
  socialShare();
});


