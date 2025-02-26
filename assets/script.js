
// Search Area
const searchIcon = document.getElementById('searchIcon');
const searchInput = document.getElementById('searchInput');

// Open or close the box when clicking on the search icon
searchIcon.addEventListener('click', function () {
  searchInput.classList.toggle('open');
  if (searchInput.classList.contains('open')) {
    searchInput.focus(); // Focuses when search box is opened
    searchInput.style.width = '200px'; // Adjust width
  } else {
    searchInput.style.width = '0'; // Reset width on close
  }
});

// Close the box when the mouse moves out of the box
searchInput.addEventListener('mouseout', function () {
  searchInput.classList.remove('open');
  searchInput.style.width = '0'; // Reset width
});

// Close the search box when exiting the input field (blur event)
searchInput.addEventListener('blur', function () {
  searchInput.classList.remove('open');
  searchInput.style.width = '0'; // Reset width
});




// Social Media Share
jQuery(document).ready(function($) {
  $('.social-icon').on('click', function(e) {
      e.preventDefault();
      
      var url = $(this).data('url');
      var title = $(this).data('title');
      var socialMedia = $(this).attr('class').split(' ')[1];

      switch(socialMedia) {
          case 'facebook':
              window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(url), '_blank');
              break;
          case 'twitter':
              window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(url) + '&text=' + encodeURIComponent(title), '_blank');
              break;
          case 'linkedin':
              window.open('https://www.linkedin.com/shareArticle?mini=true&url=' + encodeURIComponent(url) + '&title=' + encodeURIComponent(title), '_blank');
              break;
              case 'whatsapp':
                window.open('https://api.whatsapp.com/send?text=' + encodeURIComponent(title + ' ' + url), '_blank');
                break;
              case 'email':
                window.location.href = 'mailto:?subject=' + encodeURIComponent(title) + '&body=' + encodeURIComponent(url);
                break;
          case 'link':
              navigator.clipboard.writeText(url).then(function() {
                  alert('Link copied to clipboard!');
              });
              break;
          default:
              break;
      }
  });
});







