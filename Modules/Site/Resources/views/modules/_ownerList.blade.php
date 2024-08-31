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
        @foreach ($users as $user)
            <tr id="{{$user->id}}">
                <td>{{$user->user->name}}</td>
                <td>{{$user->user->email}}</td>
                <td>{{$user->user->profile->office_no}}</td>
                <td class="text-right">
                    <button type="button" id="btn_delete{{$user->id}}"  value="{{$user->id}}" onClick="del(this.value);" style="display:block;" class="btn btn-xs btn-outline-danger">Remove</button>
                    <button type="button" id="btn_cancel{{$user->id}}" value="{{$user->id}}" onClick="cancel(this.value);" style="display:none;" class="btn btn-xs btn-warning">Undo</button>
                </td>
            </tr>        
        @endforeach
    </tbody>
</table>

@if (count($users) <= 0)
<div class="mt-2 text-center" id="emptyList">
    @include('widgets._emptyList')
</div> 
@endif