<div id="cadFuncionario" class="box box-primary">
    <form id="empresa" data-parsley-validate name="asyncoff" method="post" action="#" role="form" novalidate>
        <div class="box-body">
            <div class="form-group">
                <label>CNPJ*</label>
                <input value="" data-mask="00.000.000/0000-00" type="text" name="cnpj" class="form-control" placeholder="Entre com CNPJ" data-parsley-required-message="Campo obrigatório" data-parsley-required="true" data-parsley-minlength-message="Preencha o campo todo" data-parsley-minlength="18">
            </div>
            <div class="form-group">
                <label>Inscricao Estadual*</label>
                <input value="" data-mask="00000000000000" type="text" name="inscricao_estadual" class="form-control" placeholder="Entre com a Inscrição Estadual" data-parsley-required-message="Campo obrigatório" data-parsley-required="true" data-parsley-minlength-message="Preencha o campo todo" data-parsley-minlength="6">
            </div>
            <div class="form-group">
                <label>Razão Social*</label>
                <input value="" type="text" name="razao_social" class="form-control" placeholder="Entre com a Razão Social" data-parsley-required-message="Campo obrigatório" data-parsley-required="true">
            </div>
            <div class="form-group">
                <label>Nome Fantasia*</label>
                <input value="" type="text" name="nome_fantasia" class="form-control" placeholder="Entre com Nome Fantasia" data-parsley-required-message="Campo obrigatório" data-parsley-required="true">
            </div>
            <div class="form-group">
                <label>Cep*</label>
                <input id="cep" value="" type="text" name="cep" class="form-control" placeholder="Entre com o Cep" data-parsley-required-message="Campo obrigatório" data-parsley-required="true">
            </div>
            <div class="form-group">
                <label>Endereço*</label>
                <input readonly="true" id="endereco" value="" type="text" name="endereco" class="form-control" placeholder="Entre com o Endereço" data-parsley-required-message="Campo obrigatório" data-parsley-required="true">
            </div>
            <div class="form-group">
                <label>Bairro*</label>
                <input readonly="true" id="bairro" value="" type="text" name="bairro" class="form-control" placeholder="Entre com o Bairro" data-parsley-required-message="Campo obrigatório" data-parsley-required="true">
            </div>
            <div class="form-group">
                <label>Cidade*</label>
                <input readonly="true" id="cidade" value="" type="text" id="cidade" name="cidade" class="municipio form-control" placeholder="Entre com a cidade">
            </div>
            <div class="form-group">
                <label>Estado*</label>
                <input readonly="true" id="uf" value="" type="text" name="estado" class="form-control" placeholder="Entre com o Estado" data-parsley-required-message="Campo obrigatório" data-parsley-required="true">
            </div>
            <div class="form-group">
                <label>Número*</label>
                <input value="" data-mask="00000" type="text" name="numero" class="form-control" placeholder="Entre com o Número" data-parsley-required-message="Campo obrigatório" data-parsley-required="true">
            </div>
            <div class="form-group">
                <label>Complemento</label>
                <input value="" type="text" name="complemento" class="form-control" placeholder="Entre com o Complemento" >
            </div>
            <div class="form-group">
                <label>E-mail*</label>
                <input value="" type="text" name="email" data-parsley-type-message="E-mail invalido" data-parsley-type="email" data-parsley-required-message="Campo obrigatório" data-parsley-required="true" class="form-control" placeholder="Entre com o E-mail">
            </div>
            <div class="form-group">
                <label>Senha*</label>
                <input value="" data-parsley-required-message="Campo obrigatório" data-parsley-required="true" data-parsley-minlength-message="Senha deve conter no minimo 3 digitos" data-parsley-minlength="3" type="password" name="senha" class="form-control" placeholder="Entre com a Senha">
            </div>
            <div class="form-group">
                <label>Observação</label>
                <textarea name="descricao" class="form-control" rows="3" placeholder="Observação"></textarea>
            </div>
            <div class="form-group">
                <label>Foto*</label>
                <input class="oculto fino" data-parsley-required-message="Selecione uma foto" data-parsley-required="true" type="text" name="foto" id="cropOutput" />
                <div id="cropContaineroutput" class="cropContaineroutput"></div>                
            </div>
            <div id="areatoken" class="oculto">
                <div class="form-group">
                    <label>Chave</label>
                    <textarea id="chave" name="chave" class="form-control" rows="3" placeholder="Entre com a chave para confirmar"></textarea>
                </div>
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Instruções</h4>
                    <ul>
                        <li>Utilize sua chave para liberar o token.</li>
                        <li>Aperte ctrl + v para preencher o campo com a chave.</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" id="botaoenviar" value="enviar" class="btn btn-primary">Enviar</button>
        </div>
        <textarea id="transfer" class="form-control transparente fino" rows="3"></textarea>
    </form>
</div>
<!-- /.box -->