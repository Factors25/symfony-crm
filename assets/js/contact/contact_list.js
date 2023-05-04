import {handleError} from "../extension/global";
import {createDatatable} from "../extension/datatable";
import {launchFormModal, displaySuccessMessage} from "../extension/form_modal";
import {loadContactInfo} from "./contact_info";

const targets = {
    'component':   'div[data-component="contact-list"]',
    'formModal':   '[data-contact-list-target="formModal"]',
    'datatable':   'table[data-contact-list-target="datatable"]',
    'urlGet':      'url-get-contact-list',
    'modalTitle':  'h4[data-extension-form-modal-target="title"]',
    'modalBody':   'div[data-extension-form-modal-target="body"]',
    'successMessage': 'extension-form-modal-success-message'
};

$(document).ready(function() {
    loadTemplate();

    /** LISTENERS. */
    $(document).on('click', targets.formModal, (e) => {
        launchFormModal(
            e.currentTarget,
            'modal-lg',
            (response) => {
                $('#formModal').find(targets.modalBody).empty().html(response.htmlFragment);
            },
            () => {
                return $('#formModal').find('form').serializeArray();
            },
            (response) => {
                displaySuccessMessage(e.target, targets.successMessage);
                if(response.redirectUrl) {
                    document.location.href = response.redirectUrl;
                }
                loadTemplate();
                loadContactInfo();
            },
            (response) => {
                $('#formModal').find(targets.modalBody).empty().html(response.htmlFragment);
            }
        );
    });
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

                        const $datatable = $(htmlComponent).find(targets.datatable);
                        createDatatable($datatable[0]);
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