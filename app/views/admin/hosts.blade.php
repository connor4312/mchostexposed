<div class="container">
	<h2 class="sexy"><span class="muted">Post:</span> Host Details</h2>
	{{ isset($error) ? '<div class="alert">' . $error . '</div>' : '' }}
	{{ Form::open(array('url' => '/admincp/host', 'method' => 'POST', 'class' => 'form-horizontal'))}}
	@if ($edit)
	<input type="hidden" name="edit" value="{{ $edit }}">
	@endif
	<div class="control-group">
		{{ Form::label('name', 'Name', array('class' => 'control-label')) }}
		<div class="controls">
			{{ Form::text('name', $params['name']) }}
		</div>
	</div>
	<div class="control-group">
		{{ Form::label('slug', 'Slug', array('class' => 'control-label')) }}
		<div class="controls">
			{{ Form::text('slug', $params['slug']) }}
		</div>
	</div>
	<div class="control-group">
		{{ Form::label('website', 'Website', array('class' => 'control-label')) }}
		<div class="controls">
			{{ Form::text('website', $params['website']) }}
			<span class="help-block">No http://!</span>
		</div>
	</div>
	<div class="control-group">
		{{ Form::label('mcf_url', 'MCF Topic URL', array('class' => 'control-label')) }}
		<div class="controls">
			{{ Form::text('mcf_url', $params['mcf_url']) }}
			<span class="help-block">No http://!</span>
		</div>
	</div>
	<div class="control-group">
		{{ Form::label('mcf_usernames', 'MCF Usernames', array('class' => 'control-label')) }}
		<div class="controls">
			{{ Form::text('mcf_usernames', $params['mcf_usernames']) }}
			<span class="help-block">Seperate by commas, no spaces.</span>
		</div>
	</div>
	<div class="control-group">
		{{ Form::label('paypal_email', 'PayPal Email', array('class' => 'control-label')) }}
		<div class="controls">
			{{ Form::email('paypal_email', $params['paypal_email']) }}
		</div>
	</div>
	<div class="control-group">
		{{ Form::label('scored', 'Scored', array('class' => 'control-label')) }}
		<div class="controls">
			{{ Form::checkbox('scored', '1', $params['scored']) }}
		</div>
	</div>
	<h2 class="sexy"><span class="muted">Post:</span> Criteria</h2>
	<?php
	$name = '';
	$thread = array();
	$select = 'null';

	foreach ($criteria as $crits) {
		if ($name && $name != $crits->name) {
			echo '
				<div class="control-group">
					' . Form::label('criteria[' . $name . ']', $name, array('class' => 'control-label')) . '
					<div class="controls">
						' . Form::select('criteria[' . $name . ']',  array('null' => '') + $thread, $select) . '
					</div>
				</div>
			';
			$thread = array();
			$select = 'null';
		}
		$name = $crits->name;
		$thread[$crits->id] = $crits->value . ' (' . $crits->score . ')';
		if (in_array($crits->id, $host_criteria)) {
			$select = $crits->id;
		}
	}
	echo '
		<div class="control-group">
			' . Form::label('criteria[' . $name . ']', $name, array('class' => 'control-label')) . '
			<div class="controls">
				' . Form::select('criteria[' . $name . ']',  array('null' => '') + $thread,  $select) . '
			</div>
		</div>
	';
	$name = $crits->name;
	$thread = array();
	?>
	<h2 class="sexy"><span class="muted">Post:</span> Additional Notes</h2>
	<table class="table table-striped table-bordered">
		<thead>
			<td>Score</td>
			<td>Description</td>
			<td>Comment</td>
		</thead>
		<tbody>
		@for ($i = 0; $i < 5; $i++)
		@if (isset($notes[$i]))
			<tr>
				<td>{{ Form::text('note_score[]', $notes[$i]->score) }}</td>
				<td>{{ Form::text('note_description[]', $notes[$i]->description) }}</td>
				<td>{{ Form::text('note_comment[]', $notes[$i]->comment) }}</td>
			</tr>
		@else
			<tr>
				<td>{{ Form::text('note_score[]', '') }}</td>
				<td>{{ Form::text('note_description[]', '') }}</td>
				<td>{{ Form::text('note_comment[]', '') }}</td>
			</tr>
		@endif
		@endfor
		</tbody>
	</table>
	<div class="control-group">
		<div class="controls">
			{{ Form::submit('Add', array('class' => 'btn btn-danger')) }}
		</div>
	</div>
</div>