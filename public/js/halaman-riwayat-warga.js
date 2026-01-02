function toggleProfile() {
      const popup = document.getElementById('profilePopup');
      popup.style.display = (popup.style.display === 'block') ? 'none' : 'block';
    }

    window.onclick = function(e) {
      const popup = document.getElementById('profilePopup');
      if (!e.target.closest('.profile-container')) {
        popup.style.display = 'none';
      }
    }

     function toggleSidebar() {
      document.getElementById("sidebar").classList.toggle("closed");
      document.getElementById("sidebar").classList.toggle("open");
    }

function toggleDropdown(contentId, arrowId) {
      const content = document.getElementById(contentId);
      const arrow = document.getElementById(arrowId);

      if (content.style.display === "block") {
        content.style.display = "none";
        arrow.textContent = "expand_more";
      } else {
        content.style.display = "block";
        arrow.textContent = "expand_less";
      }
    }