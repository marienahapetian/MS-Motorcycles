import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        if (window.location.hash) {
            const element = document.querySelector(window.location.hash);

            if (element) {
                setTimeout(() => {
                    element.scrollIntoView({
                        behavior: 'smooth'
                    });
                }, 100);
            }
        }
    }
}