(() => {
	const body = document.body;
	const navToggle = document.querySelector('[data-nav-toggle]');
	const nav = document.querySelector('[data-primary-nav]');

	if (navToggle && nav) {
		navToggle.addEventListener('click', () => {
			const expanded = navToggle.getAttribute('aria-expanded') === 'true';
			navToggle.setAttribute('aria-expanded', String(!expanded));
			body.classList.toggle('nav-open', !expanded);
		});
	}

	const heroSlider = document.querySelector('[data-hero-slider]');
	if (heroSlider) {
		const slides = Array.from(heroSlider.querySelectorAll('[data-hero-slide]'));
		const dots = Array.from(heroSlider.querySelectorAll('[data-hero-dot]'));
		const prev = heroSlider.querySelector('[data-hero-prev]');
		const next = heroSlider.querySelector('[data-hero-next]');
		const pause = heroSlider.querySelector('[data-hero-pause]');
		const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
		let active = 0;
		let paused = reduceMotion;
		let timer = null;

		const showSlide = (index) => {
			active = (index + slides.length) % slides.length;
			slides.forEach((slide, slideIndex) => {
				const isActive = slideIndex === active;
				slide.classList.toggle('is-active', isActive);
				slide.setAttribute('aria-hidden', String(!isActive));
			});
			dots.forEach((dot, dotIndex) => {
				dot.classList.toggle('is-active', dotIndex === active);
			});
		};

		const stop = () => {
			if (timer) window.clearInterval(timer);
			timer = null;
		};

		const start = () => {
			stop();
			if (!paused && slides.length > 1) {
				timer = window.setInterval(() => showSlide(active + 1), 6500);
			}
		};

		prev?.addEventListener('click', () => {
			showSlide(active - 1);
			start();
		});
		next?.addEventListener('click', () => {
			showSlide(active + 1);
			start();
		});
		dots.forEach((dot, index) => {
			dot.addEventListener('click', () => {
				showSlide(index);
				start();
			});
		});
		pause?.addEventListener('click', () => {
			paused = !paused;
			pause.setAttribute('aria-pressed', String(paused));
			pause.textContent = paused ? 'Play' : 'Pause';
			start();
		});
		heroSlider.addEventListener('mouseenter', stop);
		heroSlider.addEventListener('mouseleave', start);
		showSlide(0);
		start();
	}

	const revealItems = document.querySelectorAll('.reveal');
	if ('IntersectionObserver' in window && revealItems.length) {
		const observer = new IntersectionObserver((entries) => {
			entries.forEach((entry) => {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-visible');
					observer.unobserve(entry.target);
				}
			});
		}, { threshold: 0.12 });

		revealItems.forEach((item) => observer.observe(item));
	} else {
		revealItems.forEach((item) => item.classList.add('is-visible'));
	}

	const filters = document.querySelector('[data-gallery-filters]');
	if (filters) {
		filters.addEventListener('click', (event) => {
			const button = event.target.closest('button[data-filter]');
			if (!button) return;

			const filter = button.dataset.filter;
			filters.querySelectorAll('button').forEach((item) => item.classList.toggle('is-active', item === button));
			document.querySelectorAll('[data-gallery-item]').forEach((item) => {
				const categories = item.dataset.category || '';
				item.hidden = filter !== 'all' && !categories.split(' ').includes(filter);
			});
		});
	}

	const viewSwitcher = document.querySelector('[data-view-switcher]');
	const scheduleView = document.querySelector('[data-schedule-view]');
	if (viewSwitcher && scheduleView) {
		viewSwitcher.addEventListener('click', (event) => {
			const button = event.target.closest('button[data-view]');
			if (!button) return;

			viewSwitcher.querySelectorAll('button').forEach((item) => item.classList.toggle('is-active', item === button));
			scheduleView.classList.toggle('is-calendar', button.dataset.view === 'calendar');
			scheduleView.classList.toggle('is-list', button.dataset.view !== 'calendar');
		});
	}

	const lightbox = document.createElement('div');
	lightbox.className = 'lightbox';
	lightbox.hidden = true;
	lightbox.innerHTML = '<div class="lightbox__inner"><button type="button">Close</button><div data-lightbox-content></div></div>';
	document.body.appendChild(lightbox);

	const lightboxContent = lightbox.querySelector('[data-lightbox-content]');
	const closeLightbox = () => {
		lightbox.hidden = true;
		lightboxContent.innerHTML = '';
	};

	lightbox.addEventListener('click', (event) => {
		if (event.target === lightbox || event.target.tagName === 'BUTTON') closeLightbox();
	});

	document.addEventListener('keydown', (event) => {
		if (event.key === 'Escape' && !lightbox.hidden) closeLightbox();
	});

	document.addEventListener('click', (event) => {
		const trigger = event.target.closest('[data-lightbox-src]');
		if (!trigger) return;

		const src = trigger.dataset.lightboxSrc;
		const type = trigger.dataset.lightboxType;
		if (!src) return;

		const embedUrl = (url) => {
			if (url.includes('youtube.com/watch')) return url.replace('watch?v=', 'embed/');
			if (url.includes('youtu.be/')) return url.replace('youtu.be/', 'www.youtube.com/embed/');
			if (url.includes('vimeo.com/')) return url.replace('vimeo.com/', 'player.vimeo.com/video/');
			return url;
		};

		if (type === 'photo') {
			lightboxContent.innerHTML = `<img src="${src}" alt="">`;
		} else {
			lightboxContent.innerHTML = `<iframe src="${embedUrl(src)}" title="Video" loading="lazy" allowfullscreen></iframe>`;
		}

		lightbox.hidden = false;
		lightbox.querySelector('button').focus();
	});
})();
