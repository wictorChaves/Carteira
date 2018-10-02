<?php if ($_pagina['model'] == null) : ?>
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Buscar Funcionário</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php if ($_pagina['model'] == null) : ?>
                <form action="" method="get">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">CPF</label>
                            <input  data-mask="000.000.000-00" type="text" class="form-control" name="cpf" id="exampleInputEmail1" placeholder="Entre com o cpf do funcionário">
                        </div>
                        <?php if (isset($_GET['cpf'])): ?>
                            <?php if ($_GET['cpf'] == ''): ?>
                                <div class="alert alert-info alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h4><i class="icon fa fa-info"></i> Ou!</h4>
                                    Preencha o campo.
                                </div>
                            <?php endif; ?>
                            <?php if ($_GET['cpf'] != ''): ?>
                                <div class="alert alert-info alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h4><i class="icon fa fa-info"></i> Ooops!</h4>
                                    Funcionário não encontrado.
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
        <!-- /.box -->
    </div>
<?php endif; ?>