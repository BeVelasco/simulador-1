@extends('simulador.base')

@section('content')

	<div class="row">
		<div class="col-lg-3"></div>
		 @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div><br />
      @endif
		<div class="col-lg6">
			<form action="{{ route('grabarprueba') }}" method="post">
				@csrf
				<fieldset>
					<label>Entrance</label>
					<input type="text" name="entrance_id" value="1">
					<label>User id</label>
					<input type="text" name="user_id" value="">
					<label>Floor</label>
					<input type="text" name="floor" value="15">
					<label>apt_number</label>
					<input type="text" name="apt_number" value="15">
					<label>square_meters</label>
					<input type="text" name="square_meters" value="">
					<label>percent_ideal_parts</label>
					<input type="text" name="percent_ideal_parts" value="15">
					<label>starting_balance</label>
					<input type="text" name="starting_balance" value="-20">
					<label>animals</label>
					<input type="text" name="animals" value="">
					<label>other_information</label>
					<input type="text" name="other_information" value="">
					<label>prueba</label>
					<input type="text" name="prueba" value="dsfdsf">
					<label>hola</label>
					<input type="text" name="hola" value="sdasd">
				</fieldset>
				<button>Registrar</button>
			</form>
		</div>
	</div>

@endsection