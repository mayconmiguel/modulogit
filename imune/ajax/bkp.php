<?php
    require_once "../server/seguranca.php";
    $empresa = $_SESSION['imunevacinas']['usuarioEmpresa'];
?>

 <div class="jarviswidget jarviswidget-color-green" id=cadVacina">

    <header>
        <h2>Backup e Tranferencias</h2>
    </header>
    <div class="widget-body">

        <fieldset>
            <div class="form-group">
                <div class="col-md-10">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"> Efetuar Backup
                            </label>
                    </div>
                    <div class="checkbox">
                        <label >
                            <input type="checkbox">
                            Gerar Arquivo SIPNI </label>
                    </div>
                    <div class="col-lg-2 col-lg-push-5 col-md-2 col-sm-3 col-xs-6">
                        <br> <a id="email" class="btn btn-block btn-primary" style="height: 35px; width: 99%; href="javascript:void(0);">
                        <span class="btn-label">
                            <i class="glyphicon glyphicon-file"></i></span>Gerar</a>
                    </div>

                </div>
            </div>


        </fieldset>