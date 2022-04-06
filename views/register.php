

<h1>
	Register
</h1>
<?php

use app\core\form\Form;

	$form = Form::begin('', 'POST');
	echo $form->field($model, 'firstName');
	echo $form->field($model, 'lastName');
	echo $form->field($model, 'email');
	echo $form->field($model, 'password')->passwordField();
	echo $form->field($model, 'confirmPassword')->passwordField();
?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php
Form::end()

?>