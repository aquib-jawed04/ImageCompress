@extends('layouts.app')

@section('content')
    
@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button> 
        <strong>{{ $message }}</strong>
</div>
@endif
@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button> 
        <strong>{{ $message }}</strong>
</div>
@endif





    <div class="container">
        <div class="jumbotron mb-4  ">
            <h1 class="display-4"><strong>ImageUpload Using Intervention</strong></h1>
            <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus doloribus repudiandae quis. In, perspiciatis nesciunt quae amet beatae consectetur harum enim pariatur dicta veniam optio odit vitae, aliquam, totam accusantium.</p>
        </div>
    
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="mt-4 mb-4">
                            <h2><b>Upload Image using TinyPng</b></h2>
                        </div>
                        <form action="{{route('image.upload')}}" method="POST" enctype="multipart/form-data">
                
                            @csrf
            
            
                            <div class="form-row ">
                                <div class="form-group col-md-12">
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image"  id="image" value="{{ old('image') }}" >
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
            
                            <div class="form-row ">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control @error('caption') is-invalid @enderror" name="caption"  id="caption" value="{{ old('caption') }}" >
                                    @error('caption')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
            
                        </form>

                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="mt-4 mb-4">
                            <h2><b>Upload Image using Smush</b></h2>
                        </div>
                        <form action="{{route('image.upload-smush')}}" method="POST" enctype="multipart/form-data">
                
                            @csrf
            
            
                            <div class="form-row ">
                                <div class="form-group col-md-12">
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image"  id="image" value="{{ old('image') }}" >
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
            
                            <div class="form-row ">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control @error('caption') is-invalid @enderror" name="caption"  id="caption" value="{{ old('caption') }}" >
                                    @error('caption')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
            
                        </form>

                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="mt-4 mb-4">
                            <h2><b>Upload Image using Spatie</b></h2>
                        </div>
                        <form action="{{route('image.upload-spatie')}}" method="POST" enctype="multipart/form-data">
                
                            @csrf
            
            
                            <div class="form-row ">
                                <div class="form-group col-md-12">
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image"  id="image" value="{{ old('image') }}" >
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
            
                            <div class="form-row ">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control @error('caption') is-invalid @enderror" name="caption"  id="caption" value="{{ old('caption') }}" >
                                    @error('caption')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
            
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>



@endsection