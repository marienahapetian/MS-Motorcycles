import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://symfony.com/bundles/StimulusBundle/current/index.html#lazy-stimulus-controllers
*/

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['galleryContainer', 'input']


    initialize() {
        // Called once when the controller is first instantiated (per element)

        // Here you can initialize variables, create scoped callables for event
        // listeners, instantiate external libraries, etc.
        // this._fooBar = this.fooBar.bind(this)
    }

    connect() {
        // Called every time the controller is connected to the DOM
        // (on page load, when it's added to the DOM, moved in the DOM, etc.)

        // Here you can add event listeners on the element or target elements,
        // add or remove classes, attributes, dispatch custom events, etc.
        // this.fooTarget.addEventListener('click', this._fooBar)

        this.files = [];
    }

    // Add custom controller actions here
    // fooBar() { this.fooTarget.classList.toggle(this.bazClass) }

    disconnect() {
        // Called anytime its element is disconnected from the DOM
        // (on page change, when it's removed from or moved in the DOM, etc.)

        // Here you should remove all event listeners added in "connect()" 
        // this.fooTarget.removeEventListener('click', this._fooBar)
    }

    displaySelected(event) {
         const newFiles = Array.from(event.target.files);

        if (!newFiles.length) {
            return;
        }

        this.files.push(...newFiles);

        const dataTransfer = new DataTransfer();

        this.files.forEach((file) => {
            dataTransfer.items.add(file);
        });

        this.inputTarget.files = dataTransfer.files;

        newFiles.forEach((file) => {
            if (!file.type.startsWith('image/')) {
                return;
            }

            const reader = new FileReader();

            reader.onload = (e) => {
                const wrapper = document.createElement('div');

                wrapper.classList.add('relative', 'group');

                wrapper.innerHTML = `
                    <img
                        src="${e.target.result}"
                        class="w-full h-24 object-cover border"
                    />
                `;

                this.galleryContainerTarget.appendChild(wrapper);
            };

            reader.readAsDataURL(file);
        });
    }
}
