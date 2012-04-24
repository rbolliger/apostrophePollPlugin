<?php

$report = $sf_data->getRaw('report');

$objWriter = PHPExcel_IOFactory::createWriter($report, 'Excel5');
$objWriter->save('php://output');
?>

