<h1>
	Login
</h1>
<?php

use app\core\form\Form;

	$form = Form::begin('', 'POST');
	echo $form->field($model, 'email');
	echo $form->field($model, 'password')->passwordField();
?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php
Form::end()

?>