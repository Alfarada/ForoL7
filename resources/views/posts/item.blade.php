{{-- <li>
    <a href="{{ $post->url }}">
        {{ $post->title }}
    </a>
</li> --}}

<article>
    <h4><a href="{{ $post->url }}">{{ $post->title }}</a></h4>
        <p> Publicado  por <a href="#"> {{ $post->user->name }}</a>
            {{ $post->created_at->diffForHumans() }}
            en <a href="{{ $post->category->url }}">{{ $post->category->name }}</a>.
            @if ($post->pending)
                <span class="badge badge-warning"> Pendiente </span>
            @else
                <span class="badge badge-success"> Completado </span>
            @endif
        </p>
        <hr>
</article>