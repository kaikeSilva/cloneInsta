@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="/p" enctype="multipart/form-data" method="post">
        <!-- Laravel impede qualquer um de postar e como medida de segurança é preciso identificar esteformulário para que o láravel saiba a procedência. Comando: @csrf -->
        @csrf
            <div class="row">
                
                <div class="col-8 offset-2">
                <h1>Add new post</h1>
                    <!-- Titulo da imagem -->
                    <div class="form-group row">
                        <label for="caption" class="col-md-4 col-form-label">image caption</label>

                        <input id="caption" 
                        type="caption" 
                        class="form-control @error('caption') is-invalid @enderror" 
                        name="caption" 
                        value="{{ old('caption') }}"  
                        autocomplete="caption">

                        @error('caption')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Input da imagem -->
                    <div class="row">
                        <label for="image" class="col-md-4 col-form-label">Post image</label>
                        <input type="file" class="form-control-file" name="image" id="image">

                        @error('image')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>

                    <!-- Botão de submit do formulario -->
                    <div class="row pt-4">
                        <button class="btn btn-primary" type="submit">Add New Post</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
