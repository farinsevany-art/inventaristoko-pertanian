// Simple, dependency-free banner slider
;(function(){
	'use strict';

	function qs(sel, ctx){ return (ctx || document).querySelector(sel); }
	function qsa(sel, ctx){ return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); }

	document.addEventListener('DOMContentLoaded', function(){
		var slider = qs('.banner-slider');
		if (!slider) return;

		var slides = qsa('.banner-slide', slider);
		var prevBtn = qs('.banner-prev', slider);
		var nextBtn = qs('.banner-next', slider);
		var indicators = qsa('.banner-indicator', slider);
		var current = 0;
		var interval = 5000;
		var timer = null;

		function goTo(idx){
			if (!slides.length) return;
			idx = (idx + slides.length) % slides.length;
			slides.forEach(function(s, i){
				s.classList.toggle('active', i === idx);
			});
			indicators.forEach(function(ind, i){
				ind.classList.toggle('active', i === idx);
			});
			current = idx;
		}

		function next(){ goTo(current + 1); }
		function prev(){ goTo(current - 1); }

		function start(){ stop(); timer = setInterval(next, interval); }
		function stop(){ if (timer) { clearInterval(timer); timer = null; } }

		// wire controls
		if (nextBtn) nextBtn.addEventListener('click', function(e){ e.preventDefault(); next(); });
		if (prevBtn) prevBtn.addEventListener('click', function(e){ e.preventDefault(); prev(); });

		// indicators
		indicators.forEach(function(ind){
			ind.addEventListener('click', function(e){
				var to = parseInt(this.getAttribute('data-slide-to'), 10);
				if (!isNaN(to)) goTo(to);
			});
		});

		// pause on hover/focus
		slider.addEventListener('mouseenter', stop);
		slider.addEventListener('mouseleave', start);
		slider.addEventListener('focusin', stop);
		slider.addEventListener('focusout', start);

		// keyboard support (left/right)
		document.addEventListener('keydown', function(e){
			if (e.key === 'ArrowLeft') prev();
			if (e.key === 'ArrowRight') next();
		});

		// initialize
		goTo(0);
		start();
	});
})();
