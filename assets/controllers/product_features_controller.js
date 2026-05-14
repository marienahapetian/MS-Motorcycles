import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://symfony.com/bundles/StimulusBundle/current/index.html#lazy-stimulus-controllers
*/

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['featuresContainer', 'brandContainer']

    

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

        const featuresResponse = await fetch(
            `/dashboard/products/features?${params.toString()}`
         );
         
        const brandsResponse = await fetch(
            `/dashboard/products/brands?${params.toString()}`
        );

        const featuresHtml = await featuresResponse.text();
        const brandsHtml = await brandsResponse.text();

        this.featuresContainerTarget.innerHTML = featuresHtml;
        this.brandContainerTarget.innerHTML = brandsHtml;
    }

}
