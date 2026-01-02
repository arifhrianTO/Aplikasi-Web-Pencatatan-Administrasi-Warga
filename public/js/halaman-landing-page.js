 const menu = document.querySelector('#menu-icon');
        const navlist = document.querySelector('.navlist');

        // Toggle buka/tutup navbar
        menu.onclick = (e) => {
            e.stopPropagation();
            menu.classList.toggle('bx-x');
            navlist.classList.toggle('open');
        };

        // Tutup navbar kalau klik di luar
        document.onclick = (e) => {
            if (!navlist.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.remove('bx-x');
                navlist.classList.remove('open');
            }
        }

        const faqButtons = document.querySelectorAll(".faq-question");

        faqButtons.forEach(btn => {
            btn.addEventListener("click", () => {
                const answer = btn.nextElementSibling;
                answer.style.display = answer.style.display === "block" ? "none" : "block";
            });
        });
 