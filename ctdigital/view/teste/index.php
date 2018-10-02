<?php
var_dump($_pagina['model']);
$path = 'http://localhost/carteira/cadfuncionario/images/upload/88888888888';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
echo $base64;
?>
<img src="<?php echo $base64; ?>">