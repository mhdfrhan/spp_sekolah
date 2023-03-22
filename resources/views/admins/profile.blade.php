@extends('layouts.master')
@section('header')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{ $page_title }}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $page_title }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card-wrapper">
                <!-- Custom form validation -->
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h3 class="mb-0">{{ $page_title }}</h3>
                            <p class="text-sm text-gray mb-0" style="font-weight: 500;">
                                Bergabung sejak {{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('d-m-Y') }}
                            </p>
                        </div>
                        @if (Session::has('message'))
                            <div class="alert alert-{{ Session::get('message_type') }} alert-dismissible fade show mt-3"
                                role="alert">
                                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                <span class="alert-text"><strong>{{ ucwords(Session::get('message_type')) }}!</strong>
                                    {{ Session::get('message') }}</span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                    <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                    <span class="alert-text"><strong>Error!</strong> {{ $error }}</span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <form action="{{ route('change.profile') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="d-flex align-items-start">
                                <div>
                                    @if (Auth::user()->image)
                                        <img src="{{ asset('assets/img/profile/' . Auth::user()->image) }}" width="100px"
                                            class="rounded img-preview" alt="Foto {{ Auth::user()->name }}">
                                    @else
                                        <img src="{{ asset('assets/img/profile/no-photo.png') }}" width="100px"
                                            class="rounded img-preview" alt="">
                                    @endif
                                </div>
                                <div class="ml-3 d-flex align-items-center">
                                    <label for="image" class="form-control-label text-primary mb-0 mr-3">Upload
                                        gambar</label>
                                    <input type="file" class="d-none" id="image" name="image"
                                        accept="image/png, image/jpeg, image/jpg">

                                    <a href="{{ route('delete.image') }}" class="p-0 btn-link text-danger text-sm">Hapus</a>
                                </div>
                            </div>
                            <div class="form-row mt-3">
                                <div class="col-md-4 mb-3">
                                    <label class="form-control-label" for="name">Nama *</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name') ? old('name') : Auth::user()->name }}" id="name"
                                        required autocomplete="off">
                                    <div class="invalid-feedback">
                                        Silahkan Isi Form Nama Terlebih Dahulu
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-control-label" for="username">Username *</label>
                                    <input type="text" name="username" class="form-control"
                                        value="{{ old('username') ? old('username') : Auth::user()->username }}"
                                        id="username" required autocomplete="off">
                                    <div class="invalid-feedback">
                                        Silahkan Isi Form Username Terlebih Dahulu
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-control-label" for="email">Email *</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email') ? old('email') : Auth::user()->email }}" id="email"
                                        required autocomplete="off">
                                    <div class="invalid-feedback">
                                        Silahkan Isi Form Email Terlebih Dahulu
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </form>
                        <form class="validation border-top pt-5 mt-5" novalidate method="POST" action="{{ route('change.password') }}">
                            @csrf
														@method('PUT')
                            <div class="mb-3">
                                <h2>Ubah Password</h2>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-control-label" for="current_password">Password saat ini *</label>
                                    <input type="password" name="current_password" class="form-control"
                                        id="current_password" required autocomplete="off">
                                    <div class="invalid-feedback">
                                        Silahkan Isi Password saat ini Terlebih Dahulu
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-control-label" for="new_password">Password Baru *</label>
                                    <input type="password" name="new_password" class="form-control" id="new_password"
                                        required autocomplete="off">
                                    <div class="invalid-feedback">
                                        Silahkan Isi Form Password Baru Terlebih Dahulu
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-control-label" for="new_confirm_password">Konfirmasi Password Baru
                                        *</label>
                                    <input type="password" name="new_confirm_password" class="form-control"
                                        id="new_confirm_password" required autocomplete="off">
                                    <div class="invalid-feedback">
                                        Silahkan Isi Form Konfirmasi Password Baru Terlebih Dahulu
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('bottom')
    <!-- Optional JS -->
    <script>
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
@endpush
