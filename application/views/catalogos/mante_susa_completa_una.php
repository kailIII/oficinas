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
                          
                         <table class="table table-bordered table-condensed table-striped table-hover" id="tabla">
                        
                          <?php if($a->num_rows()>0){ $rr=$a->row();?>
                           <tr>
                           <th><?php echo $rr->susa?></th>
                           </tr> 
                          <?php } ?>
                         
                         </table>
 <table class="table table-bordered table-condensed table-striped table-hover" id="tabla1">
                             <thead>
                               <tr>
                               <th style="text-align: left;">Codigo</th>
                               <th style="text-align: left;">Clave Gob</th>
                               <th style="text-align: left;">Sec Cedis</th>
                               <th style="text-align: left;">Sustancia Activa</th>
                               <th style="text-align: left;">Gramaje</th>
                               <th style="text-align: left;">Contenido</th>
                               <th style="text-align: left;">Presentacion</th>
                               <th style="text-align: left;">Marca Comercial</th>
                               <th style="text-align: left;">Laboratorio</th>
                               <th style="text-align: left;">Registro</th>
                               </tr>  
                             </thead>
                             <tbody>
                                 <?php
                                 $num=0;
                                 foreach ($q->result()as $r){
                                $num=$num+1;
                                $l0=anchor('mercadotecnia/mante_susa_una/'.$r->id,$r->codigo.'</a>', array('title' => 'Haz Click aqui para ver detalle!', 'class' => 'encabezado'));
                                
                                 ?> 
                                 <tr>
                                   <td style="text-align: left;"><?php echo $l0?></td>
                                   <td style="text-align: left;"><?php echo $r->prv?></td>
                                   <td style="text-align: left;"><?php echo $r->prvxx?></td>
                                   <td style="text-align: left;"><?php echo trim($r->costo)?></td>
                                   <td style="text-align: left;"><?php echo trim($r->farmacia)?></td>
                                   <td style="text-align: left;"><?php echo trim($r->preferencia)?></td>                                  
                                 </tr> 
                           
                             
                               
                              
                                 
                               <?php } ?> 
                              </tbody>
                              <tfoot>
                              </tfoot>
                         </table>
<!----> 
                          
                         </div>
                     </div>
                     <!-- END BLANK PAGE PORTLET-->
                 </div>