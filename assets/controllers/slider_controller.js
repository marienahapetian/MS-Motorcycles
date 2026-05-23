import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.slides = this.element.querySelectorAll('.slide');
        this.dots = this.element.querySelectorAll('[data-slide-index]');

        this.current = 0;

        this.showSlide(this.current);

        this.startAutoSlide();
    }

    disconnect() {
        clearInterval(this.interval);
    }

    startAutoSlide() {
        this.interval = setInterval(() => {
            this.next();
        }, 5000);
    }

    next() {
        this.current++;

        if (this.current >= this.slides.length) {
            this.current = 0;
        }

        this.showSlide(this.current);
    }

    goToSlide(event) {
        console.log("eee");
        clearInterval(this.interval);

        this.current = parseInt(event.currentTarget.dataset.slideIndex);

        this.showSlide(this.current);

        this.startAutoSlide();
    }

    showSlide(index) {
        this.slides.forEach((slide, i) => {
            if (i === index) {
                slide.classList.remove('opacity-0');
                slide.classList.add('opacity-100');
            } else {
                slide.classList.remove('opacity-100');
                slide.classList.add('opacity-0');
            }
        });

        this.dots.forEach((dot, i) => {
            if (i === index) {
                dot.classList.remove('bg-white/50');
                dot.classList.add('bg-white');
            } else {
                dot.classList.remove('bg-white');
                dot.classList.add('bg-white/50');
            }
        });
    }
}