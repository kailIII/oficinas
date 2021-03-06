<?php
class Empleados_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function plantilla($f1)
    {
        $aaa = date('Y');
        $s = "select b.id, b.cia,c.puesto, a.nombre as sucx,a.regional,a.superv,a.tipo2,a.suc,a.nombre,a.plantilla,
b.nomina,b.completo,b.puestox,d.nombre_e as regionalx,e.nombre as supervx,
case when f.motivo is null then 'NO' else 'RETENCION' end as motivo
from catalogo.sucursal a
left join catalogo.cat_empleado b on b.succ=a.suc and tipo=1
left join catalogo.cat_puesto c on c.puesto=b.puestox and farmacia='S'
left join catalogo.gerente d on d.ger=a.regional
left join catalogo.supervisor e on e.zona=a.superv
left join catalogo.cat_alta_empleado f on f.empleado=b.nomina and f.motivo='RETENCION' and id_causa<>7
where a.tlid=1 and a.suc>100 and a.suc<=2000
and a.suc<>170
and a.suc<>171
and a.suc<>172
and a.suc<>173
and a.suc<>174
and a.suc<>175
and a.suc<>176
and a.suc<>177
and a.suc<>178
and a.suc<>179
and a.suc<>180
and a.suc<>187
and farmacia='S'
order by puesto";
        $q = $this->db->query($s);
        foreach ($q->result() as $r) {
            $a[$r->regional]['f1'] = $f1;
            $a[$r->regional]['regional'] = $r->regional;
            $a[$r->regional]['regionalx'] = $r->regionalx;
            $a[$r->regional]['m'][$r->superv]['superv'] = $r->superv;
            $a[$r->regional]['m'][$r->superv]['supervx'] = $r->supervx;
            $a[$r->regional]['m'][$r->superv]['segundo'][$r->suc]['suc'] = $r->suc;
            $a[$r->regional]['m'][$r->superv]['segundo'][$r->suc]['sucx'] = $r->sucx;
            $a[$r->regional]['m'][$r->superv]['segundo'][$r->suc]['plantilla'] = $r->plantilla;
            $a[$r->regional]['m'][$r->superv]['segundo'][$r->suc]['tercero'][$r->nomina]['nomina'] = $r->nomina;
            $a[$r->regional]['m'][$r->superv]['segundo'][$r->suc]['tercero'][$r->nomina]['cia'] = $r->cia;
            $a[$r->regional]['m'][$r->superv]['segundo'][$r->suc]['tercero'][$r->nomina]['completo'] = $r->completo;
            $a[$r->regional]['m'][$r->superv]['segundo'][$r->suc]['tercero'][$r->nomina]['puestox'] = trim($r->puestox);
            $a[$r->regional]['m'][$r->superv]['segundo'][$r->suc]['tercero'][$r->nomina]['motivo'] = trim($r->motivo);
            $a[$r->regional]['m'][$r->superv]['segundo'][$r->suc]['tercero'][$r->nomina]['id'] = trim($r->id);
        }
        return $a;
    }
    
    
    function getEvaluacionAreas()
    {
        $query = $this->db->get('desarrollo.evaluacion_areas');
        
        return $query;
    }
    
    function getPreguntas($area)
    {
        $this->db->where('area', $area);
        $query = $this->db->get('desarrollo.evaluacion_cuestionario');
        return $query;
    }
    
    function getRespuestas()
    {
        $query = $this->db->get('desarrollo.evaluacion_respuestas');
        return $query;
    }
    
    function getMotivosDisposicionCombo()
    {
        $query = $this->db->get('desarrollo.evaluacion_motivos_disposicion');
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            $a[$row->motivo] = $row->motivo_texto;
        }
        
        return $a;
    }
    
    function getNumeroDePreguntas()
    {
        $this->db->select_max('pregunta');
        $query = $this->db->get('desarrollo.evaluacion_cuestionario');
        $row = $query->row();
        return $row->pregunta;
    }
    
    function insertEvaluacion($empleado_id, $evaluador, $observaciones_colaborador, $observaciones_evaluador, $motivo, $cuestionario)
    {
        $this->db->trans_start();
        //empleado_id, evaluador, observaciones_colaborador, observaciones_evaluador, motivo, fecha
        $data = array(
            'empleado_id' =>                $empleado_id,
            'evaluador' =>                  $evaluador,
            'observaciones_colaborador' =>  $observaciones_colaborador,
            'observaciones_evaluador' =>    $observaciones_evaluador,
            'motivo' =>                     $motivo
            );
            
        $this->db->insert('desarrollo.evaluacion_aplicadas_control', $data);
        $evaluacion = $this->db->insert_id();
        
        
        //detalle, evaluacion, pregunta, respuesta
        $a = array();
        
        foreach($cuestionario as $row)
        {
            $b = array(
                'evaluacion'    => $evaluacion,
                'pregunta'      => $row['pregunta'],
                'respuesta'      => $row['respuesta']
                );
                
            array_push($a, $b);
        }
        
        $this->db->insert_batch('desarrollo.evaluacion_aplicadas_detalle', $a);

        
        $this->db->trans_complete();
    }
    
    function evaluacion_reporte_header($evaluacion = 1)
    {
        
        $this->load->helper('html');
        $img = array(
          'src' => 'img/logo.png',
          'width' => '200',
        );
        
        $datos = $this->getEvaluacionDatosHeader($evaluacion);
        
        $dato = $datos->row();
        
        $tabla = '
        
        <table cellpadding="2">
            <tr>
                <td colspan="3">'.img($img).'</td>
                <td colspan="3" style="font-size: xx-large;"><b>EVALUACION DE PERSONAL</b></td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td>Nombre: </td>
                <td colspan="2" style="font-size: large; "><b>'. $dato->completo .'</b></td>
                <td>Sucursal: </td>
                <td colspan="2" style="font-size: large; "><b>'. $dato->suc .' - '. $dato->nombre .'</b></td>
            </tr>
            <tr>
                <td>Nomina: </td>
                <td style="font-size: large; "><b>'. $dato->nomina .'</b></td>
                <td>Ingreso: </td>
                <td style="font-size: large; "><b>'. $dato->fechaalta .'</b></td>
                <td>Fecha: </td>
                <td style="font-size: large; "><b>'. $dato->fecha .'</b></td>
            </tr>
            <tr>
                <td>Jefe directo: </td>
                <td colspan="5" style="font-size: large; "><b>'. $this->getEvaluacionSupervisor($evaluacion) .'</b></td>
            </tr>
            <tr>
                <td>Departamento: </td>
                <td colspan="2" style="font-size: large; "><b>AREA COMERCIAL</b></td>
                <td>Puesto a evaluar: </td>
                <td colspan="2" style="font-size: large; "><b>'. $dato->puestox .'</b></td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <td>Evaluaciones: </td>';
                
                
                $respuestas = $this->getRespuestas();
                
                foreach($respuestas->result() as $respuesta)
                {
                    
                    $tabla .= '
                        <td style="font-size: small;"><b>( '. $respuesta->respuesta . ' )</b> <b>' . $respuesta->respuesta_texto . '</b></td>';
                    
                }
                
                $table .= '
                <td>&nbsp;</td>
            </tr>
        </table>';
        
        return $tabla;
    }
    
    function evaluacion_reporte_detalle($evaluacion = 1)
    {
        $tabla = '
        
        <style>
        
        th {
            
            font-weight: bold;
            
            }
        
        td {
            
            border: 0.5px solid #DCDCDC;
            font-size: larger;
            
            }
            
        </style>
        
        <table style="width: 100%;" cellpadding="3">';
        
        $areas = $this->getEvaluacionAreas();
        
        $evaluacion_general = 0;
        
        foreach($areas->result() as $area)
        {
            $tabla .= '<tr bgcolor="#DCDCDC">
                <th colspan="2" style="width: 88%; text-align: center; ">'. $area->descripcion_area.'</th>
                <th style="width: 12%; ">EVALUACI&Oacute;N</th>
            </tr>
                ';
                
                $cuestionario = $this->getEvaluacionPreguntasRespuestas($evaluacion, $area->area);
                
                $total_area = 0;
                
                foreach($cuestionario->result() as $r)
                {
                    $tabla .= '<tr>
                        <td style="width: 8%; text-align: center;">'. $r->pregunta .'</td>
                        <td style="width: 80%; ">'. $r->pregunta_texto .'</td>
                        <td style="width: 12%; text-align: center;"> ( '. $r->respuesta .' )</td>
                    </tr>';
                    
                    $total_area = $total_area + $r->respuesta;
                    $evaluacion_general = $evaluacion_general + $r->respuesta;
                }
            
                    $tabla .= '<tr>
                        <td style="width: 88%; text-align: right;">TOTAL POR AREA DESCRIPTIVA</td>
                        <td style="width: 12%; text-align: center;"><b> '. $total_area .' </b></td>
                    </tr>';
        }
        
                    $tabla .= '<tr>
                        <td style="width: 88%; text-align: right;">EVALUACI&Oacute;N GENERAL</td>
                        <td style="width: 12%; text-align: center;"><b> '. $evaluacion_general .' </b></td>
                    </tr>';

        $tabla .= '</table>';
        
        $tabla .= $this->evaluacion_reporte_footer($evaluacion);
        
        return $tabla;
    }
    
    function evaluacion_reporte_footer($evaluacion)
    {
        
        $foot = $this->getEvaluacionFooter($evaluacion);
        
        $tabla = '<p></p>
        <table style="width: 100%; " cellpadding="2">
            <tr>
                <td style="width: 20%; text-align: center; ">Observaciones<br />colaborador: </td>
                <td style="width: 80%;">'. $foot->observaciones_colaborador .'</td>
            </tr>
            <tr>
                <td style="width: 20%; text-align: center; ">Observaciones<br />evaluador: </td>
                <td style="width: 80%; ">'. $foot->observaciones_evaluador .'</td>
            </tr>
        </table>';
        
        $tabla .= '<p></p>
        
        <p style="text-align: center; font-size: large;">Evalua (Nombre y firma): </p>
        <p style="text-align: center; font-size: large;">'. $this->getEvaluacionSupervisor($evaluacion) .'</p>
        <p style="text-align: right; font-size: large;">GERENCIA DE RECURSOS HUMANOS</p>
        <p style="text-align: right; font-size: small;">Evaluacion realizada: '. $foot->fecha .'</p>
        ';
        
        return $tabla;
    }
    
    function getEvaluacionPreguntasRespuestas($evaluacion, $area)
    {
        $this->db->select('e.pregunta, pregunta_texto, e.respuesta');
        $this->db->from('desarrollo.evaluacion_aplicadas_detalle e');
        $this->db->join('desarrollo.evaluacion_cuestionario c', 'e.pregunta = c.pregunta', 'LEFT');
        $this->db->where('evaluacion', $evaluacion);
        $this->db->where('c.area', $area);
        $this->db->order_by('e.pregunta');
        $query = $this->db->get();
        
        return $query;
    }
    
    function getEvaluacionDatosHeader($evaluacion)
    {
        $this->db->select('completo, s.suc, nombre, c.nomina, fechaalta, date(now()) as fecha, puestox');
        $this->db->from('desarrollo.evaluacion_aplicadas_control e');
        $this->db->join('catalogo.cat_empleado c', 'e.empleado_id = c.id', 'LEFT');
        $this->db->join('catalogo.sucursal s', 'c.succ = s.suc', 'LEFT');
        $this->db->where('e.evaluacion', $evaluacion);
        
        $query = $this->db->get();
        
        return $query;
    }
    
    function getEvaluacionSupervisor($evaluacion)
    {
        $this->db->select('nombre');
        $this->db->from('desarrollo.evaluacion_aplicadas_control e');
        $this->db->join('compras.usuarios u', 'e.evaluador = u.id', 'LEFT');
        $this->db->where('evaluacion', $evaluacion);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            return $row->nombre;
        }else
        {
            return null;
        }
    }
    
    function getEvaluacionFooter($evaluacion)
    {
        $this->db->select('observaciones_colaborador, observaciones_evaluador, fecha');
        $this->db->from('desarrollo.evaluacion_aplicadas_control e');
        $query = $this->db->get();
        return $query->row();
    }
    
    

}
