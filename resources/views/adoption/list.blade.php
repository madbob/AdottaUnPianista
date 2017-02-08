@extends('layouts.admin')

@section('title', 'Amministrazione Adozioni')

@section('acontent')
    <div class="row">
        <div class="col-md-12">
            @if($locations->isEmpty())
                <div class="alert alert-info">
                    <p>Non ci sono locations registrate</p>
                </div>
            @else
                <div class="list-group">
                    @foreach($locations as $location)
                        <a href="{{ url('adozione/' . $location->id . '/edit') }}" class="list-group-item {{ $location->status == 'confirmed' ? 'active' : '' }}">
                            {{ $location->address . ' - ' . $location->surname . ' ' . $location->name }}
                            @if($location->status == 'pending')
                                <span class="badge">In Attesa</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
