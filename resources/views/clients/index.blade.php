@php
    use App\Utils;
@endphp
@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Clients</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Clients</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">

            {{Utils::successAndFailMessage()}}

            <div class="card-header">
            <a href="{{ route('client.create') }}" class="btn btn-sm btn-success">Add</a>
            </div>
            <div class="card-body">
                <table class="table table-responsive table-bordered" id="users-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile No</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-nowrap"></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>

@stop

@push('scripts')
<script>
$(function() {
    var t = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '<?= route('client.data') ?>',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'mobile_no', name: 'mobile_no' },
            { data: '_status', name: '_status' },
            { data: 'action', name: 'action' },
        ],
        "order": [[ 0, "desc" ]],
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                if(column[0][0] == 0){
                    var input = '';
                }else if(column[0][0] == 4){
                    var input = '<?= single_quote(Utils::getStatusElement()) ?>';
                }else{
                    var input = document.createElement("input");
                }
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    column.search($(this).val(), false, false, true).draw();
                });
                t.on( 'order.dt search.dt', function () {
                    t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                        cell.innerHTML = i+1;
                    } );
                } ).draw();
            });
        }
    });
});

function confirmDelete(e){
    let content = `
        <p>You won't be able to revert this! </p>
        <div class="text-left">
        <li> <b>NOTE</b> </li>
        <li>It will delete all the details of client</li>
        <li>Mutual Funds, Polices, Documents, Goal Plans</li>
        <li>It will also delete All The Persons under The client.</li>
    </div>`
    Swal.fire({
        title: 'Are you sure?',
        html: content,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            e.submit();
        }
    })
    return false;
}

</script>
@endpush
