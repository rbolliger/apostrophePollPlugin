<?php

$report = $sf_data->getRaw('report');

 $objWriter = PHPExcel_IOFactory::createWriter($report, 'CSV')
                ->setDelimiter(',')
                ->setEnclosure('"')
                ->setLineEnding("\r\n")
                ->setSheetIndex(0)
                ->save('php://output');

?>

