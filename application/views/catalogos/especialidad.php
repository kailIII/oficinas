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
                         
                         <table class="table table-bordered table-condensed table-striped table-hover" id="tabla1">
                             <thead>
                                 <tr>
                                     <th>Clave</th>
                                     <th>Sustancia Activa</th>
                                     <th>$ Cos B</th>
                                     <th></th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php
                                $num=0;
                                foreach ($a as $r) {
                                
                                $num=$num+1;
                                ?>
                                <tr>
                                    <td><?php echo $r['clagob'],'<br /><font color="green">'?> <?php echo $r['sec'],'</font>'?></td>
                                    <td style="width: inherit;"><?php echo $r['susa']?></td>
                                    <td style="text-align: right;"><?php echo number_format($r['cos'],2)?></td>
                                    <td style="width: auto ;">
                                    
                                        <table>
                                        <thead>
                                        <tr>
                                        <th>Codigo</th>
                                        <th>Marca Comercial</th>
                                        <th>Costo</th>
                                        <th>% Mayor</th>
                                        <th>Prv</th>
                                        <th>Provedor</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($r['productos'] as $items){
                                            if ($items['por']>0){$por=round($items['por'],2);}else{$por=' ';}?>
                                        
                                            <tr>
                                            <td style="text-align: right;"><?php echo $items['codigo']?></td>
                                            <td style="text-align: left;"><?php echo $items['marca']?></td>
                                            <td style="text-align: right;"><?php echo $items['costo']?></td>
                                            <td style="text-align: right; color: red;"><?php echo $por?></td>
                                            <td style="text-align: right;"><?php echo $items['prv']?></td>
                                            <td style="text-align: left;"><?php echo $items['prvxx']?></td>
                                            
                                            </tr>
                                            
                                        
                                        <?php }?>
                                        </tbody>
                                        </table>
                                    
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                             </tbody>
                         </table>   
                            
                            
                         </div>
                     </div>
                     <!-- END BLANK PAGE PORTLET-->
                 </div>