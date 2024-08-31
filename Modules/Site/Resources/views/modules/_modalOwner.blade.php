<!-- Modal Administrator -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Owner</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="search-user-admin" class="col-form-label">UMMAIL ID</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="input" name="input" placeholder="Enter Recipient's username">
                        <div class="input-group-append">
                          <span class="input-group-text" id="basic-addon2">@um.edu.my</span>
                        </div>
                    </div>
                    <div class="form-text text-danger" id="errorMessage"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btnSave">Save</button>
            </div>
        </div>
    </div>
</div>


@push('js')
<script>
    $(function() {
        // disable enter key to submit form
        $('#myForm').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                return false;
            }
        });

        // on modal shown
        $('#myModal').on('shown.bs.modal', function() {
            $('#input').focus();
        });

        // on modal close will clear all input
        $('#myModal').on('hidden.bs.modal', function(e) {
            $('#btnSave').html('Save');
            $(this).find("input,textarea,select").val('').end()
                   .find("input[type=checkbox], input[type=radio]").prop("checked", "").end();
        });

        // submit add secretariat by press enter key
        $('#input').on('keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                submitSecretariat();
                return false;
            }
        });

        // submit add secretariat by click save button
        $('#btnSave').on('click', function () {
            submitSecretariat();
        });

        function submitSecretariat() {
            var input = $('#input').val();

            var url = "{!! url('getStaff') !!}";
            console.log(url);

            $('#btnSave').html('<img src="{{ asset('img/loading.gif') }}" width="20">');

            $.ajax({
                type : 'post',
                url  : url,
                data : {'id':input,_token:'{{ csrf_token() }}'},
                success:function(data){
                    console.log(data);
                    if (data['status'] == true) {
                        var email = data['body']['official_email'];
                        var newRow = `<tr>
                            <td>`+data['body']['fullname']+`</td>
                            <td>`+email+`<input type="hidden" name="users[]" value="`+email+`"></td>
                            <td>`+data['body']['office_no']+`</td>
                            <td class="text-right">
                                <button type="button" onClick="$(this).closest('tr').remove();" style="display:block;" class="btn btn-xs btn-outline-danger">Remove</button>
                            </td>
                        </tr>`;
                        $('#myTable > tbody:last-child').append(newRow);
                        $('#emptyList').hide();
                        $('#myModal').modal('toggle');
                    }
                    else {
                        $('#errorMessage').html(data['message']);
                        $('#btnSave').html('Save');
                    }
                }
            });
        }
    });

    // secretariats delete button
    function del(val) {
        document.getElementById('btn_delete'+val).style.display = "none";
        document.getElementById('btn_cancel'+val).style.display = "block";
        $('#'+val).closest('tr').addClass('table-danger');

        var newRow = `
            <td style="display:none" id="cancel_`+val+`" class="text-right">
                <input type="hidden" name="deleted[]" value="`+val+`"> 
            </td>   
        `;

        $('#'+val).append(newRow);
    }

    // secretariats cancel delete button
    function cancel(val){
        document.getElementById('btn_cancel'+val).style.display = "none";
        document.getElementById('btn_delete'+val).style.display = "block";
        $('#'+val).closest('tr').removeClass();
        $('#cancel_'+val).closest('td').remove();
    }
</script>
@endpush