/** Select 2 **/
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$("#selMenus").select2({
    placeholder: "Select parent menu",
    ajax: {
        url: "/select2/menus",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
            return {
                _token: CSRF_TOKEN,
                search: params.term // search term
            };
        },
        processResults: function(response) {
            return {
                results: response
            };
        },
        cache: true
    }
});

$('#selPermissions').on('click', function() {
    console.log('test');
});


$("#selPermissions").select2({
    placeholder: "Select group permission",
    ajax: {
        url: "/select2/permissions",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
            return {
                _token: CSRF_TOKEN,
                search: params.term // search term
            };
        },
        processResults: function(response) {
            return {
                results: response
            };
        },
        cache: true
    }
});

$("#selPtjs").select2({
    placeholder: "Select Ptj",
    width: '100%',
    ajax: {
        url: "/select2/faculties",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
            console.log(params.term);
            return {
                _token: CSRF_TOKEN,
                search: params.term // search term
            };
        },
        processResults: function(response) {
            return {
                results: response
            };
        },
        cache: true
    }
});