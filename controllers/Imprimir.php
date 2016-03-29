<?php

require '../web/fpdf/fpdf.php';

class Imprimirplanilla extends FPDF {

    function BasicTable($data, $planilla) {
        // Cabecera
        $this->SetFont("Arial", 'B', 15);
        $this->SetFillColor(255, 255, 0);
        $this->Cell(183, 9, "Datos Personales ", 1, 0, 'C', true);
        $this->Ln();
        $this->SetFont("Arial", 'B', 9);
        $this->Cell(183, 9, "Nombre y Apellido: " . $data['nombre']." ".$data['apellido'], 1);
        $this->Ln();
        $this->Cell(61, 9, "Fecha de nacimiento: " . $data['fecha_nac'], 1);
        $this->Cell(61, 9, "DNI " . $data['dni'], 1);
        $this->Cell(61, 9, "Domicilio: " . $data['domicilio'], 1);
        $this->Ln();
        $this->Cell(61, 9, "Telefono: " . $data['telefono'], 1);
        $this->Cell(61, 9, "E-Mail: " . $data['email'], 1);
        $this->Cell(61, 9, "Num de Socio: " . $data['numero_socio'], 1);
        $this->Ln();
        $this->SetFont("Arial", 'B', 15);
        $this->SetFillColor(255, 255, 0);
        $this->Cell(183, 9, "Antecedentes Medicos", 1, 0, 'C', true);
        $this->Ln();
        $this->SetFont("Arial", 'B', 9);
        $this->Cell(61, 9, "Obra Social: " . $planilla['obra_social'], 1);
        $this->Cell(61, 9, "Medico de Cabecera: " . $planilla['medico_cabecera'], 1);
        $this->Cell(61, 9, "Grupo Sanguineo: " . $planilla['grupo_sanguineo'], 1);
        $this->Ln();
        $this->Cell(183, 9, "Toma Medicamentos en forma regular?: " . $planilla['medicamento'], 1);
        $this->Ln();
        $this->Cell(183, 9, "Cuales?: " . $planilla['desc_medicamento'], 1);
        $this->Ln();
        $this->Cell(30, 9, "Alergia?: " . $planilla['alergia'], 1);
        $this->Cell(153, 9, "Cuales?: " . $planilla['desc_alergia'], 1);
        $this->Ln();
        $this->Cell(61, 9, "Anemia: " . $planilla['anemia'], 1);
        $this->Cell(61, 9, "Transtornis hemorragicos?: " . $planilla['trastornos_hemorragicos'], 1);
        $this->Cell(61, 9, "Presion: " . $planilla['presion'], 1);
        $this->Ln();
        $this->Cell(61, 9, "Asma: " . $planilla['asma'], 1);
        $this->Cell(122, 9, "Obs?: " . $planilla['desc_asma'], 1);
        $this->Ln();
        $this->Cell(61, 9, "Enfermedades Cardiologicas?: " . $planilla['enf_cardiologica'], 1);
        $this->Cell(122, 9, "Cuales?: " . $planilla['desc_cardiologia'], 1);
        $this->Ln();
        $this->Cell(61, 9, "Fuma?: " . $planilla['fuma'], 1);
        $this->Cell(122, 9, "cuantos diarios?: " . $planilla['cuanto_fuma'], 1);
        $this->Ln();
        $this->Cell(183, 9, "Tiene alguna enfermedad que requiere tratamineto medico?: " . $planilla['tratamiento'], 1);
        $this->Ln();
        $this->Cell(183, 9, "Cual?: " . $planilla['desc_tratamiento'], 1);
        $this->Ln();
        $this->Cell(183, 9, utf8_decode("Ha sufrido internaciones en los ultimos dos años?: " . $planilla['internaciones']), 1);
        $this->Ln();
        $this->Cell(183, 9, "Por que?: " . $planilla['desc_internacion'], 1);
        $this->Ln();
        $this->SetFont("Arial", 'B', 15);
        $this->SetFillColor(255, 255, 0);
        $this->Cell(183, 9, "Contactos de Emergencia ", 1, 0, 'C', true);
        $this->Ln();
        $this->SetFont("Arial", 'B', 9);
        $this->Cell(183, 9, "Apellido y Nombre: " . $planilla['nombreyapellido1'], 1);
        $this->Ln();
        $this->Cell(91.5, 9, "Domicilio: " . $planilla['domicilio1'], 1);
        $this->Cell(91.5, 9, "Telefono: " . $planilla['telefono1'], 1);
        $this->Ln();
        $this->Cell(183, 3, "", 1);
        $this->Ln();
        $this->Cell(183, 9, "Apellido y Nombre: " . $planilla['nombreyapellido2'], 1);
        $this->Ln();
        $this->Cell(91.5, 9, "Domicilio: " . $planilla['domicilio2'], 1);
        $this->Cell(91.5, 9, "Telefono: " . $planilla['telefono2'], 1);
        $this->Ln();
        $this->Cell(183, 3, "", 0, 0);
        $this->Ln();
        $this->Cell(183, 9, "Observaciones: " . $planilla['observaciones'], 1);
    }

