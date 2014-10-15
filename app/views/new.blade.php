@section('content')

<h1>{{ Lang::get('gallery::gallery.create') . ' ' . Lang::choice("gallery::gallery.$type", 1) }}</h1>

@if ($errors->any())
	<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<strong>Oh snapp!</strong> There were some errors:
		<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
		</ul>
	</div>
@endif

{{ $form }}

@stop


