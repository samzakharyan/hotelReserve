@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reserve ') . $room->name }}</div>
                <div class="card-body">
                    <form action="{{ route('reserve', ['roomId' => $room->id]) }}" method="POST">
                        @csrf
                        <div class="form-group m-3">
                            <label for="days">day</label>
                            <input type="text" name="days" class="form-control @error('days') is-invalid @enderror" id="days" placeholder="Days">
                            @error('days')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
