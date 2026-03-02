<?php

namespace App\Exports;

use App\Models\Asistencia;
use App\Models\Estudiante;
use App\Models\Encargado;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Events\AfterSheet;

class BitacoraEstudianteExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $estudiante;
    protected $encargado;

    public function __construct($estudiante_id)
    {
        $this->estudiante = Estudiante::with('user')->findOrFail($estudiante_id);
        
        // Obtener el primer encargado activo de la base de datos
        $this->encargado = Encargado::where('estatus', 1)->first();
    }

    public function collection()
    {
        $asistencias = Asistencia::with('actividades')
            ->where('estudiante_id', $this->estudiante->id)
            ->orderBy('fecha')
            ->get();
        
        $data = [];
        
        foreach ($asistencias as $asistencia) {
            foreach ($asistencia->actividades as $actividad) {
                $data[] = [
                    'fecha' => \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y'),
                    'actividad' => $actividad->nombre,
                    'descripcion' => $actividad->descripcion,
                    'horas' => $actividad->horas,
                    'firma' => ''  // Espacio vacío para firma
                ];
            }
        }
        
        // Si no hay actividades, agregar una fila vacía
        if (empty($data)) {
            $data[] = [
                'fecha' => '',
                'actividad' => 'No hay actividades registradas',
                'descripcion' => '',
                'horas' => '',
                'firma' => ''
            ];
        }
        
        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'Actividad',
            'Descripción',
            'Horas',
            'Firma del Encargado'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function ($event) {
                $sheet = $event->sheet->getDelegate();
                
                // Construir el nombre completo del estudiante
                $nombreCompleto = 'Sin nombre';
                if ($this->estudiante->user) {
                    $nombreCompleto = trim(
                        $this->estudiante->user->nombre . ' ' . 
                        $this->estudiante->user->apellido_paterno . ' ' . 
                        $this->estudiante->user->apellido_materno
                    );
                }
                
                // Datos del encargado
                $nombreEncargado = 'No asignado';
                $areaEncargado = 'No asignada';
                
                if ($this->encargado) {
                    // Si el encargado tiene relación con user
                    if ($this->encargado->user) {
                        $nombreEncargado = trim(
                            $this->encargado->user->nombre . ' ' . 
                            $this->encargado->user->apellido_paterno . ' ' . 
                            $this->encargado->user->apellido_materno
                        );
                    } else {
                        $nombreEncargado = 'Encargado ID: ' . $this->encargado->id;
                    }
                    
                    $areaEncargado = $this->encargado->area ?? 'No asignada';
                }
                
                // Limpiar cualquier dato existente en las primeras filas
                for ($row = 1; $row <= 10; $row++) {
                    for ($col = 'A'; $col <= 'E'; $col++) {
                        $sheet->setCellValue($col . $row, '');
                    }
                }
                
                // ===== TÍTULO =====
                $sheet->mergeCells('A1:E1');
                $sheet->setCellValue('A1', 'BITÁCORA DE SERVICIO SOCIAL / PRÁCTICAS');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // ===== DATOS DEL ESTUDIANTE =====
                // Fila 3
                $sheet->setCellValue('A3', 'Nombre del Estudiante:');
                $sheet->mergeCells('B3:C3');
                $sheet->setCellValue('B3', $nombreCompleto);
                $sheet->setCellValue('D3', 'Horas Requeridas:');
                $sheet->setCellValue('E3', $this->estudiante->horas_requeridas ?? '340');
                
                // Fila 4
                $sheet->setCellValue('A4', 'Matrícula:');
                $sheet->mergeCells('B4:C4');
                $sheet->setCellValue('B4', $this->estudiante->matricula ?? '2524260012');
                // Forzar alineación izquierda para la matrícula
                $sheet->getStyle('B4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                
                $sheet->setCellValue('D4', 'Horas Acumuladas:');
                $sheet->setCellValue('E4', $this->estudiante->horas_actuales ?? '20');
                
                // Fila 5
                $sheet->setCellValue('A5', 'Carrera:');
                $sheet->mergeCells('B5:C5');
                $sheet->setCellValue('B5', $this->estudiante->carrera ?? 'Programación');
                
                // Fila 6
                $sheet->setCellValue('A6', 'Escuela:');
                $sheet->mergeCells('B6:C6');
                $sheet->setCellValue('B6', $this->estudiante->escuela ?? 'CECyTEH');
                
                // ===== ÁREA ASIGNADA Y ENCARGADO EN COLUMNA DERECHA =====
                // Fila 5 - Área Asignada (junto a Carrera)
                $sheet->setCellValue('D5', 'Área Asignada:');
                $sheet->setCellValue('E5', $areaEncargado);
                
                // Fila 6 - Nombre del Encargado (junto a Escuela)
                $sheet->setCellValue('D6', 'Encargado:');
                $sheet->setCellValue('E6', $nombreEncargado);
                
                // Aplicar negritas a las etiquetas
                $sheet->getStyle('A3:A6')->getFont()->setBold(true);
                $sheet->getStyle('D3:D6')->getFont()->setBold(true);
                
                // Aplicar bordes a los datos del estudiante
                $sheet->getStyle('A3:E6')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                
                // Asegurar que todos los textos en las columnas B, C y E estén alineados a la izquierda
                $sheet->getStyle('B3:C6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('E3:E6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                
                // ===== ENCABEZADOS DE TABLA =====
                // Mover los encabezados a la fila 8
                $headings = $this->headings();
                $col = 'A';
                foreach ($headings as $heading) {
                    $sheet->setCellValue($col . '8', $heading);
                    $sheet->getStyle($col . '8')->getFont()->setBold(true);
                    $sheet->getStyle($col . '8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle($col . '8')->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('FFE0E0E0');
                    $col++;
                }

                // ===== OBTENER LOS DATOS =====
                $collection = $this->collection();
                $currentRow = 9;
                
                foreach ($collection as $item) {
                    $sheet->setCellValue('A' . $currentRow, $item['fecha']);
                    $sheet->setCellValue('B' . $currentRow, $item['actividad']);
                    $sheet->setCellValue('C' . $currentRow, $item['descripcion']);
                    $sheet->setCellValue('D' . $currentRow, $item['horas']);
                    $sheet->setCellValue('E' . $currentRow, $item['firma']);
                    
                    // Ajustar altura de fila automáticamente
                    $sheet->getRowDimension($currentRow)->setRowHeight(-1);
                    
                    $currentRow++;
                }
                
                $lastRow = $currentRow - 1;
                
                // ===== APLICAR BORDES A LA TABLA =====
                if ($lastRow >= 8) {
                    $sheet->getStyle('A8:E' . $lastRow)
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle(Border::BORDER_THIN);
                }

                // ===== TOTAL DE HORAS =====
                $totalRow = $lastRow + 2;
                
                $sheet->setCellValue('A' . $totalRow, 'TOTAL DE HORAS:');
                $sheet->mergeCells('A' . $totalRow . ':C' . $totalRow);
                
                // Calcular el total de horas
                $totalHoras = 0;
                foreach ($collection as $item) {
                    if (is_numeric($item['horas'])) {
                        $totalHoras += $item['horas'];
                    }
                }
                
                $sheet->setCellValue('D' . $totalRow, $totalHoras);
                $sheet->getStyle('A' . $totalRow . ':D' . $totalRow)->getFont()->setBold(true);
                $sheet->getStyle('A' . $totalRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                // ===== AJUSTAR ANCHO DE COLUMNAS - MÁS ESPACIOSAS =====
                $sheet->getColumnDimension('A')->setWidth(15);  // Fecha (igual)
                $sheet->getColumnDimension('B')->setWidth(40);  // Actividad (aumentado de 35 a 40)
                $sheet->getColumnDimension('C')->setWidth(60);  // Descripción (aumentado de 50 a 60)
                $sheet->getColumnDimension('D')->setWidth(12);  // Horas (igual)
                $sheet->getColumnDimension('E')->setWidth(45);  // Firma (aumentado de 30 a 45 - MÁS ESPACIO PARA FIRMAR)
                
                // ===== ALTURA DE FILAS - MÁS ALTAS PARA ESPACIO DE FIRMA =====
                // Aumentar altura de las filas de datos para tener más espacio para firmar
                for ($row = 9; $row <= $lastRow; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(30); // Altura fija de 30 píxeles (antes era automática)
                }
                
                // Aumentar también la altura de la fila de encabezados
                $sheet->getRowDimension(8)->setRowHeight(25);
                
                // ===== CENTRAR VERTICALMENTE EL CONTENIDO =====
                $sheet->getStyle('A8:E' . $lastRow)
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);
                
                // Habilitar autoajuste de texto para todas las celdas
                $sheet->getStyle('A1:E' . $totalRow)
                    ->getAlignment()
                    ->setWrapText(true);
                
                // ===== BORDES MÁS GRUESOS PARA LA COLUMNA DE FIRMA (OPCIONAL) =====
                // Puedes agregar un borde izquierdo más grueso para resaltar la columna de firma
                $sheet->getStyle('E8:E' . $lastRow)
                    ->getBorders()
                    ->getLeft()
                    ->setBorderStyle(Border::BORDER_MEDIUM);
            }
        ];
    }
}
