@extends('layouts.master')
@push('up')
<!-- Page plugins -->
<link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert2/dist/sweetalert2.min.css') }}">
@endpush
@section('header')
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">{{ $page_title }}</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page">Petugas</li>
            </ol>
          </nav>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ url('admin/data/add') }}" class="btn btn-sm btn-neutral">Add</a>
          <a href="{{ route('export.admin') }}" class="btn btn-sm btn-neutral">Export</a>
          <button  data-toggle="modal" data-target="#importModal" class="btn btn-sm btn-neutral">Import</button>
					<!-- Modal -->
					<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<form action="{{ route('import.admin') }}" method="POST" enctype="multipart/form-data">
									@csrf
									<div class="modal-header">
										<h1 class="modal-title fs-5" id="importModalLabel">Import Data Siswa</h1>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<input type="file" name="file" class="form-control">
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-primary">Import</button>
									</div>
								</form>
							</div>
						</div>
					</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('content')
<div class="row">
  <div class="col">
    <div class="card">
      <!-- Card header -->
      <div class="card-header">
        <h3 class="mb-0">Master Data Petugas</h3>
        @if(Session::has('message'))
        <div class="alert alert-{{ Session::get('message_type') }} alert-dismissible fade show mt-3" role="alert">
          <span class="alert-icon"><i class="ni ni-like-2"></i></span>
          <span class="alert-text"><strong>{{ ucwords(Session::get('message_type')) }}!</strong> {{ Session::get('message') }}</span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif
      </div>
      <div class="table-responsive py-4">
        <table class="table table-flush" id="datatable-basic">
          <thead class="thead-light">
            <tr>
              <th>Nama</th>
              <th>Username</th>
              <th>E-Mail</th>
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Nama</th>
              <th>Username</th>
              <th>E-Mail</th>
              <th>Action</th>
            </tr>
          </tfoot>
          <tbody>
            @foreach($data as $d)
            <tr>
              <td>{{ $d->name }}</td>
              <td>{{ $d->username }}</td>
              <td>{{ $d->email }}</td>
              <td>
                <a href="{{ url('admin/data/edit',$d->id) }}" class="btn btn-sm btn-warning text-white" title="Edit Data"><i class="ni ni-ruler-pencil"></i></a>
                <a href="javascript:void(0)" onclick="destroy({{ $d->id }})" class="btn btn-sm btn-danger text-white"><i class="ni ni-box-2" title="Hapus Data"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
@push('bottom')
<!-- Optional JS -->
<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>
@endpush