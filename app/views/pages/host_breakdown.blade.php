<table class="table table-striped table-bordered">
	<thead>
		<td>Name</td>
		<td>Value</td>
		<td>Score</td>
	</thead>
	<tbody>
		<?php $prevname = ''; $score = 0; ?>
		@foreach ($ratings as $rating)
		@if ($rating->description && $rating->name != $prevname)
		<tr>
			<td colspan="3"><b>{{ $rating->name }}</b>:{{ $rating->description }}</td>
		</tr>
		@endif
		<?php $prevname = $rating->name; $score += $rating->score; ?>
		<tr>
			<td>{{ $rating->name }}</td>
			<td>{{ $rating->value }}</td>
			<td class="@if ($rating->score > 0) text-error @elseif ($rating->score < 0) text-success @else muted @endif">{{ $rating->score }}</td>
		</tr>
		@endforeach
		@if ($rating->description)
		<tr>
			<td colspan="3">{{ $rating->description }}</td>
		</tr>
		@endif
		@foreach ($notes as $note)
		<tr>
			<td colspan="2"><b>{{ $note->description }}</b>; {{ $note->comment }}</td>
			<td>{{ $note->score }}</td>
		</tr>
		<?php $score += $note->score ?>
		@endforeach
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><b>{{ $score }}</b></td>
		</tr>
	</tbody>
</table>