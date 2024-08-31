@if ($currentLevel['level'] > 1)
    
    <div class="row">
        <div class="col-lg-3">
            <h5>Group Information</h5>
            <p class="text-muted">Provide section group information</p>
        </div>
        <div class="col-lg-9">
            

            <div class="card">
                <div class="card-body">

                    @if ($currentLevel['level'] > 1)
                        <dl>
                            <dt>Ptj</dt>
                            <dd>{{ $model->ptj->name }}</dd>
                        </dl>
                        {!! Form::hidden('ptj_id' , $model->ptj->id) !!}

                        @if ($currentLevel['level'] > 2)
                            <dl>
                                <dt>Department</dt>
                                <dd>{{ $model->department->name }}</dd>
                            </dl>
                            {!! Form::hidden('department_id' , $model->department->id) !!}


                            @if ($currentLevel['level'] > 3)
                                <dl>
                                    <dt>Division</dt>
                                    <dd>{{ $model->division->name }}</dd>
                                </dl>
                                {!! Form::hidden('division_id' , $model->division->id) !!}

                                @if ($currentLevel['level'] > 4) 
                                    <dl>
                                        <dt>Section</dt>
                                        <dd>{{ $model->section->name }}</dd>
                                    </dl>
                                    {!! Form::hidden('section_id' , $model->section->id) !!}
                                @else 
                                    @if ($isNew)
                                    <dl>
                                        <dt>Section</dt>
                                        <dd>{{ $model->name }}</dd>
                                    </dl>
                                    @endif
                                    {!! Form::hidden('section_id' , $model->id) !!}
                                @endif
                            @else 
                                @if ($isNew)
                                <dl>
                                    <dt>Division</dt>
                                    <dd>{{ $model->name }}</dd>
                                </dl>
                                @endif
                                {!! Form::hidden('division_id' , $model->id) !!}
                            @endif
                        @else 
                            @if ($isNew)
                            <dl>
                                <dt>Department</dt>
                                <dd>{{ $model->name }}</dd>
                            </dl>
                            @endif
                            {!! Form::hidden('department_id' , $model->id) !!}
                        @endif
                    @else
                        @if ($isNew)
                        <dl>
                            <dt>Faculty</dt>
                            <dd>{{ $model->name }}</dd>
                        </dl>
                        @endif
                        
                        {!! Form::hidden('ptj_id' , $model->id) !!}

                    @endif
                </div>    
            </div>           
            

        </div>
    </div>
    <hr>
@endif