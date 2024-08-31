<div class="row">
    <div class="col-lg-3">
        <h5>Administrator</h5>
    </div>
    <div class="col-lg-9">
        <div class="card">
            {!! Form::open(['route' => ['site.org-structure.manage-admin.store', 'level' => $level, 'id' => $id], 'method' => 'post']) !!}    
            <div class="card-body">
                <p class="text-left">
                    <button type="button" class="{{ config('adminlte.btn_add', 'btn-flat btn-default') }} btn-sm" data-toggle="modal" data-target="#myModal" id="btnShowModal">
                        <i class="fa fa-plus"></i> Add
                    </button>  
                </p>
                <table class="{{ config('adminlte.table_light') }}" id="myTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact No</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                            <tr id="{{$admin->id}}">
                                <td>{{$admin->user->name}}</td>
                                <td>{{$admin->user->email}}</td>
                                <td>{{$admin->user->profile->office_no}}</td>
                                <td class="text-right">
                                    <button type="button" id="btn_delete{{$admin->id}}"  value="{{$admin->id}}" onClick="del(this.value);" style="display:block;" class="btn btn-xs btn-outline-danger">Remove</button>
                                    <button type="button" id="btn_cancel{{$admin->id}}" value="{{$admin->id}}" onClick="cancel(this.value);" style="display:none;" class="btn btn-xs btn-warning">Undo</button>
                                </td>
                            </tr>        
                        @endforeach


                    </tbody>
                </table>

                @if (count($admins) <= 0)
                <div class="mt-2 text-center" id="emptyList">
                    @include('widgets._emptyList')
                </div> 
                @endif
                
            </div><!-- ./card-body -->
            <div class="card-footer text-right">
                <button type="submit" name="submit" value="submit" class="{{ config('adminlte.btn_primary') }}">Save</button>
            </div>
        </div><!-- ./card -->
        {!! Form::close() !!}
    </div>
</div>

<!-- Modal Administrator -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Secretariat</h5>
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
                            <td>`+email+`<input type="hidden" name="admin[]" value="`+email+`"></td>
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