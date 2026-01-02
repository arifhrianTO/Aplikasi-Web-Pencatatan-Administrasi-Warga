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

 function openTolakModal(idSurat) {   
    document.getElementById("idSuratTolak").value = idSurat; 
    document.getElementById("modalTolak").style.display = "flex";
  }

  document.querySelector(".close").onclick = function() { 
    document.getElementById("modalTolak").style.display = "none"; 
  };

  document.getElementById("btnTidak").onclick = function () {
    document.getElementById("modalTolak").style.display = "none";
  };

  document.getElementById("ya").onclick = function (e) {
    let alasan = document.getElementById("alasan").value;

    if (alasan === "") {
      e.preventDefault();
      alert("Silahkan pilih alasan terlebih dahulu!");
      return;
    }
  };


