import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["menu"];

    toggle() {
        const menu = this.menuTarget;

        menu.classList.toggle("opacity-0");
        menu.classList.toggle("invisible");
        menu.classList.toggle("-translate-y-full");

        document.body.classList.toggle("overflow-hidden");
    }
}