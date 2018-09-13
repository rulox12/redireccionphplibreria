@extends('layout')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-header">
    Create transaction
  </div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post" action="{{ route('transacciones.store') }}">
          <div class="form-group">
              @csrf
              <label for="name">Reference:</label>
              <input type="text" class="form-control" name="reference"/>
          </div>
          <div class="form-group">
              <label for="price">Description :</label>
              <input type="text" class="form-control" name="description"/>
          </div>
          <div class="form-group">
              <label for="quantity">Total value:</label>
              <input type="text" class="form-control" name="total"/>
          </div>
          <button type="submit" class="btn btn-primary">Crear transaccion</button>
      </form>
  </div>
</div>
@endsection