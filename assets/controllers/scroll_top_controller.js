import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.toggleVisibility = this.toggleVisibility.bind(this);

        window.addEventListener('scroll', this.toggleVisibility);

        this.toggleVisibility();
    }

    disconnect() {
        window.removeEventListener('scroll', this.toggleVisibility);
    }

    toggleVisibility() {
        if (window.scrollY > 300) {
            this.element.classList.remove('opacity-0', 'pointer-events-none');
        } else {
            this.element.classList.add('opacity-0', 'pointer-events-none');
        }
    }

    scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
}