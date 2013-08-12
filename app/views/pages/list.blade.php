<?php

function genGet($array) {
	$getstr = '?';
	foreach ($array as $key => $got) {
		$getstr .= $key . '=' . urlencode($got) . '&';
	}
	return rtrim($getstr, '&');
}

?><div class="container">
	<div class="fluid-row">
		<div class="span3"><?php $prev = null; ?>
			<h2 class="sexy">Criteria</h2>
			<table id="criteria_list" class="table table-striped">
			@foreach ($criteria as $c)
			<?php if (strstr(Input::get('names'), urlencode($c->name))) { continue; } ?>
			@if ($c->name != $prev)
				<tr>
					<th colspan="2">
						{{ ucwords(str_replace('_', ' ', $c->name)) }}</h2>
						<?php $prev = $c->name; ?>
					</th>
				<tr>
				@endif
				<tr>
					<td>{{ HTML::link('/list' . genGet(array_merge($_GET, array(
							'criteria' => rtrim($c->id . '-' . Input::get('criteria'), '-'),
							'names' => rtrim($c->name . '-' . Input::get('names'), '-'),
						))), ucwords($c->value)) }}</td>
					<td><span class="label<?php
						if ($c->score <= -3) {
							echo ' label-success';
						} else if ($c->score > 0 && $c->score < 4) {
							echo ' label-warning';
						} elseif ($c->score > 4) {
							echo ' label-important';
						}
					?>">{{ $c->score }}</span></td>
				</tr>
			@endforeach
			</table>
		</div>
		<div class="span9">
			<h2 class="sexy">Hosts</h2>
			<div class="fluid-row" id="orderbar">
				<div class="span3">
					{{ Form::open(array('url' => '/list/autocomplete', 'method' => 'GET')) }}
					<input type="text" id="search" name="query" placeholder="Search by name...">
					{{ Form::close() }}
				</div>
				<div class="span2">
					@if (Input::get('criteria') || Input::get('query'))
					{{ HTML::link('/list', 'Clear Search') }}
					@else
					&nbsp;
					@endif
				</div>
				<div class="span3">
					 {{ Form::select('order', array(
					 	'thescore-asc' => 'Least Bullshitty',
					 	'thescore-desc' => 'Most Bullshitty',
					 	'created_at-asc' => 'Oldest',
					 	'created_at-desc' => 'Newest',
					 ), Input::get('order'), array('id' => 'order')) }}
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
			@if (count($hosts))
			@foreach ($hosts as $host)
			<div class="contentbox" data-slug="{{ $host->slug }}"{{ !$host->scored ? ' style="opacity:0.25"' : '' }}>
				<h1>{{ $host->name }}</h1>
				<div class="bsrating">
					<b>{{ $host->scored ? max(0, $host->thescore) : 'N/S' }}</b>
					<span><?php
					if (!$host->scored) {
						echo 'Not Scored';
					} elseif ($host->thescore < 0) {
						echo 'No Bullshit';
					} elseif ($host->thescore < 5) {
						echo 'Might be Shit';
					} elseif ($host->thescore < 15) {
						echo 'Crap Alert';
					} elseif ($host->thescore < 25) {
						echo 'Bullshit';
					} else {
						echo 'Full of Shit';
					}
					?></span>
				</div>
				{{ HTML::link('/host/' . $host->slug, 'View Details') }}
			</div>
			@endforeach
			@else
			<h2 class="muted" style="margin:100px 0">No hosts found, {{ HTML::link('/list', 'reset your search') }}.</h2>
			@endif
			<div class="clearfix"></div>
			{{ $hosts->links() }}
		</div>
	</div>
</div>