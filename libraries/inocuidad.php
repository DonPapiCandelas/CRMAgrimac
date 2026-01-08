<?php
    require __DIR__ . "/vendor/autoload.php";
    require '../includes/database/Cache.php';
    require '../includes/database/DatabaseInterface.php';
    require '../includes/database-sql/MyPDO.php';
    require '../includes/database-sql/SQLDatabase.php';

    if(count($_POST) > 0) {
        $db = new SQLDatabase();
        $producto = $db->select('e.*, e.[FECHA DE CADUCIDAD] AS CADUCIDAD, p.*')->table('vwLBSProductList AS p')->fullOuterJoin('orgProductExt AS e', 'p.ProductID', 'e.IDExtra')->where("ProductID", $_POST['R_Producto'])->get();
        $movimientos = $db->table('vwCSTControl')->where('ProductID', $_POST['R_Producto'])->between('DateTransaction', $_POST['R_FechaInicio'], $_POST['R_FechaFinal'])->orderBy('DateTransaction')->getAll();

        // Leyendo Formato
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('Inocuidad_'. $_POST['R_Empresa'] .'.xlsx');
        $sheet = $spreadsheet->getActiveSheet();

        if($_POST['R_Formato'] == 'pdf') {
            // Configurando Estilo Formato
            $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
            $spreadsheet->getActiveSheet()->getPageSetup()->setPrintArea('A1:M' . $spreadsheet->getActiveSheet()->getHighestRow());
            $spreadsheet->getActiveSheet()->getStyle('A1:M' . $spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
            $spreadsheet->getDefaultStyle()->getFont()->setName('Calibri')->setSize(8);

            // Configurando Tamaño Columnas
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(17);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(12);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(10);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(10);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(12);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(12);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(10);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(14);
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(14);
            $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(16);
            $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(12);
            $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(20);
            $spreadsheet->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1,12);
        }        

        // Cargando Logo en el Formato
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath(__DIR__ . '/images/logo_'. $_POST['R_Empresa'] .'.jpg');
        $drawing->setCoordinates('A1');
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        $Emision = date('Y');
        $Vigencia = date('Y', strtotime('+1 year'));

        // Rellando Datos en la hoja
        $sheet
            ->setCellValue('D3', 'REALIZA: '. $_POST['R_Realiza'])
            ->setCellValue('D4', 'REVISA: '. $_POST['R_Revisa'])
            ->setCellValue('D5', 'EMISION: ' . $Emision)
            ->setCellValue('J5', 'VIGENCIA: ' . $Vigencia)
            ->setCellValue('B8', $producto['ProductName'])
            ->setCellValue('G8', $producto['INGREDIENTE ACTIVO'] . $producto['INGREDIETNTE ACTIVO 2'])
            ->setCellValue('L8', $_POST['R_Responsable'])
            ->setCellValue('B10', $producto['INTERVALO DE SEGURIDAD'])
            ->setCellValue('G10', $producto['TIEMPO DE REENTRADA'])
            ->setCellValue('J10', $_POST['R_Cultivos'])
            ->setCellValue('J4', 'PRODUCTO: '. $producto['ProductName']);

        $contador = 13;
        $saldo = 0;
        foreach ($movimientos as $key) {
            $saldo = $saldo + $key['Quantity'];
            $Entrada = number_format(($key['Quantity'] < 0) ? 0 : $key['Quantity'], 0, '.', ',');
            $Salida = number_format(($key['Quantity'] < 0) ? $key['QuantityDoc']: 0, 0, '.', ',');
            $Saldo = number_format($saldo, 0, '.', ',');

            $stampCaducidad = strtotime($key['Caducidad']);
            $Caducidad = ($stampCaducidad > 0) ? date('d/m/Y', $stampCaducidad) : "S/D";

            $sheet
                ->setCellValue('A' . $contador, $key['CostCenterName'])
                ->setCellValue('B' . $contador, date('d/m/Y', strtotime($key['DateTransaction'])))
                ->setCellValue('C' . $contador, $Entrada)
                ->setCellValue('D' . $contador, $Salida)
                ->setCellValue('E' . $contador, $key['Recibio'])
                ->setCellValue('F' . $contador, $key['Entrego'])
                ->setCellValue('G' . $contador, $Saldo)
                ->setCellValue('H' . $contador, $Caducidad)
                ->setCellValue('I' . $contador, $key['PROVEEDOR'])
                ->setCellValue('J' . $contador, $key['FORMULACION'])
                ->setCellValue('K' . $contador, $key['PRESENTACION'])
                ->setCellValue('L' . $contador, $key['LoteProducto'])
                ->setCellValue('M' . $contador, $key['RSCO']);
            $contador++;
        }
        
        // Inicializando el controlador para la exportacion
        if($_POST['R_Formato'] == 'pdf') {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($spreadsheet);
        } else {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        }        

        ob_start();
        $writer->save('php://output');
        $docData = ob_get_contents();
        ob_end_clean();

        $docType = ($_POST['R_Formato'] == 'pdf') ? 'application/pdf' : 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

        $resultado = array(
            'data' => 'data:'. $docType .';base64,'. base64_encode($docData)
        );
        echo json_encode($resultado);
        exit;  
    }