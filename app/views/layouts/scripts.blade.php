	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js') }}
	<script type="text/javascript">window.baseurl = '{{ URL::to('/') }}';</script>
	<?php if (isset($footer_scripts)) {
		foreach ($footer_scripts as $script) {
			echo HTML::script($script) . "\n";
		}
	}
	?>