import {handleError} from "../extension/global";

const targets = {
    'component':   'div[data-component="contact-info"]',
    'formModal':   '[data-contact-info-target="formModal"]',
    'datatable':   'table[data-contact-info-target="datatable"]',
    'urlGet':      'url-get-contact-info',
    'modalTitle':  'h4[data-extension-form-modal-target="title"]',
    'modalBody':   'div[data-extension-form-modal-target="body"]',
    'successMessage': 'extension-form-modal-success-message'
};

$(document).ready(function() {
    loadTemplate();
});

function loadTemplate() {
    $(targets.component).each(async (index, htmlComponent) => {
        let url = $(htmlComponent).data(targets.urlGet);

        try {
            $.ajax({
                url: url,
                type: 'GET',
                success: response => {
                    if (response.success && response.htmlFragment) {
                        $(htmlComponent).empty().html(response.htmlFragment);
                    }
                },
                error: error => {
                    handleError(error);
                }
            })
        } catch (error) {
            handleError(error);
        }
    })
}

export {loadTemplate as loadContactInfo};