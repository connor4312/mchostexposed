<div class="container">
	<h2 class="sexy"><span class="muted">ADMINCP:</span> Login</h2>
	{{ Form::open(array('url' => 'admincp/dologin')) }}
		{{ Form::password('password') }}
		{{ Form::submit('Login', array('class' => 'btn btn-primary')) }}
	{{ Form::close() }}
</div>