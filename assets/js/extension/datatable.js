export function createDatatable(htmlTable, initCompleteCb) {
    $(htmlTable).DataTable({
        language: {
            processing: "Traitement en cours...",
            search: "Rechercher&nbsp;:",
            lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
            info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            infoPostFix: "",
            loadingRecords: "Chargement en cours...",
            zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
            emptyTable: "Aucune donnée disponible dans le tableau",
            paginate: {
                first: "Premier",
                previous: "Pr&eacute;c&eacute;dent",
                next: "Suivant",
                last: "Dernier"
            },
            aria: {
                sortAscending: ": activer pour trier la colonne par ordre croissant",
                sortDescending: ": activer pour trier la colonne par ordre décroissant"
            },
            select: {
            	rows: ''
            }
        },
        columnDefs: columnDefs(htmlTable),
        pageLength: 25,
        processing: true,
        paging: paginate(htmlTable),
        autoWidth: false,
        select: select(htmlTable),
        ...serverSide(htmlTable),
        info: true,
        searching: searching(htmlTable),
        order: order(htmlTable),
        dom: dom(htmlTable),
        initComplete: () => {
            if (initCompleteCb) {
                initCompleteCb();
            }

            filterHint(htmlTable);
        },
    });
}

function select(htmlTable) {
	let select = false;

	if($(htmlTable).data('select')) {
	    select = $(htmlTable).data('select');
    }

	return select;
}

function filterHint(htmlTable) {
    if ($(htmlTable).data('filter-hint')) {
        $(htmlTable).parent().parent().parent().find('div.filter-hint').html($(htmlTable).data('filter-hint'));
    }
}

function dom(htmlTable) {
    let dom =
        "<'row'" +
            "<'col-12 col-md-6'l>" +
            "<'col-12 col-md-6'f>" +
        ">" +
        "<'row'" +
            "<'col-12'tr>" +
        ">" +
        "<'row'" +
            "<'col-12 col-md-5'i>" +
            "<'col-12 col-md-7'p>" +
        ">";

	if ($(htmlTable).data('dom')) {
		dom = $(htmlTable).data('dom');
	}
	if ($(htmlTable).data('filter-hint')) {
        dom = "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f <'filter-hint text-end text-muted small fst-italic'>>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
	}

    return dom;
}

function serverSide(htmlTable) {
    let serverSide = {};

    if(
        $(htmlTable).data('serverside') === true &&
        $(htmlTable).data('serverside-url')
    ) {
        serverSide = {
            ajax: {
                url: $(htmlTable).data('serverside-url'),
                type: 'POST',
                dataSrc: 'data'
            },
            serverSide: true,
        }
    }

    return serverSide;
}

function columnDefs(htmlTable) {
    let columnDefs = [];

    if($(htmlTable).data('column-defs')) {
        columnDefs = $(htmlTable).data('column-defs');
    }

    return columnDefs;
}

function paginate(htmlTable) {
	let paginate = true;

	if($(htmlTable).data('paginate')) {
	    paginate = $(htmlTable).data('paginate');
    }

	return paginate;
}

function searching(htmlTable) {
    let searching = false;

    if($(htmlTable).data('searching')) {
        searching = $(htmlTable).data('searching');
    }

    return searching;
}

function order(htmlTable) {
    let order = [[0, 'asc']];

    if($(htmlTable).data('order')) {
        order = $(htmlTable).data('order');
    }

    return order;
}
