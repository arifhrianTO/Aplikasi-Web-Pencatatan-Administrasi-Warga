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

function toggleDropdownA() {
      const content = document.getElementById(formContent);
      const arrow = document.getElementById(arrow1);

      if (formContent.style.display === "none") {
        formContent.style.display = "block";
        arrow1.textContent = "expand_less";
      } else {
        formContent.style.display = "none";
        arrow1.textContent = "expand_more";
      }
    }


function toggleDropdownB() {
      const content = document.getElementById(statusContent);
      const arrow = document.getElementById(arrow2);

      if (statusContent.style.display === "block") {
        statusContent.style.display = "none";
        arrow2.textContent = "expand_more";
      } else {
        statusContent.style.display = "block";
        arrow2.textContent = "expand_less";
      }
    }    

  