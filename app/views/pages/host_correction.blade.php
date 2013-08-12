{{ Form::open(array('url' => '/host/' . $host->slug . '/report', 'method' => 'POST', 'class' => 'form-horizontal'))}}

<div class="control-group">
	{{ Form::label('criteria_linkid', 'Incorrect Value', array('class' => 'control-label')) }}
	<div class="controls"> <?php
		$arr = array();
		foreach ($criteria as $crit) {
			$arr[$crit->id] = $crit->name . ': ' . $crit->value;
		}
		?>
		{{ Form::select('criteria_linkid', $arr) }}
	</div>
</div>
<div class="control-group">
	{{ Form::label('should_be', 'Correct Value', array('class' => 'control-label')) }}
	<div class="controls">
		{{ Form::text('should_be', Input::get('should_be')) }}
	</div>
</div>

<div class="control-group">
	<div class="controls">
		{{ Form::submit('Request', array('class' => 'btn btn-danger')) }}
	</div>
</div>
{{ Form::close() }}