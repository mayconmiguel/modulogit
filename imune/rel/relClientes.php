<?php
    require_once "../server/seguranca.php";
    @$tipo  = $_GET['tipo'];
    //@$tipo  = 3;


    @$order = $_GET['order'];
    //@$order = 1;

    @$cresc = $_GET['cresc'];
    //@$cresc = 2;
?>
<div id="relatorioClientes">
    <div class="row">
        <div class="col-sm-11">
            <h1>Relatório de Clientes</h1>
            <br>
        </div>
        <div class="col-sm-1">
            <button id="print" class="btn btn-app btn-light btn-xs radius-4">
                <i class="ace-icon fa fa-print"></i>
            </button>
        </div>
        <div class="col-sm-12">
            <div>
                <table id="sample-table-22" class="table table-striped table-bordered table-hover"  >
                    <thead>
                    <tr>
                        <th class="center">ID</th>
                        <th class="center hidden-480">Ficha</th>
                        <th>Nome</th>
                        <th class="hidden-480">CPF</th>
                        <th>Telefone</th>
                        <th>Celular</th>
                        <th class="hidden-480">Status</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $select = "select * from cliente";

                    if($tipo == 0)
                    {
                        $select .= " where status = 0";
                    }
                    elseif($tipo == 1)
                    {
                        $select .= " where status = 1";

                    }
                    elseif($tipo == 2)
                    {
                        $select .= " where status = 2";
                    }
                    elseif($tipo == 3)
                    {
                        $select .= " where status = 3";
                    }
                    elseif($tipo == 4)
                    {
                        $select .= "";
                    };


                    // valida ordenação

                    if($order == 1)
                    {
                        $select .= " order by id";
                    }
                    elseif($order == 2)
                    {
                        $select .= " order by nome";
                    }
                    elseif($order == 3)
                    {
                        $select .= " order by status";
                    };

                    // crescente ou decrescente

                    if($cresc == 1)
                    {
                        $select .= " asc";
                    }
                    elseif($cresc == 2)
                    {
                        $select .= " desc";
                    }
                    $valida = mysqli_query($con,$select);
                    while($row = mysqli_fetch_array($valida))
                    {
                        $id			= $row['id'];
                        $ficha		= $row['ficha'];
                        $nome 		= $row['nome'];
                        $cpf		= $row['cpf'];
                        $telefone 	= $row['telefone'];
                        $celular 	= $row['celular'];
                        $status 	= $row['status'];
                        ?>
                        <?php
                    if($status == 0)
                    {
                        ?>
                        <tr class="muted text-muted" id="prod<?php echo $id;?>">
                        <?php
                    }
                    elseif($status == 1)
                    {
                        ?>
                        <tr class="info text-primary" id="prod<?php echo $id;?>">
                        <?php
                    }
                    elseif($status == 2)
                    {
                        ?>
                        <tr class="success text-success" id="prod<?php echo $id;?>">
                        <?php
                    }
                    elseif($status == 3)
                    {
                        ?>
                        <tr class="danger text-danger" id="prod<?php echo $id;?>">
                            <?php
                            }
                            ?>
                            <td class="center">
                                <?php echo $id;?>
                            </td>

                            <td class="hidden-480">
                                <?php echo $ficha;?>
                            </td>
                            <td>
                                <?php echo $nome;?>
                            </td>
                            <td class="hidden-480">
                                <span id="tdCPF<?php echo $id;?>"><?php echo $cpf;?></span>
                            </td>
                            <td>
                                <span id="tdTelefone<?php echo $id;?>"><?php echo $telefone;?></span>
                            </td>
                            <td>
                                <span id="tdCelular<?php echo $id;?>"><?php echo $celular;?></span>
                            </td>
                            <td class="hidden-480">
                                <?php
                                if($status == 0)
                                {
                                    echo "<span class='text-muted'>Inativo</span>";
                                }
                                elseif($status == 1)
                                {
                                    echo "<span class='text-primary'>Ativo</span>";
                                }
                                elseif($status == 2)
                                {
                                    echo "<span class='text-success'>Concluído</span>";
                                }
                                elseif($status == 3)
                                {
                                    echo "<span class='text-danger'>Faltante</span>";
                                };
                                ?>
                        </tr>
                        <script>
                            //override dialog's title function to allow for HTML titles

                            var SPMaskBehavior = function (val) {
                                    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
                                },
                                spOptions = {
                                    onKeyPress: function(val, e, field, options) {
                                        field.mask(SPMaskBehavior.apply({}, arguments), options);
                                    }
                                };
                            $("#tdCPF<?php echo $id;?>").mask('000.000.000-00', {reverse: true});
                            $('#tdTelefone<?php echo $id;?>').mask(SPMaskBehavior, spOptions);
                            $('#tdCelular<?php echo $id;?>').mask(SPMaskBehavior, spOptions);
                        </script>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $("#print").click(function(){
        $("#loading").show(500);
        $(this).hide();
        $('.ui-dialog-titlebar, #rela, #navbar, #sidebar, #footer').hide();
        window.print();
        $(this).show();
        $('.ui-dialog-titlebar, #rela, #navbar, #sidebar, #footer').show();
        $("#loading").hide(500);
    });
</script>