$(document).ready(function() {
    // INITIALISATION IMMÉDIATE - Apparition instantanée des éléments visibles
    function initializeVisibleElements() {
        // Boutons de filtres seulement (les boutons principaux sont toujours visibles)
        $('.filter-btn').each(function() {
            var elementTop = $(this).offset().top;
            var windowHeight = $(window).height();
            
            // Si l'élément est dans la zone visible ou proche
            if (elementTop < windowHeight + 200) {
                $(this).addClass('btn-animate');
            }
        });
        
        // Textes visibles immédiatement
        $('.hero-title, .hero-subtitle, .section-title').each(function() {
            var elementTop = $(this).offset().top;
            var windowHeight = $(window).height();
            
            if (elementTop < windowHeight + 100) {
                $(this).addClass('text-animate');
            }
        });
        
        // Éléments fade-in visibles immédiatement
        $('.fade-in').each(function() {
            var elementTop = $(this).offset().top;
            var windowHeight = $(window).height();
            
            if (elementTop < windowHeight + 150) {
                $(this).addClass('visible');
            }
        });
    }
    
    // Lancer l'initialisation immédiatement
    initializeVisibleElements();
    
    // Relancer après un court délai pour s'assurer que tout est chargé
    setTimeout(initializeVisibleElements, 100);
    // Effet parallax sur le scroll
    $(window).scroll(function() {
        var scrollTop = $(this).scrollTop();
        var windowHeight = $(this).height();
        
        // Parallax pour les éléments avec différentes vitesses - OPTIMISÉ
        $('.parallax-slow').each(function() {
            var offset = $(this).offset().top;
            var speed = 0.3; // Réduit pour plus de subtilité
            var yPos = -(scrollTop - offset) * speed;
            $(this).css('transform', 'translateY(' + yPos + 'px)');
        });
        
        $('.parallax-medium').each(function() {
            var offset = $(this).offset().top;
            var speed = 0.2; // Réduit pour plus de subtilité
            var yPos = -(scrollTop - offset) * speed;
            $(this).css('transform', 'translateY(' + yPos + 'px)');
        });
        
        $('.parallax-fast').each(function() {
            var offset = $(this).offset().top;
            var speed = 0.5; // Réduit pour plus de subtilité
            var yPos = -(scrollTop - offset) * speed;
            $(this).css('transform', 'translateY(' + yPos + 'px)');
        });
        
        // Animation fade-in pour les éléments - ULTRA RAPIDE
        $('.fade-in').each(function() {
            var elementTop = $(this).offset().top;
            var elementBottom = elementTop + $(this).outerHeight();
            var viewportTop = scrollTop;
            var viewportBottom = viewportTop + windowHeight;
            
            // Déclenchement IMMÉDIAT dès que l'élément entre dans la zone (1200px avant)
            if (elementBottom > viewportTop - 1200 && elementTop < viewportBottom + 1200) {
                $(this).addClass('visible');
            }
        });
        
        // Animations pour les boutons de filtres uniquement
        $('.filter-btn').each(function() {
            var elementTop = $(this).offset().top;
            var elementBottom = elementTop + $(this).outerHeight();
            var viewportTop = scrollTop;
            var viewportBottom = viewportTop + windowHeight;
            
            // Déclenchement IMMÉDIAT dès l'apparition (1500px avant)
            if (elementBottom > viewportTop - 1500 && elementTop < viewportBottom + 1500) {
                $(this).addClass('btn-animate');
            }
        });
        
        // Animations pour les textes - EFFET TYPEWRITER
        $('.hero-title, .hero-subtitle, .section-title').each(function() {
            var elementTop = $(this).offset().top;
            var elementBottom = elementTop + $(this).outerHeight();
            var viewportTop = scrollTop;
            var viewportBottom = viewportTop + windowHeight;
            
            // Déclenchement IMMÉDIAT pour les textes (1000px avant)
            if (elementBottom > viewportTop - 1000 && elementTop < viewportBottom + 1000) {
                $(this).addClass('text-animate');
            }
        });
    });
    
    // Effet parallax sur le mouvement de la souris
    $(document).mousemove(function(e) {
        var mouseX = e.pageX;
        var mouseY = e.pageY;
        var windowWidth = $(window).width();
        var windowHeight = $(window).height();
        
        // Calcul du pourcentage de position de la souris
        var xPercent = (mouseX / windowWidth) * 100;
        var yPercent = (mouseY / windowHeight) * 100;
        
        // Appliquer l'effet parallax aux éléments avec la classe mouse-parallax
        $('.mouse-parallax').each(function() {
            var speed = $(this).data('speed') || 0.1;
            var xMove = (xPercent - 50) * speed;
            var yMove = (yPercent - 50) * speed;
            
            $(this).css({
                'transform': 'translate(' + xMove + 'px, ' + yMove + 'px)'
            });
        });
    });
    
    // Effet de rotation 3D sur les cartes de formation - AMÉLIORÉ
    $('.formation-card').hover(
        function() {
            $(this).addClass('parallax-hover');
            $(this).css('transform', 'translateY(-5px) scale(1.02)');
        },
        function() {
            $(this).removeClass('parallax-hover');
            $(this).css('transform', 'translateY(0) scale(1)');
        }
    );
    
    // Animation des éléments au chargement de la page - PLUS RAPIDE
    setTimeout(function() {
        $('.hero-content').addClass('fade-in visible');
        $('.formation-card').each(function(index) {
            var card = $(this);
            setTimeout(function() {
                card.addClass('fade-in visible');
            }, index * 100); // Réduit de 200ms à 100ms
        });
    }, 200); // Réduit de 500ms à 200ms
    
    // Smooth scroll avec effet parallax
    $('a[href^="#"]').click(function(e) {
        e.preventDefault();
        var target = $($(this).attr('href'));
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 80
            }, 1000, 'easeInOutQuart');
        }
    });
});

// Fonction pour optimiser les performances du parallax
function throttle(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Version optimisée du scroll parallax
$(window).scroll(throttle(function() {
    var scrollTop = $(this).scrollTop();
    
    // Parallax optimisé pour l'arrière-plan
    $('body').css('background-position', 'center ' + (scrollTop * 0.5) + 'px');
}, 16)); // 60fps
