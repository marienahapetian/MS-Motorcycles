import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["content", "button", "overlay"];

    expanded = false;

    toggle() {
        this.expanded = !this.expanded;

        if (this.expanded) {
            this.contentTarget.classList.remove("max-h-[500px]");
            this.contentTarget.classList.add("max-h-[5000px]");

            this.buttonTarget.innerText = "Voir moins ↑";

            this.overlayTarget.classList.add("hidden");
        } else {
            this.contentTarget.classList.remove("max-h-[5000px]");
            this.contentTarget.classList.add("max-h-[500px]");

            this.buttonTarget.innerText = "Voir plus ↓";

            this.overlayTarget.classList.remove("hidden");
        }
    }
}