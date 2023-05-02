@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <form class="p-3" action="{{ route('store') }}" method="POST">
                    @csrf
                    <div class="form-group m-3">
                      <label for="name">Name</label>
                      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Room name">
                      @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                    <div class="form-group m-3">
                      <label for="status">Status</label>
                      <select class="form-select @error('status') is-invalid @enderror" name="status" id="status">
                        <option selected>Select status</option>
                        <option value="FREE">Free</option>
                        <option value="RESERVED">Reserved</option>
                      </select>
                      @error('status')
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
@endsection
