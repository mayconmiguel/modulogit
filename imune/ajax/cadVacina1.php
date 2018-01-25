<?php
$nome = "vacinas"; $tabela = "pessoa where vacinas = 1";
require_once "../server/seguranca.php";
?>



    <div class="jarviswidget jarviswidget jarviswidget-color-green"  id=cadVacina">

         <header>
             <span class="widget-icon"> <i class="fa fa-table"></i> </span>
             <h2>Cadastro-Vacina</h2>
         </header>
         <div class="widget-body">

                 <div class="panel-body col-xs-12">
                     <div class="row">

                         <div class="col-lg-6 col-md-4 col-xs-12">
                             Nome Comercial<input class="form-control" id="ncomercial" type="text">
                         </div>
                         <div class="col-lg-6 col-md-4 col-xs-12">
                             Nome fantasia<input class="form-control" id="nfantasia" type="text">
                         </div>
                         <div class="col-lg-3 col-md-4 col-xs-5">
                             Laboratorio<input class="form-control" id="laboratorio" type="text">
                         </div>
                         <div class="col-lg-2 col-md-4 col-xs-7">
                             Data Fabricação<input class="form-control" id="datafabricaçao" type="text">
                         </div>
                         <div class="col-lg-4 col-md-4 col-xs-12">
                             Imunobiologico<select class="form-control" id="imunologico">
                             </select>
                         </div>

                         <div class="col-lg-3 col-md-4 col-xs12">
                             Indicação<select class="form-control" id="indicacao">
                             </select>
                         </div>
                         <div class="col-lg-3 col-md-4 col-xs-6">
                             Lote<input class="form-control" id="lote" type="text">
                         </div>
                         <div class="col-lg-3 col-md-4 col-xs-6">
                             Validade<input class="form-control" id="validade" type="text">
                         </div>
                         <div class="col-lg-3 col-md-4 col-xs-6">
                             Quantidade<input class="form-control" id="quantidade" type="text">
                         </div>
                         <div class="col-lg-3 col-md-4 col-xs-6">
                             Valor<input class="form-control" value="R$" id="valor" type="text">
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-lg-1 col-md-4 col-xs-6">
                             Dose<select class="form-control" id="dose">
                             </select>
                         </div>
                         <div class="col-lg-2 col-md-4 col-xs-6">
                             Esquema de Doses
                             <textarea class="form-control"  name="obs" id="obs"></textarea>
                         </div>
                         <div class="col-lg-2 col-md-4 col-xs-12">
                             Estoque Minimo<input class="form-control"  id="estoqueminimo" type="text">
                         </div>
                         <div class="col-lg-2 col-md-4 col-xs-12">
                             Estoque Atual<input class="form-control" id="estoqueatual" type="text">
                         </div>
                         <div class="col-lg-3 col-md-4 col-xs-12">
                             Nota fiscal<input class="form-control" id="nfiscal" type="text">
                         </div>
                         <div class="col-lg-2 col-md-4 col-xs-12">
                             Valor Nota Fiscal<input class="form-control" id="vnfiscal" type="text">
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-lg-12 col-md-4 col-xs-12">
                             Descrição Vacina
                             <textarea class="form-control" name="obs" id="obs"></textarea>
                         </div>
                         <div class="col-lg-2 col-lg-push-10 col-md-2 col-sm-3 col-xs-12">
                            <br> <a id="salvar" class="btn btn-block btn-primary" href="javascript:void(0);">
                        <span class="btn-label">
                            <i class="glyphicon glyphicon-file"></i></span>Salvar</a>
                         </div>
                     </div>

                     <div class="row">
                         <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                             <div class="jarviswidget jarviswidget-color-green" id="historico" data-widget-editbutton="false">
                                 <header>
                                     <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                                     <h2>Historico de Compras</h2>
                                 </header>
                                 <div>
                                     <div class="jarviswidget-editbox">
                                     </div>
                                     <div class="widget-body no-padding">

                                         <table id="datatable_fixed_column" class="table table-striped table-bordered" width="100%">

                                             <thead>

                                                 <th class="hasinput" style="width:15%">
                                                     <div class="input-group">
                                                         <input class="form-control" placeholder="Entrada" type="text">
                                                     </div>
                                                 </th>
                                                 <th class="hasinput" style="width:15%">
                                                     <input type="text" class="form-control" placeholder="Nfiscal" />
                                                 </th>
                                                 <th class="hasinput" style="width:13 %">
                                                     <input type="text" class="form-control" placeholder="Lote" />
                                                 </th>
                                                 <th class="hasinput icon-addon">
                                                     <input id="dateselect_filter" type="text" placeholder="Fabricação" class="form-control datepicker" data-dateformat="yy/mm/dd">
                                                     <label for="dateselect_filter" class="glyphicon glyphicon-calendar no-margin padding-top-17" rel="tooltip" title="" data-original-title="Filter Date"></label>
                                                 </th>
                                                 <th class="hasinput" style="width:15%">
                                                     <input type="text" class="form-control" placeholder="validade" />
                                                 </th>
                                                 <th class="hasinput" style="width:15%">
                                                     <input type="text" class="form-control" placeholder="V.Nfiscal" />
                                                 </th>
                                                 <th class="hasinput" style="width:13%">
                                                     <input type="text" class="form-control" placeholder="Quantidade" />
                                                 </th>
                                             </tr>
                                             <tr>
                                                 <th data-class="expand">Entrada</th>
                                                 <th data-hide="phone">Nfiscal</th>
                                                 <th data-hide="phone">Lote</th>
                                                 <th data-hide="phone,tablet">Fabricação</th>
                                                 <th data-hide="phone">Validade</th>
                                                 <th data-hide="phone,tablet">V.Nfiscal</th>
                                                 <th data-hide="phone">Quantidade</th>
                                             </tr>
                                             </thead>

                                             <tbody>

                                             </tbody>
                                         </table>
                                     </div>
                                 </div>
                             </div>
                     </div>
                     <br>
                     <div class="row" id="botoesCliente">
                         <div class="col-sm-12 center">
                             <a href="javascript:void(0);" id="cadastrar" class="btn btn-sm btn-success"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>CADASTRAR</a>
                             <a href="javascript:void(0);" id="editar" class="btn btn-sm btn-warning hidden"> <span class="btn-label"><i class="glyphicon glyphicon-pencil"></i></span>EDITAR</a>
                             <a href="javascript:void(0);" id="excluir" class="btn btn-sm btn-danger hidden"> <span class="btn-label"><i class="glyphicon glyphicon-remove"></i></span>EXCLUIR</a>
                             <a href="javascript:void(0);" id="cancelar" class="btn btn-sm btn-danger hidden"> <span class="btn-label"><i class="glyphicon glyphicon-repeat"></i></span>CANCELAR</a>
                             <a href="javascript:void(0);" id="salvar" class="btn btn-sm btn-success hidden"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>SALVAR</a>
                         </div>
                     </div>
                 </div>
         </div>
        </article>
    </div>
    </section>
