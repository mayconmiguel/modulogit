<?php
require_once "../server/seguranca.php";
?>

<div class="jarviswidget jarviswidget-color-green" id="atendimentoDomicilio">

        <header>
            <span class="widget-icon"> <i class="fa fa-table"></i> </span>
            <h2>Vacinação - Cadastro</h2>
        </header>
        <div>
            <div class="widget-body">

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            Data Aplicação<input class="form-control" id="valor" type="text">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            Horario:<input class="form-control"  id="empresa">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            Aplicador<select class="form-control" id="formapagamento">
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-3">
                            Vacina<select class="form-control" id="vacina">
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-3">
                            tipo<select class="form-control" id="tipo">
                                <option value="adulto">ADULTO</option>
                                <option value="infantil">INFANTIL</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-3 col-sm-3">
                            Lote<input class="form-control" id="lote" type="text">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            Validade<input class="form-control" id="validade" type="text">
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6">
                            Dose<select class="form-control" id="dose">
                                <option value="dose">1</option>
                                <option value="dose">2</option>
                                <option value="dose">3</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6">
                            Valor<input class="form-control" value="R$:" id="valor" type="text">
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-lg-3 col-md-3 col-sm-4">
                            Forma Pagamento<select class="form-control" id="formapagamento">
                                <option value="dinheiro">DINHEIRO</option>
                                <option value="cartao">CARTÃO CRÉDITO</option>
                                <option value="cartao">CARTÃO DÉBITO</option>
                            </select>

                        </div>
                        <div class="col-lg-2 col-md-1 col-sm-4">
                            Parcelas<select class="form-control" id="parcela">
                                <option value="parcelas">1</option>
                                <option value="parcelas">2</option>
                                <option value="parcelas">3</option>
                                <option value="parcelas">4</option>
                                <option value="parcelas">5</option>
                                <option value="parcelas">6</option>
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-4">
                            Taxa Domicilia<input class="form-control" value="R$:" id="empresa">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <br>Observações
                            <textarea class="form-control" name="obs" id="obs"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-3">
                        <br><a id="novo" class="btn btn-block btn-primary" href="javascript:void(0);">
                         <span class="btn-label">
                           <i class="glyphicon glyphicon-file"></i>
                         </span>
                            Imprimir
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-3">
                       <br> <a id="novo" class="btn btn-block btn-primary" href="javascript:void(0);">
                          <span class="btn-label">
                              <i class="glyphicon glyphicon-file"></i>
                          </span>
                           Salvar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>