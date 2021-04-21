<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Unexpected Error</title>
<style type="text/css">

body {
	margin: 40px;
	font: 13px/20px normal Arial, sans-serif;
	color: #4F5155;
}

h1 {
	color: #444;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

#container {
	margin: 10px;
	border: 1px solid #D0D0D0;
	box-shadow: 0 0 8px #D0D0D0;
}

p {
	margin: 12px 15px 12px 15px;
}

#container .trace {
	margin-top: 20px;
	border-top: 1px solid #D0D0D0;
	padding: 10px 10px 5px;
}

#container .trace p {
	margin: 0;
}

#container .trace p.trace-item {
	padding-left: 15px;
}
</style>
</head>
<body>
	<div id="container">
		<h1>An Error Was Unexpected</h1>
		<p><?= $t->getMessage() ?> in <b><?= $t->getFile() ?></b> on line <b><?= $t->getLine() ?></b></p>
		<div class="trace">
			<p class="trace-title">Stack Trace: </p>
		<?php foreach($t->getTrace() as $trace): ?>
			<p class="trace-item"><b><?= $trace['file'] ?></b> on line <b><?= $trace['line'] ?></b></p>
		<?php endforeach; ?>
		</div>
	</div>
</body>
</html>
