<div class="container">
	<h2 class="sexy"><span class="muted">ADMINCP:</span> Dashboard</h2>

	<div class="row-fluid">
		<div class="span4">
			<h2>Correction Requests</h2>
			@if (count($correction_reqs) == 0)
				No correction requests found.
			@else
				<table class="table table-striped table-condensed table-bordered">
					@foreach ($correction_reqs as $correction)
					<tr>
						<td>
							<a href="admincp/correction/{{ $correction->id }}" class="popup btn btn-mini" style="float:right">VIEW</a>
							{{ $correction->host_name }}
						</td>
					</tr>
					@endforeach
				</table>
			@endif
		</div>
		<div class="span4">
			<h2>Host Review Requests</h2>
			@if (count($review_reqs) == 0)
				No host review requests found.
			@else
				<table class="table table-striped table-condensed table-bordered">
					@foreach ($review_reqs as $request)
					<tr>
						<td>
							<a href="admincp/review/{{ $request->id }}" class="popup btn btn-mini" style="float:right">VIEW</a>
							{{ $request->name }}<br>
							<small><a href="http://{{ $request->website }}" target="_blank">{{ $request->website }}</a>
						</td>
					</tr>
					@endforeach
				</table>
			@endif
		</div>
		<div class="span4">
			<h2>Recent Hosts</h2>
			@if (count($hosts) == 0)
				No hosts found.
			@else
				<table class="table table-striped table-bordered">
					@foreach ($hosts as $host)
					<tr>
						<td>
							{{ $host->name }} {{ HTML::link('/admincp/host/' . $host->slug, 'Edit', array('class' => 'btn btn-mini', 'style' => 'float:right'))}}
						</td>
					</tr>
					@endforeach
				</table>
				{{ HTML::link('/admincp/host', 'Add New Host', array('class' => 'btn btn-primary'))}}
				{{ HTML::link('/admincp/host', 'View all Hosts', array('class' => 'btn'))}}
			@endif
		</div>
	</div>
</div>