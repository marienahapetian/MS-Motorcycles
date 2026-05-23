import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    navigate(event) {
        const href = this.element.getAttribute('href');

        const url = new URL(href, window.location.origin);

        const currentPath = window.location.pathname;

        console.log(url, currentPath); // check if we are just scrolling to the section of current page

        if (currentPath === url.pathname) {
            event.preventDefault();

            const target = document.querySelector(url.hash);

            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }
    }
}