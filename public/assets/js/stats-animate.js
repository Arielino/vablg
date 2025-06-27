document.addEventListener('DOMContentLoaded', function() {
    function animateCounter(el) {
        const target = +el.getAttribute('data-target');
        const duration = 2000;
        const start = 0;
        const startTime = performance.now();
        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const value = Math.floor(progress * (target - start) + start);
            el.textContent = value;
            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                el.textContent = target;
            }
        }
        requestAnimationFrame(update);
    }

    function isInViewport(el) {
        const rect = el.getBoundingClientRect();
        return (
            rect.top < window.innerHeight && rect.bottom > 0
        );
    }

    let animated = false;
    function triggerAnimation() {
        if (animated) return;
        const counters = document.querySelectorAll('.stat-animate');
        let anyVisible = false;
        counters.forEach(function(counter) {
            if (isInViewport(counter)) {
                animateCounter(counter);
                anyVisible = true;
            }
        });
        if (anyVisible) animated = true;
    }

    window.addEventListener('scroll', triggerAnimation);
    triggerAnimation(); // au cas où déjà visible au chargement
}); 