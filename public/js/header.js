// Header.js - Gestion du header et de la navigation mobile

document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileSidebar = document.getElementById('mobileSidebar');
    const mobileSidebarOverlay = document.getElementById('mobileSidebarOverlay');
    const mobileSidebarClose = document.getElementById('mobileSidebarClose');
    const header = document.querySelector('.header');
    const searchInput = document.getElementById('searchInput');
    const searchInputMobile = document.getElementById('searchInputMobile');

    // Gestion du menu mobile
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileSidebar.classList.add('active');
            mobileSidebarOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    }

    if (mobileSidebarClose) {
        mobileSidebarClose.addEventListener('click', function() {
            mobileSidebar.classList.remove('active');
            mobileSidebarOverlay.classList.remove('active');
            document.body.style.overflow = '';
        });
    }

    if (mobileSidebarOverlay) {
        mobileSidebarOverlay.addEventListener('click', function() {
            mobileSidebar.classList.remove('active');
            mobileSidebarOverlay.classList.remove('active');
            document.body.style.overflow = '';
        });
    }

    // Effet de scroll sur le header
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Gestion de la recherche
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            // Logique de recherche à implémenter
            console.log('Recherche:', query);
        });
    }

    if (searchInputMobile) {
        searchInputMobile.addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            // Logique de recherche à implémenter
            console.log('Recherche mobile:', query);
        });
    }

    // Fermer le menu mobile lors du clic sur un lien
    const mobileNavLinks = document.querySelectorAll('.mobile-sidebar .nav-link');
    mobileNavLinks.forEach(link => {
        link.addEventListener('click', function() {
            mobileSidebar.classList.remove('active');
            mobileSidebarOverlay.classList.remove('active');
            document.body.style.overflow = '';
        });
    });
});


