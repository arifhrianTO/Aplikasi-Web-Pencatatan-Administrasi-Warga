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

    //tambah
   const openPopup = document.getElementById('openPopup');
    const closePopup = document.getElementById('closePopup');
    const popupOverlay = document.getElementById('popupOverlay');
    const formTambah = document.getElementById('formTambah');

    // Buka popup
    openPopup.addEventListener('click', () => {
      popupOverlay.classList.add("active");
    });

    // Tutup popup
    closePopup.addEventListener('click', () => {
      popupOverlay.classList.remove("active");
      formTambah.reset();
    });

    // Klik di luar popup
    popupOverlay.addEventListener('click', (e) => {
      if (e.target === popupOverlay) {
        popupOverlay.classList.remove("active");
        formTambah.reset();
      }
    })

    //update
    function openUpdate(button) {
    const row = button.closest('tr');
    const cells = row.getElementsByTagName('td');

    document.getElementById('idAkunUpdate').value = row.dataset.id;
    document.getElementById('nikUpdate').value = cells[1].innerText;
    document.getElementById('usernameUpdate').value = cells[2].innerText;

    document.getElementById('updatePopup').classList.add('active');
}

function closeUpdate() {
    document.getElementById('updatePopup').classList.remove('active');
}


    //hapus
    // Buka popup hapus
    function openDelete(nik) {
    document.getElementById('deleteNIK').value = nik;
    document.getElementById('confirmDelete').checked = false;

    document.getElementById('deleteOverlay').classList.add('active');
}
    function closeDelete() {
    document.getElementById('deleteOverlay').classList.remove('active');
}
    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
    const isChecked = document.getElementById('confirmDelete').checked;

    if (!isChecked) {
        alert("Silakan centang 'Saya yakin' sebelum menghapus.");
        return;
    }

    const nik = document.getElementById('deleteNIK').value;

    // Arahkan ke file PHP untuk hapus data
    window.location.href = "../../controllers/akun/hapus-akun-warga.php?nik=" + nik;
});


  function toggleSidebar() {
      document.getElementById("sidebar").classList.toggle("closed");
      document.getElementById("sidebar").classList.toggle("open");
    }