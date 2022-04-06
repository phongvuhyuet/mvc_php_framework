<h1>Home</h1>
<?php

use app\core\Application;

 if (Application::$app->session->getFlash('success')):
?>
<div class="alert alert-success">
	<?php echo Application::$app->session->getFlash('success')['value']?>
</div>
 <?php endif; ?>