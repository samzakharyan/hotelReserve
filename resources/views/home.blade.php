@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                  <span>{{ __('Dashboard') }}</span>
                  <span>
                    @if (auth()->user()->role === 'ADMIN')
                        <a href="{{ route('add') }}" class="btn btn-primary">{{ __('Add') }}</a>
                    @endif
                </span>
                </div>
                <table class="table @if (!$rooms->count()) d-none @endif">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Status</th>
                        @if (auth()->user()->role === 'ADMIN')
                            <th scope="col">Fixer</th>
                        @endif
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($rooms as $room)
                            <tr>
                                <th scope="row">{{ $room->id }}</th>
                                <td>{{ $room->name }}</td>
                                <td>{{ $room->status }}</td>
                                @if (auth()->user()->role === 'ADMIN')
                                    <td>
                                        @if ($room->status === 'RESERVED')
                                            {{ $room->reserve->user->name }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endif
                                <td>
                                    @if (auth()->user()->role === 'ADMIN')
                                        <a href="{{ route('edit', ['roomId' => $room->id]) }}" class="btn btn-dark">Edit</a>
                                        <a href="" class="btn btn-danger">Delete</a>
                                    @else 
                                        <a href="{{ route('reservePage', ['roomId' => $room->id]) }}" class="btn btn-success">Reserve</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <span class="m-5 text-center">There are no rooms yet. Let's <a href="{{ route('add') }}">create</a> first room!</span>
                      @endforelse
                    </tbody>
                </table>
                {{ $rooms->links() }}
            </div>
            @if (auth()->user()->role === 'USER')
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                    <span>{{ __('My Reserves') }}</span>
                    </div>
                    <table class="table @if (!$myReserves->count()) d-none @endif">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            @if (auth()->user()->role === 'ADMIN')
                                <th scope="col">Fixer</th>
                            @endif
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse ($myReserves as $reserve)
                                <tr>
                                    <th scope="row">{{ $reserve->id }}</th>
                                    <td>{{ $reserve->rooms->name }}</td>
                                    <td>
                                        <form id="unset-form" action="{{ route('unset', ['roomId' => $reserve->rooms->id]) }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                        <a href="#" class="btn btn-dark"
                                            onclick="event.preventDefault();
                                                        document.getElementById('unset-form').submit();">Unset</a>
                                    </td>
                                </tr>
                            @empty
                                <span class="m-5 text-center">There are no rooms yet. Let's reserve first room!</span>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            @endif 
        </div>
    </div>
</div>
@endsection
