<div class="container">
	<div class="fluid-row">
		<div class="span7">
			<h2 class="sexy"><span class="muted">HOST:</span> {{ $host->name }}</h2>
			{{ isset($error) ? '<div class="alert">' . $error . '</div>' : '' }}
			<h3>Host Information</h3>
			<table class="table">
				<tr>
					<td><i class="icon-file"></i> MCF Posting</td>
					<td colspan="2">{{ $host->mcf_url ? HTML::link('http://' . $host->mcf_url, substr($host->mcf_url, 0, -2), array('target' => '_blank')) : '<span class="muted">None</span>' }}</td>
				</tr>
				<tr>
					<td><i class="icon-user"></i> MCF Users</td>
					<td colspan="2"><?php
					$names = explode(',', $host->mcf_usernames);
					if (count($names)) {
						$str = '';
						foreach ($names as $name) {
							$str .= HTML::link('http://minecraftforum.net/index.php?app=core&module=search&do=search&search_term=%22' . $name . '%22&search_app=members', $name, array('target' => '_blank')) . ', ';
						}
						echo rtrim($str, ', ');
					} else {
						echo '<span class="muted">None</span>';
					}
					?></td>
				</tr>
				<tr>
					<td><i class="icon-earth"></i> Website</td>
					<td colspan="2">{{ $host->website ? HTML::link('http://' . $host->website, $host->website, array('target' => '_blank')) : '<span class="muted">None</span>' }}</td>
				</tr>
				<tr>
					<td rowspan="{{ max(1, count($notes)) }}"><i class="icon-pencil"></i> Additional Notes</td> <?php $i = 0; ?>
					@if (count($notes))
					@foreach ($notes as $note)
				@if ($i > 0)
				</tr>
				<tr>
				@endif
					<td><b>{{ $note->description }}</b>; {{ $note->comment }}</td>
					<td>Score: {{ $note->score }}</td>
				</tr>
				<?php $i++; ?>
				@endforeach
					@else
					<td><span class="muted">None</span></td>
				</tr>
				@endif
			</table>

			<div class="fluid-row">
				<div class="span3">
					{{ HTML::link('/host/' . $host->slug . '/report', 'Submit Correction', array(
						'class' => 'flatbtn gray'
					)) }}	
				</div>
				<div class="span3">
					{{ HTML::link('/host/' . $host->slug . '/breakdown', 'View Rating Breakdown', array(
						'class' => 'flatbtn red'
					)) }}
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="span5">
			<div class="bsscore @if ($bsrating == 0 and $host->scored) good @endif">
				
				<?php
					if (!$host->scored) {
						echo '<strong>?</strong>Not Yet Rated';
					} else {
						echo '<strong>' . $bsrating . '</strong>';
						if ($bsrating == 0) {
							echo 'No Bullshit';
						} elseif ($bsrating < 10) {
							echo 'Might be Shit';
						} elseif ($bsrating < 20) {
							echo 'Crap Alert';
						} elseif ($bsrating < 30) {
							echo 'Bullshit';
						} else {
							echo 'Full of Shit';
						}
					}
					?></span>
			</div>

			@if ($host->scored)
			<h3>Examination Report</h3>

			<table class="table table-condensed">
				@foreach ($ratings as $rating)
				<tr>
					<td>{{ ucwords(str_replace(array('_', 'whois', 'ssl', 'mcf'), array(' ', 'WHOIS', 'SSL', 'MCF'), $rating->name)) }}</td>
					<td class="@if ($rating->score > 0) text-error @elseif ($rating->score < 0) text-success @else muted @endif">
						@if ($rating->score > 0)
							<strong>{{ $rating->value }}</strong>
						@else
							{{ $rating->value }}
						@endif
					</td>
				</tr>
				@endforeach
			</table>
			@endif
		</div>
	</div>
</div>