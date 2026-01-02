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
    const row = button.closest("tr"); // ⬅️ PENTING
    const id_sekretaris = row.dataset.id;

    fetch("../../../app/controllers/akun/get-user.php?id_sekretaris=" + id_sekretaris)
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }

            document.getElementById("idUpdate").value = data.id_sekretaris;
            document.getElementById("nikUpdate").value = data.nik_sekretaris;
            document.getElementById("usernameUpdate").value = data.username;
            document.getElementById("roleUpdate").value = data.role;

            document.getElementById("updatePopup").classList.add("active");
        })
        .catch(err => {
            console.error(err);
            alert("Gagal mengambil data");
        });
}

function closeUpdate() {
    document.getElementById("updatePopup").classList.remove("active");
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
    window.location.href = "../../controllers/akun/hapus-akun-sekretaris.php?nik_sekretaris=" + nik;
});


  function toggleSidebar() {
      document.getElementById("sidebar").classList.toggle("closed");
      document.getElementById("sidebar").classList.toggle("open");
    }


    //untuk mencari data dari data warga
    document.addEventListener("DOMContentLoaded", () => {

    const nikInput = document.getElementById("nik");

    if (nikInput) {
        nikInput.addEventListener("keyup", function () {
            let nik = this.value;

            if (nik.length < 3) return;

            fetch("../../../app/controllers/akun/get_warga.php?nik=" + nik)
                .then(res => res.json())
                .then(data => {
                    if (data) {
                        document.getElementById("nama").value = data.nama || "";
                        document.getElementById("telp").value = data.no_telp || "";
                        document.getElementById("kk").value = data.NO_KK || "";
                        document.getElementById("alamat").value = data.alamat || "";
                        document.getElementById("rt_rw").value =
                          (data.no_rt && data.no_rw)
                          ? `RT ${data.no_rt} / RW ${data.no_rw}`: "";

                        document.getElementById("no_rt").value = data.no_rt || "";
                        document.getElementById("no_rw").value = data.no_rw || ""; 
                    } else {
                        document.getElementById("nama").value = "";
                        document.getElementById("telp").value = "";
                        document.getElementById("kk").value = "";
                        document.getElementById("alamat").value = "";
                        document.getElementById("rt_rw").value = "";
                        document.getElementById("no_rt").value = "";
                        document.getElementById("no_rw").value = "";
                    }
                });
        });
    }

});
