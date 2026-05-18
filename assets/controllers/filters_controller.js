import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["panel", "icon"];

    toggle() {
        const panel = this.panelTarget;

        panel.classList.toggle("max-h-0");
        panel.classList.toggle("opacity-0");

        panel.classList.toggle("max-h-[1000px]");
        panel.classList.toggle("opacity-100");

        this.iconTarget.textContent = panel.classList.contains("max-h-0") ? "+" : "−";
    }
}