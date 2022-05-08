<?php
include 'model.php';

$model = new Model();

if (isset($_POST['date'])) {
    $date = $_POST['date'];
    $rows = $model->fetch_filter_date($date);
}else {
    $rows = $model->fetch();
}

echo json_encode($rows);
?>