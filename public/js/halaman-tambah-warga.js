function toggleProfile() {
  const popup = document.getElementById('profilePopup');
  popup.style.display = (popup.style.display === 'block') ? 'none' : 'block';
}

window.onclick = function (e) {
  const popup = document.getElementById('profilePopup');
  if (!e.target.closest('.profile-container')) {
    popup.style.display = 'none';
  }
}

function toggleSidebar() {
  document.getElementById("sidebar").classList.toggle("closed");
  document.getElementById("sidebar").classList.toggle("open");
}


document.getElementById('tanggal_lahir').addEventListener('change', function() {
    let tglLahir = new Date(this.value);
    let today = new Date();

    if (this.value === "") {
        document.getElementById('umur').value = "";
        return;
    }

    let umur = today.getFullYear() - tglLahir.getFullYear();
    let bulan = today.getMonth() - tglLahir.getMonth();
    let hari = today.getDate() - tglLahir.getDate();

    if (bulan < 0 || (bulan === 0 && hari < 0)) {
        umur--;
    }

    document.getElementById('umur').value = umur;
});


