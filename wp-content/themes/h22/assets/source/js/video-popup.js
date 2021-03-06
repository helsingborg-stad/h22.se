import getVideoId from 'get-video-id';

function getVideoUrl(url) {
  const { id, service } = getVideoId(url);
  switch (service) {
    case 'youtube':
      return `https://www.youtube.com/embed/${id}`;
    case 'vimeo':
      return `https://player.vimeo.com/video/${id}`;
  }
}

var popupContainer;

function openVideoPopup({ url }) {
  if (popupContainer) {
    popupContainer.parentNode.removeChild(popupContainer);
    popupContainer = null;
  }
  const videoUrl = getVideoUrl(url);
  if (!videoUrl) {
    return;
  }
  popupContainer = document.createElement('div');
  popupContainer.classList.add('c-video-popup');
  popupContainer.innerHTML = `
    <button type="button" class="c-video-popup__close-button js-close-video-popup">
      <i class="c-icon--close"></i>
    </button>
    <div class="c-video-popup__inner-1">
      <div class="c-video-popup__inner-2">
        <div class="c-video-popup__inner-3">
          <iframe
            class="c-video-popup__iframe"
            width="560"
            height="315"
            src="${videoUrl}"
            frameborder="0"
            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen
          ></iframe>
        </div>
      </div>
    </div>
  `;
  const closeButton = popupContainer.querySelector('.js-close-video-popup');
  closeButton.addEventListener('click', event => {
    event.preventDefault();
    popupContainer.parentNode.removeChild(popupContainer);
    popupContainer = null;
  });
  document.body.appendChild(popupContainer);
}

window.addEventListener('load', () => {
  Array.from(document.querySelectorAll('.js-open-video-popup')).forEach(
    button => {
      button.addEventListener('click', event => {
        event.preventDefault();
        openVideoPopup({ url: event.currentTarget.href });
      });
    },
  );
});
