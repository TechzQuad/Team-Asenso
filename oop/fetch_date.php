<?php
include 'model.php';

$model = new Model();

$rows = $model->fetch_date();

echo json_encode($rows);

?>