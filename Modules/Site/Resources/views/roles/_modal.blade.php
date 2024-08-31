<!-- Modal -->
<div class="modal fade" id="{{ $modalId ?? 'myModal' }}" tabindex="-1" role="dialog"
    aria-labelledby="{{ $modalId ?? 'myModal' }}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modalId ?? 'myModal' }}Label">{{ $modalTitle }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
					<div class="card-body table-responsive p-0" >
						<table class="{{ config('adminlte.table_light') }} myTable">
							<thead>
								<tr>
									<th>{{ __('Name') }}</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($items as $i => $item)
									<tr>
										<td>{{ $item }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
