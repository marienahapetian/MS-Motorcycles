import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["options"];

    connect() {
        this.toggle();
    }

    toggle() {
        const selected = document.querySelector('input[name$="[type]"]:checked');

        if (!selected) return;

        if (selected.value === "options") {
            this.optionsTarget.classList.remove("hidden");
        } else {
            this.optionsTarget.classList.add("hidden");
        }
    }
}