@extends('layouts.app')




@section('title', 'Lista de dicas')
@section('content')
<h2 class='text-center'>Dicas</h2>
@if (!Auth::guest())
	@if ((Auth::user()->admin))
	<a href="{{ url('/dicas/create') }}" class=" lead btn btn-default ">Adicionar uma nova dica</a>
<hr>
@endif
@endif

<div class="container">


 <div class="col-md-3">
                <img class="slide-image" src="imagens/Digital_Nutri_logo.jpg" alt="">
                <div class="list-group">
                    <a href="/sobre" class="list-group-item">Sobre</a>
                    <a href="/contato" class="list-group-item">Contate-nos</a>
                    <a href="/produtos" class="list-group-item">Produtos</a>
                    <a href="/dicas" class="list-group-item">Dicas</a>

                </div>
            </div>

<div class="col-md-9 ">
@foreach($dicas as $dica)
    <h3>{{ $dica->titulo }}</h3>
    <p>{{ $dica->descricao}}</p>
    <p>
        <a href="{{ route('dicas.show', $dica->id) }}" class="btn btn-info">Visualizar dica</a>
         @if (!Auth::guest())
			@if (Auth::user()->admin)
                <a href="{{ route('dicas.edit', $dica->id) }}" class="btn btn-primary">Editar Dica</a>
            @endif
        @endif

    </p>
    <hr>
@endforeach
</div>
</div>
@stop




