function truncateText(className) {
    var elements = document.getElementsByClassName(className);
    for (var i = 0; i < elements.length; i++) {
      var element = elements[i];
      var maxWidth = element.getAttribute('data-max-width');
      if (maxWidth) {
        element.style.maxWidth = maxWidth + 'px';
        element.title = element.innerText;
      }
    }
  }

  window.addEventListener('DOMContentLoaded', function() {
    truncateText('truncate');
    truncateText('truncateEmail');
    truncateText('truncateOthers');
    truncateText('truncateAddress');
  });