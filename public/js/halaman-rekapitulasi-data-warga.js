function toggleProfile() {
    const popup = document.getElementById('profilePopup');
    popup.style.display = (popup.style.display === 'block') ? 'none' : 'block';
  }

  window.onclick = function (e) {
    const popup = document.getElementById('profilePopup');
    if (!e.target.closest('.profile-container')) {
      popup.style.display = 'none';
    }
  };


  function toggleSidebar() {
      document.getElementById("sidebar").classList.toggle("closed");
      document.getElementById("sidebar").classList.toggle("open");
    }

  const umurSelect = document.getElementById("semuaumur");
  const genderSelect = document.getElementById("gender");
  const rtSelect = document.getElementById("NoRT");
  const statusSelect = document.getElementById("status");

  umurSelect.addEventListener("change", filterTable);
  genderSelect.addEventListener("change", filterTable);
  rtSelect.addEventListener("change", filterTable);
  statusSelect.addEventListener("change", filterTable);

  function filterTable() {
    const selectedUmur = umurSelect.value;
    const selectedGender = genderSelect.value.toLowerCase();
    const selectedRT = rtSelect.value.toLowerCase();
    const selectedStatus = statusSelect.value.toLowerCase();

    const rows = document.querySelectorAll("table tbody tr");

    rows.forEach(row => {
      const umurCell = parseInt(row.cells[6]?.textContent) || 0;
      const genderCell = row.cells[4]?.textContent.toLowerCase();
      const rtCell = row.cells[9]?.textContent.toLowerCase();
      const statusCell = row.cells[12]?.textContent.toLowerCase();

      let matchUmur = false;
      if (selectedUmur === "Semua Umur") {
        matchUmur = true;
      } else {
        const [min, max] = selectedUmur.split("-").map(Number);
        if (selectedUmur === ">65" && umurCell > 65) {
          matchUmur = true;
        } else if (umurCell >= min && umurCell <= max) {
          matchUmur = true;
        }
      }

      const matchGender = (selectedGender === "all" || genderCell.includes(selectedGender));
      const matchRT = (selectedRT === "all" || rtCell.includes(selectedRT));
      const matchStatus = (selectedStatus === "all" || statusCell.includes(selectedStatus));

      if (matchUmur && matchGender && matchRT && matchStatus) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  }

function cetakPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'pt', 'a4'); // Landscape

    const pageWidth = doc.internal.pageSize.getWidth();

    const logo = new Image();
    logo.src = "/php/public/Image/logo.png";

    logo.onload = function () {

        // === LOGO ===
        doc.addImage(logo, "PNG", 60, 35, 80, 80);

        // === KOP SURAT ===
        doc.setFont("Helvetica", "Bold");
        doc.setFontSize(18);
        doc.text("KETUA RW. 01", pageWidth / 2, 55, { align: "center" });

        doc.setFontSize(14);
        doc.text("KELURAHAN BALOI PERMAI - KECAMATAN BATAM KOTA", pageWidth / 2, 75, { align: "center" });
        doc.text("KOTA BATAM", pageWidth / 2, 95, { align: "center" });
        doc.text("PERUMAHAN GRAHA LEGENDA MALAKA BLOK F", pageWidth / 2, 115, { align: "center" });

        doc.setFontSize(11);
        doc.text("KODE POS 29435", pageWidth - 130, 115);

        // === GARIS ===
        doc.setLineWidth(1);
        doc.line(40, 135, pageWidth - 40, 135);
        doc.setLineWidth(2);
        doc.line(40, 140, pageWidth - 40, 140);

        // === JUDUL ===
        doc.setFontSize(17);
        doc.text("REKAPITULASI DATA WARGA", pageWidth / 2, 175, { align: "center" });

        // === POSISI AWAL TABEL ===
        let Y = 200;

        // === AMBIL DATA TABLE HTML ===
        const rows = document.querySelectorAll("table tbody tr");
        let bodyData = [];
        let nomor = 1;

        rows.forEach(row => {
            if (row.style.display !== "none") {
                bodyData.push([
                    nomor++,
                    row.cells[1].innerText,
                    row.cells[2].innerText,
                    row.cells[3].innerText,
                    row.cells[4].innerText,
                    row.cells[5].innerText,
                    row.cells[6].innerText,
                    row.cells[7].innerText,
                    row.cells[8].innerText,
                    row.cells[9].innerText,
                    row.cells[10].innerText,
                    row.cells[11].innerText,
                    row.cells[12].innerText
                ]);
            }
        });

        // === TABEL ===
        doc.autoTable({
            head: [[
                "No", "NIK", "No KK", "Nama", "Gender", "Agama", "Umur",
                "Tempat, Tanggal Lahir", "No Telp", "RT", "RW", "Alamat", "Status"
            ]],
            body: bodyData,
            startY: Y,
            margin: { left: 40, right: 40 },
            styles: {
                fontSize: 9,
                cellPadding: 3,
                overflow: 'linebreak'
            },
            headStyles: {
                fillColor: [40, 40, 40]
            },

            columnStyles: {
        9:  { cellWidth: 35, halign: 'center', overflow: 'visible' }, // RT
        10: { cellWidth: 35, halign: 'center', overflow: 'visible' }, // RW
    }
        });

        // === SIMPAN PDF ===
        doc.save("Rekapitulasi_Data_Warga.pdf");
    };
}
