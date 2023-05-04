import {handleError} from "./global";

const targets = {
    'modalTitle':  'h4[data-extension-form-modal-target="title"]',
    'modalBody':   'div[data-extension-form-modal-target="body"]',
    'btnModalTitle': 'extension-form-modal-title',
    'btnModalFormUrl': 'extension-form-modal-form-url',
    'modalDialog': 'div[data-extension-form-modal-target="modalDialog"]'
};

export function launchFormModal(
    htmlElement,
    modalSizeClass = '',
    getFormCb,
    serializeDataCb,
    successCb,
    failureCb
) {
    // Avoid many clicks.
    if ($(htmlElement).data('is-clicked') === true) return;

    $(htmlElement).data('is-clicked', true);

    setTimeout(() => {
        $(htmlElement).data('is-clicked', false);
    }, 1000);

    const $formModal = $('#formModal');

    emptyFormModal();

    $formModal.find(targets.modalTitle).html($(htmlElement).data(targets.btnModalTitle));

    if (modalSizeClass !== '') $formModal.find(targets.modalDialog).addClass(modalSizeClass);

    const url = $(htmlElement).data(targets.btnModalFormUrl);
    handleGetForm(url, getFormCb, serializeDataCb, successCb, failureCb);
}

function handleGetForm(
    url,
    getFormCb,
    serializeDataCb,
    successCb,
    failureCb
) {
    try {
        $.ajax({
            url: url,
            type: 'GET',
            success: response => {
                if (response.htmlFragment) {
                    getFormCb(response, url);

                    let formModal = new bootstrap.Modal($('#formModal')[0]);
                    formModal.show();

                    formModal._element.addEventListener('hidden.bs.modal', (e) => {
                        const target = e.currentTarget;

                        $(target).off();

                        $(target).find('input').each((element) => {
                            $(element).off();
                        })
                        $(target).find('button').each((element) => {
                            $(element).off();
                        })
                        $(target).find('select').each((element) => {
                            $(element).off();
                        })
                    })

                    $('#formModal').find('form').on('submit', (e) => {
                        e.preventDefault();
                        handleSubmit(url, getFormCb, serializeDataCb, successCb, failureCb)
                    });
                }
            },
            error: error => {
                handleError(error);
            }
        })
    } catch (error) {
        handleError(error);
    }
}

function handleSubmit(
    url,
    getFormCb,
    serializeDataCb,
    successCb,
    failureCb
) {
    const data = serializeDataCb();
    const method = $('#formModal').find('form input[name="_method"]').val();

    if (data === false) return;

    const ajaxOptions = {
        type: (method ? method : 'POST'),
        url: url,
        data: data
    };

    if (data instanceof FormData) {
        ajaxOptions.cache = false;
        ajaxOptions.contentType = false;
        ajaxOptions.processData = false;
    }

    $.ajax(ajaxOptions).done(response => {
        if(response.success) {
            let $formModal = bootstrap.Modal.getInstance($('#formModal')[0]);
            $formModal.hide();

            successCb(response);
        } else {
            if (response.htmlFragment) {
                failureCb(response, url);

                $('#formModal').find('form').on('submit', (e) => {
                    e.preventDefault();
                    handleSubmit(url, getFormCb, serializeDataCb, successCb, failureCb)
                });
            } else {
                let formModal = new bootstrap.Modal($('#formModal')[0]);
                formModal.hide();

                handleGetForm(url, getFormCb, serializeDataCb, successCb, failureCb);
            }
        }
    }).fail(e => console.log(e));
}

function emptyFormModal() {
    let $formModal = $('#formModal');
    $formModal.find(targets.modalTitle).empty();
    $formModal.find(targets.modalBody).empty();

    $formModal.find('.modal-dialog').removeClass('modal-xl');
    $formModal.find('.modal-dialog').removeClass('modal-lg');
    
    $formModal = bootstrap.Modal.getInstance($('#formModal')[0]);
    if ($formModal !== null) $formModal.hide();
}

export function displaySuccessMessage(e, id)
{
    let message = "";

    if($(e).is('i')) message = $(e).parent().data(id);
    if($(e).is('svg')) message = $(e).parent().data(id);
    if($(e).is('path')) message = $(e).parent().parent().data(id);
    if($(e).is('span')) message = $(e).parent().data(id);
    if($(e).is('a')) message = $(e).data(id);
    if($(e).is('button')) message = $(e).data(id);
    if($(e).is('div')) message = $(e).data(id);

    let $toast = $('#toast');

    $toast.find('.toast-body').html(message);

    let toast = new bootstrap.Toast($toast[0]);
    toast.show();
}