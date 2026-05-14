import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://symfony.com/bundles/StimulusBundle/current/index.html#lazy-stimulus-controllers
*/

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['container']

    

    // Add custom controller actions here
    // fooBar() { this.fooTarget.classList.toggle(this.bazClass) }

     async changeCategory(event) {

        const selectbox = event.target;

        const categories = Array.from(selectbox.selectedOptions)
            .map(option => option.value);

        const productId = selectbox.dataset.productId;

        const params = new URLSearchParams();

        categories.forEach(category => {
            params.append('categories[]', category);
        });

        if (productId) {
            params.append('product', productId);
        }

        const response = await fetch(
            `/dashboard/products/features?${params.toString()}`
        );

        const html = await response.text();

        this.containerTarget.innerHTML = html;
    }

}
