import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["box"];

    connect() {
        this.open = false;
    }

    toggle() {
        this.open = !this.open;
        this.boxTarget.classList.toggle("hidden", !this.open);
    }

    close(event) {
        if (!this.element.contains(event.target)) {
            this.boxTarget.classList.add("hidden");
            this.open = false;
        }
    }
}