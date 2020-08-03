@extends('layouts/app')

@section('content')
<div class="row">
    <div class="col-md-10">
        <h1>{{ $post->title }}</h1>
    </div>
</div>
<div class="row">
    <div class="col-8">

        <p>
            Publicado por : <a href="#">{{ $post->user->name }}</a>
            {{ $post->created_at->diffForHumans() }}
            en <a href="{{ $post->category->url }}">{{ $post->category->name }}</a>.
            @if ($post->pending)
            <span class="badge badge-warning">Pendiente</span>
            @else
            <span class="badge badge-success">Completado</span>
            @endif
        </p>

        <app-vote score="{{ $post->score }}" vote="{{ $post->current_vote }}"></app-vote>

        {!! $post->safe_html_content !!}

        {{-- Subscribirse al post --}}

        @if (auth()->check())
            @if (!auth()->user()->isSubscribedTo($post))
            {!! Form::open(['route' => ['posts.subscribe', $post], 'method' => 'POST']) !!}
                <button type="submit" class="btn btn-primary">Suscribirse al post</button>
            {!! Form::close() !!}
            @else
            {!! Form::open(['route' => ['posts.unsubscribe', $post], 'method' => 'DELETE']) !!}
                <button type="submit" class="btn btn-primary">Desuscribirse del post</button>
            {!! Form::close() !!}
            @endif
        @endif

        <h4>Comentarios</h4>

        @foreach ($post->lastestComments as $comment)
        <article class="{{ $comment->answer ? 'answer' : ''}}">

            {{-- todo: support markdown in the comments as well --}}

            <p>{{ $comment->comment }}</p>

            @if(Gate::allows('accept', $comment) && !$comment->answer)
            {!! Form::open([ 'route' => ['comments.accept', $comment], 'method' => 'POST']) !!}
            <button type="submit">Aceptar respuesta</button>
            {!! Form::close() !!}
            @endif
        </article>
        <hr>

        @endforeach

        {!! Form::open(['route' => ['comments.store', $post], 'method' => 'POST', 'class' => 'form']) !!}

        {!! Field::textarea('comment', ['class' => 'form-control', 'rows' => 6, 'label' => 'Escribe un comentario']) !!}

        <button type="submit" class="btn btn-primary">
            Publicar comentario
        </button>

        {!! Form::close() !!}
    </div>
    @include('posts.sidebar')
</div>
@endsection