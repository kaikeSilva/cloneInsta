@extends('layouts.app')

@section('content')
<div class="container">
    <!--
        OPERAÇÃO DE PATCH - UPDATE DADOS
        OPERAÇÃO DE PUT - INSERIR NOVOS DADOS A DADOS EXISTENTES

        Para este formulario vai ser usado o metodo RESTful PATCH
        com a justificativa de que a operação atualiza dados no cadastro
        o padrao é /profile/{argumento} e a ação é de UPDATE.

        enctype="multipart/form-data": identificação para quando houver upload de imagem
    -->
    <form action="/profile/{{$user->id}}" enctype="multipart/form-data" method="post">
    <!-- Laravel impede que qualquer um poste e como medida de segurança é preciso identificar este formulário com um token, para que o láravel saiba a procedência. Comando: @csrf -->
    @csrf
    <!--
        Não existe metodo PATCH no formulário e para adequar a isso é utilizada uma diretiva do blade
        @method('PATCH')
    -->
    @method('PATCH')
        <div class="row">
            
            <div class="col-8 offset-2">
            <h1>Edit profile</h1>
                <!--
                    Cada campo precisa estar preenchido com os dados que estão na pagina inicial,
                    a variavel $user foi passada e pode ser usada no campo value de cada input.
                    
                    old('title') é para quando a validação falhar o formulario ser preenchido com 
                    o valor que o usuário ja havia preenchido.
                    ?? significa operador logico OU/OR
                -->
                <!-- Titulo do profile -->
                <div class="form-group row">
                    <label for="title" class="col-md-4 col-form-label">Title</label>

                    <input id="title" 
                    type="title" 
                    class="form-control @error('title') is-invalid @enderror" 
                    name="title" 
                    value="{{ old('title') ?? $user->profile->title }}"  
                    autocomplete="title">

                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <!-- Descrição do profile -->
                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label">Description</label>

                    <input id="description" 
                    type="description" 
                    class="form-control @error('description') is-invalid @enderror" 
                    name="description" 
                    value="{{ old('description') ?? $user->profile->description }}"  
                    autocomplete="description">

                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Url do profile -->
                <div class="form-group row">
                    <label for="url" class="col-md-4 col-form-label">Url</label>

                    <input id="url" 
                    type="text" 
                    class="form-control @error('url') is-invalid @enderror" 
                    name="url" 
                    value="{{ old('url') ?? $user->profile->url }}"  
                    autocomplete="url"
                    placeholder="http://seu site..."
                    >

                    @error('url')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Input da imagem do profile-->
                <div class="row">
                    <label for="image" class="col-md-4 col-form-label">Profile image</label>
                    <input type="file" class="form-control-file" name="image" id="image">

                    @error('image')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>

                <!-- Botão de submit do formulario -->
                <div class="row pt-4">
                    <button class="btn btn-primary" type="submit">Save profile</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
