<div class="container">
	<h2 class="sexy">Request a Host to be rated</h2>
	{{ isset($error) ? '<div class="alert">' . $error . '</div>' : '' }}
	{{ Form::open(array('url' => '/request', 'method' => 'POST', 'class' => 'form-horizontal'))}}

	<div class="control-group">
		{{ Form::label('name', 'Name', array('class' => 'control-label')) }}
		<div class="controls">
			{{ Form::text('name', Input::get('name')) }}
		</div>
	</div>
	<div class="control-group">
		{{ Form::label('website', 'Website', array('class' => 'control-label')) }}
		<div class="controls">
			{{ Form::text('website', Input::get('website')) }}
		</div>
	</div>
	<div class="control-group">
		{{ Form::label('mcf_url', 'MCF Topic URL', array('class' => 'control-label')) }}
		<div class="controls">
			{{ Form::text('mcf_url', '', array('id' => 'mcf_url')) }}
		</div>
	</div>
	<div class="control-group">
		{{ Form::label('rep', 'I am a company rep.', array('class' => 'control-label')) }}
		<div class="controls">
			{{ Form::checkbox('rep', '1'); }}
			<span class="help-block">Companies who voluntarily submit are entitled to an automatic bonus.</span>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			{{ Form::submit('Request', array('class' => 'btn btn-danger')) }}
		</div>
	</div>
</div>