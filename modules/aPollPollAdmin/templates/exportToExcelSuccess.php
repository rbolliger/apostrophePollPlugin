<?php

$report = $sf_data->getRaw('report');

$objWriter = PHPExcel_IOFactory::createWriter($report, $writerFormat);
$objWriter->save('php://output');
?>

