                 <div class="span12">
                     <!-- BEGIN BLANK PAGE PORTLET-->
                     <div class="widget blue">
                         <div class="widget-title">
                             <h4><i class="icon-reorder"></i> Blank Page </h4>
                           <span class="tools">
                               <a href="javascript:;" class="icon-chevron-down"></a>
                           </span>
                         </div>
                         <div class="widget-body">
<?php
	$atributos = array('id' => 'genera_inv');
    echo form_open('procesos/genera_inv', $atributos);
    $data_fecha = array(
              'name'        => 'fecha',
              'id'          => 'fecha',
              'value'       => '',
              'maxlength'   => '10',
              'size'        => '10'
              
            );
    $data_sem = array(
              'name'        => 'sem',
              'id'          => 'sem',
              'value'       => '',
              'maxlength'   => '2',
              'size'        => '2'
              
            );
    
  ?>
 
  <table>

<tr>
<td colspan="2">UNA VEZ GENERADO ESTE PROCESO DE INVENTARIO BORRARA EL ARCHIVO ANTERIOR</td>
</tr>
<tr>
    <td align="left" ><font size="+1"><strong>Fecha: </strong></font></td>
	<td><?php echo form_input($data_fecha, "", 'required');?> AAAA-MM-DD</td>
</tr>
<tr>
    <td align="left" ><font size="+1"><strong>SEMANA: </strong></font></td>
	<td><?php echo form_input($data_sem, "", 'required');?></td>
</tr>
<tr>
	<td colspan="2"align="center"><?php echo form_submit('envio', 'GENERAR');?></td>
</tr>
</table>
  <?php
 
	echo form_close();
if($q->num_rows()>0){
$ac=$q->row();
if(($ac->mes==1 and $ac->dia==31) ||($ac->mes==2 and $ac->dia==28) ||($ac->mes==3 and $ac->dia==31) ||
($ac->mes==4 and $ac->dia==30) ||($ac->mes==5 and $ac->dia==31) ||($ac->mes==6 and $ac->dia==30) ||
($ac->mes==7 and $ac->dia==31) ||($ac->mes==8 and $ac->dia==31) ||($ac->mes==9 and $ac->dia==30) ||
($ac->mes==10 and $ac->dia==31) ||($ac->mes==11 and $ac->dia==30) ||($ac->mes==12 and $ac->dia==31)){
$l0 = anchor('procesos/respalda_inv/'.$ac->aaa.'/'.$ac->mes.'/'.$ac->dia,'Respaldo</a>', array('title' => 'Haz Click aqui para ver detalle!', 'class' => 'encabezado'));
}else{
$l0=' ';
}
  ?>

<table class="table table-bordered table-condensed table-striped table-hover" id="tabla">
                             <thead>
                             <tr><th colspan="5">ULTIMO INVENTARIO GENERADO</th></tr>
                             <tr>
                                <td colspan="2" style=" color:blue"><?php echo $ac->aaa.'-'.$ac->mes.'-'.$ac->dia.' Piezas Generadas '.number_format($ac->piezas,0)?></td>
                                <td colspan="2"  style=" color:blue"><?php echo 'Sucursales Contabilizadas '.number_format($ac->numero,0).' Importe: '.number_format($ac->importe,2)?></td>
                                <td style=" color:blue"><?php echo $l0?></td>
                                </tr>
                             <tr>
                             <th colspan="1">#</th>
                             <th colspan="1">Fecha</th>
                             <th colspan="1">Sucursal</th>
                             <th colspan="1">Piezas</th>
                             <th colspan="1">Importe</th>
                             </tr>
                             </thead>
                                
                                <tbody>
                                 <?php
                                $color='green';$nume=0;
                               foreach ($b->result()as $rb){
                                $nume=$nume+1;
                               ?>
                               <tr>
                                <td style="color:<?php echo $color?>; text-align: left"><?php echo $nume?></td>
                                <td style="color:<?php echo $color?>; text-align: left"><?php echo $rb->aaa.'-'.$rb->mes.'-'.$rb->dia?></td>
                                <td style="color:<?php echo $color?>; text-align: left"><?php echo number_format($rb->numero,0)?></td>
                                <td style="color:<?php echo $color?>; text-align: left"><?php echo number_format($rb->piezas,0)?></td>
                                <td style="color:<?php echo $color?>; text-align: left"><?php echo number_format($rb->importe,2)?></td>
                                </tr>
                               <?php
                               }
                               ?>
                                </tbody>
                                
                                 </table>
<?php }?>
<table class="table table-bordered table-condensed table-striped table-hover" id="tabla1">
                                <thead>
                                    <tr>
                                     <th>#</th>   
                                     <th style="text-align: left">Fecha</th> 
                                     <th style="text-align: left">Nid</th>
                                     <th style="text-align: left">Sucursal</th>
                                     <th style="color:gray; text-align: right">piezas</th>
                                 </tr>
                             </thead>
                             <tbody>
                             
                                 <?php
                               $color='gray';$num=0;
                               foreach ($a->result()as $r){
                                $num=$num+1;
                               ?>
                                <tr>
                                <td style="color:<?php echo $color?>; text-align: left"><?php echo $num?></td>
                                <td style="color:<?php echo $color?>; text-align: left"><?php echo $r->fecha?></td>
                                <td style="color:<?php echo $color?>; text-align: left"><?php echo $r->suc?></td>
                                <td style="color:<?php echo $color?>; text-align: left"><?php echo $r->nombre?></td>
                                <td style="color:<?php echo $color?>; text-align: left"><?php echo $r->inv?></td>
                                </tr>
                               <?php 
                             
                                } ?>
                              </tbody>
                              <tfoot>
                           
                             </tfoot>
                         </table>
<!----> 
                          
                         </div>
                     </div>
                     <!-- END BLANK PAGE PORTLET-->
                 </div>