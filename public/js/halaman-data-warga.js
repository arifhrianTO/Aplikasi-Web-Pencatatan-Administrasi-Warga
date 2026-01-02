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

  function openPopup(nik) {
    document.getElementById("myModal").style.display = "flex";
    document.getElementById("nikInput").value = nik;
  }

  document.querySelector(".close").onclick = function() { 
    document.getElementById("myModal").style.display = "none"; 
  };

  document.getElementById("btnTidak").onclick = function () {
    document.getElementById("myModal").style.display = "none";
  };

  document.getElementById("hapusForm").onsubmit = function (e) {
    let alasan = document.getElementById("alasanSelect").value;

    if (alasan === "") {
      e.preventDefault();
      alert("Silahkan pilih alasan terlebih dahulu!");
      return;
    }

    document.getElementById("alasanInput").value = document.getElementById("alasanSelect").value;
  };

