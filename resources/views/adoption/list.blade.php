@extends('layouts.admin')

@section('title', 'Amministrazione Adozioni')

@section('acontent')
    <div class="row">
        <div class="col-md-12">
            <div class="list-group">
                @foreach(App\Adoption::orderBy('created_at', 'desc')->get() as $location)
                    <a href="{{ url('adozione/' . $location->id . '/edit') }}" class="list-group-item {{ $location->status == 'confirmed' ? 'active' : '' }}">
                        {{ $location->address }}
                        @if($location->status == 'pending')
                            <span class="badge">In Attesa</span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