    function Header() {
        $this->SetTitle("Planilla CAE");
        $this->image('../web/imagenes/cae.png', 10, 10, 25);
        $hoy = date("d/m/y");
        $this->SetFont("Arial", 'I', 8);
        $this->Cell(0, 10, 'Fecha: ' . $hoy, 0, 0, "R");
        $this->Ln();
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Cell(30, 10, utf8_decode('Planilla de antecedentes medicos'), 0, 0, 'C');
        $this->Ln(10);
        $this->Cell(80);
        $this->Cell(30, 10, utf8_decode('Club Atletico Estudiantes'), 0, 0, 'C');
        $this->Ln(15);
    }

    function Footer() {

        $this->SetY(-15);
        $this->SetFont("Arial", 'I', 8);
        $this->Cell(0, 0, 'Usuario: ' . Yii::$app->user->identity->nombre_usuario, 0, 0, "L");
        $this->Cell(0, 0, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
        // $this->Cell(0, 10, 'Fecha: '.$hoy, 0, 0, "I");
    }

}

class Imprimireventos extends FPDF {

    function Header() {
        $this->SetTitle("Eventos CAE");
        $this->image('../web/imagenes/cae.png', 10, 10, 25);
        $hoy = date("d/m/y");
        $this->SetFont("Arial", 'I', 8);
        $this->Cell(0, 10, 'Fecha: ' . $hoy, 0, 0, "R");
        $this->Ln();
    }

    function Footer() {

        $this->SetY(-15);
        $this->SetFont("Arial", 'I', 8);
        $this->Cell(0, 0, 'Usuario: ' . Yii::$app->user->identity->nombre_usuario, 0, 0, "L");
        $this->Cell(0, 0, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
        // $this->Cell(0, 10, 'Fecha: '.$hoy, 0, 0, "I");
    }

    function BasicTable($data) {
        // Cabecera
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Cell(30, 10, utf8_decode('Planilla Evento'), 0, 0, 'C');
        $this->Ln(10);
        $this->Cell(80);
        $this->Cell(30, 10, utf8_decode($data['nombre']), 0, 0, 'C');
        $this->Ln(15);
        $this->Ln();
        $this->SetFont("Arial", 'B', 11);
        $this->Cell(91.5, 9, "Deporte: ", 1);
        $this->SetFont("Arial", '', 11);
        $this->Cell(91.5, 9, $data['nombre_deporte'], 1);
        $this->Ln();
        $this->SetFont("Arial", 'B', 11);
        $this->Cell(91.5, 9, 'Condicion:', 1);
        $this->SetFont("Arial", '', 11);
        $this->Cell(91.5, 9, $data['condicion'], 1);
        $this->Ln();
        $this->SetFont("Arial", 'B', 11);
        $this->Cell(91.5, 9, "nombre profesor Titular: ", 1);
        $this->SetFont("Arial", '', 11);
        $this->Cell(91.5, 9, $data['titular'], 1);
        $this->Ln();
        $this->SetFont("Arial", 'B', 11);
        $this->Cell(91.5, 9, "nombre profesor Suplente: " . $data['suplente'], 1);
        $this->SetFont("Arial", '', 11);
        $this->Cell(91.5, 9, $data['suplente'], 1);
        $this->Ln();
        $this->SetFont("Arial", 'B', 11);
        $this->Cell(91.5, 9, "Fecha de inicio: ", 1);
        $this->SetFont("Arial", '', 11);
        $this->Cell(91.5, 9, $data['fecha_inicio'], 1);
        $this->Ln();
        $this->SetFont("Arial", 'B', 11);
        $this->Cell(91.5, 9, "Fecha de fin: ", 1);
        $this->SetFont("Arial", '', 11);
        $this->Cell(91.5, 9, $data['fecha_fin'], 1);
        $this->Ln();
        $this->SetFont("Arial", 'B', 11);
        $this->Cell(91.5, 9, "Observaciones:", 0);
        $this->Ln();
        $this->SetFont("Arial", '', 11);
        $this->MultiCell(183, 9, $data['observaciones'], 1);
        $this->Ln();
    }

    function Convocados($data) {
        // Cabecera
        $this->SetFont("Arial", 'BU', 15);
        $this->Cell(183, 9, "Convocados", 0);
        $this->SetFont("Arial", 'B', 11);
        $this->Ln();
        $this->Cell(61, 9, 'Nombre y Apellido', 1);
        $this->Cell(61, 9, "DNI", 1);
        $this->Cell(61, 9, "Telefono", 1);
        $this->Ln();
        $this->SetFont("Arial", '', 11);
        foreach ($data as $d) {
            $this->Cell(61, 9, $d['nya'], 1);
            $this->Cell(61, 9, $d['dni'], 1);
            $this->Cell(61, 9, $d['telefono'], 1);
            $this->Ln();
        }
    }

}
