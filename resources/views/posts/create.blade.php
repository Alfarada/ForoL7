@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">

                    {!! Form::open(['method' => 'POST', 'route' => 'posts.store']) !!}

                    {!! Field::text('title') !!}

                    {!! Field::textarea('content') !!}

                    {!! Field::select('category_id', $categories, ['empty' => false]) !!}

                    <div class="form-group row mb-0">
                        <div class="col text-center">

                            {!! Form::submit('Publicar',['class' => 'btn btn-primary']) !!}

                        </div>
                    </div>
                    
                    {!! Form::close() !!}
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection