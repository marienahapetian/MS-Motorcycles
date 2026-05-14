import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["container", "input", "prototype"];

    connect() {
        this.index = this.containerTarget.children.length;
    }

    add(event) {
        if (event.key !== "Enter") return;

        event.preventDefault();

        const value = this.inputTarget.value.trim();

        if (!value) return;

        const prototype = this.prototypeTarget.dataset.prototype;

        const html = prototype.replace(/__name__/g, this.index);

        const wrapper = document.createElement("div");

        wrapper.innerHTML = html;

        const input = wrapper.querySelector("input");

        input.value = value;

        const tag = document.createElement("div");

        tag.className =
            "flex items-center gap-2 bg-gray-200 rounded-full px-3 py-1";

        tag.innerHTML = `
            <span>${value}</span>
            <button type="button"
                class="text-red-500 hover:text-red-700 font-bold">
                ✕
            </button>
        `;

        tag.appendChild(input);

        tag.querySelector("button").addEventListener("click", () => {
            tag.remove();
        });

        this.containerTarget.appendChild(tag);

        this.inputTarget.value = "";

        this.index++;
    }
}