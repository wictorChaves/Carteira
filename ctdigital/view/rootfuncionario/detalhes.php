<?php

use model\EstadoCivilModel;
use model\EstadosModel;
use model\PaisnacionalidadeidiomaModel;
use model\MunicipioModel;
use core\StringHelper;

$funcionario = reset($_pagina['model']);

if ($funcionario->getSexo() == '1') {
    $masculino = 'checked';
    $feminino = '';
} else {
    $feminino = 'checked';
    $masculino = '';
}

$municipioModel = new MunicipioModel();

$estadoCivil = new EstadoCivilModel();
$estadosCivil = $estadoCivil->getDados();

$estadosModel = new EstadosModel();
$estados = $estadosModel->getDados();

$paisnacionalidadeidioma = new PaisnacionalidadeidiomaModel();
$pni = $paisnacionalidadeidioma->getDados();

$grupos = explode(',', $funcionario->getGrupo());

if (isset($_GET['save'])) :
    if ($_GET['save'] == 'ok') :
        ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Dados salvos com sucesso!</h4>
        </div>
        <?php
    endif;
endif;
?>
<div id="infoView" hidden=""> 
    <div id="_tituloHead">Detalhes de trabalhador</div>
    <div id="_tituloMenuPrincipal">trabalhador</div>
    <div id="_tituloView">Detalhes de trabalhador</div>
    <div id="_menuOff">Página Sem Menu</div>
</div>
<div id="cadFuncionario"
     class="box box-primary">
    <form id="funcionario"
          data-parsley-validate name="asyncoff"
          method="post"
          action="#"
          role="form"
          novalidate>
        <div class="box-body">
            <div class="form-group">
                <label>ID</label>
                <input readonly="true" id="id" value="<?php echo $funcionario->getId(); ?>" type="text" name="id" class="form-control" placeholder="Entre com o id" data-parsley-required-message="Campo obrigatório" data-parsley-required="true">
            </div>
            <div class="form-group">
                <label>PIS*</label>
                <input value="<?php echo $funcionario->getPis(); ?>"
                       data-parsley-required-message="Campo obrigatório"
                       data-parsley-required="true"
                       data-parsley-minlength-message="Preencha o campo todo"
                       data-parsley-minlength="14"
                       data-mask="000.0000.00-00"
                       type="text"
                       name="pis"
                       class="form-control"
                       placeholder="Entre com PIS"
                       >
            </div>
            <div class="form-group">
                <label>Número da carteira </label>
                <input value="<?php echo $funcionario->getNumeroCarteira(); ?>"
                       data-mask="00000-0000"
                       type="text"
                       name="numero_carteira"
                       class="form-control"
                       placeholder="Entre com Número da carteira">
            </div>
            <div class="form-group">
                <label>Nome*</label>
                <input value="<?php echo $funcionario->getNome(); ?>"
                       maxlength="50"
                       type="text"
                       name="nome"
                       class="form-control"
                       placeholder="Entre com o Nome"
                       data-parsley-required-message="Campo obrigatório"
                       data-parsley-required="true">
            </div>
            <div class="form-group">
                <label>Mãe*</label>
                <input value="<?php echo $funcionario->getMae(); ?>"
                       maxlength="50"
                       type="text"
                       name="mae"
                       class="form-control"
                       placeholder="Nome da mãe"
                       data-parsley-required-message="Campo obrigatório"
                       data-parsley-required="true">
            </div>
            <div class="form-group">
                <label>Pai*</label>
                <input value="<?php echo $funcionario->getPai(); ?>"
                       maxlength="50"
                       type="text"
                       name="pai"
                       class="form-control"
                       placeholder="Nome do pai "
                       data-parsley-required-message="Campo obrigatório"
                       data-parsley-required="true">
            </div>
            <div class="form-group">
                <label>Data de nascimento*</label>
                <input data-parsley-idade="14"
                       value="<?php echo StringHelper::dataEN2BR($funcionario->getDataNascimento()); ?>"
                       data-mask="00/00/0000"
                       type="text"
                       name="data_nascimento"
                       class="form-control"
                       placeholder="Entre com a Data de Nascimento "
                       data-parsley-required-message="Campo obrigatório"
                       data-parsley-required="true"
                       data-parsley-minlength-message="Preencha o campo todo"
                       data-parsley-minlength="10">
            </div>
            <div class="form-group">
                <label>Sexo*</label>
                <div class="radio">
                    <label>
                        <input type="radio"
                               name="sexo"
                               id="optionsRadios1"
                               value="1"
<?php echo $masculino; ?>>
                        Masculino
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio"
                               name="sexo"
                               id="optionsRadios2"
                               value="0"
<?php echo $feminino; ?>>
                        Feminino
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label>Estado Civil*</label>
                <select name="estado_civil"
                        class="form-control">
                        <?php foreach ($estadosCivil as $estadoCivilItem): ?>
                        <option <?php if ($funcionario->getEstadoCivil() == $estadoCivilItem->getId()): echo 'selected="true"';
                        endif;
                        ?> value="<?php echo $estadoCivilItem->getId(); ?>"><?php echo utf8_encode($estadoCivilItem->getEstado()); ?></option>
<?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Natural de* <?php $municipio = $municipioModel->getDadoById($funcionario->getNaturalidade()); ?></label>
                <input id="naturalidade_cp_"
                       type="text"
                       value="<?php echo $municipio->getMunicipio() . ", " . $municipio->getEstado(); ?>"
                       name="naturalidade_cp_"
                       class="municipio form-control"
                       placeholder="Entre com a Naturalidade">
                <input id="naturalidade"
                       data-parsley-required-message="Preencha com a cidade"
                       data-parsley-required="true"
                       value="<?php echo $funcionario->getNaturalidade() ?>"
                       type="text"
                       name="naturalidade"
                       class="form-control oculto fino"
                       placeholder="Entre com a naturalid">
            </div>
            <div class="form-group">
                <label>RG*</label>
                <input value="<?php echo $funcionario->getRg(); ?>"
                       maxlength="20"
                       data-parsley-required-message="Campo obrigatório"
                       data-parsley-required="true"
                       type="text"
                       name="rg"
                       class="form-control"
                       placeholder="Entre com RG">
            </div>
            <div class="form-group">
                <label>CPF*</label>
                <input value="<?php echo $funcionario->getCpf(); ?>"
                       data-mask="000.000.000-00"
                       type="text"
                       name="cpf"
                       class="form-control"
                       placeholder="Entre com CPF"
                       data-parsley-required-message="Campo obrigatório"
                       data-parsley-required="true"
                       data-parsley-minlength-message="Preencha o campo todo"
                       data-parsley-minlength="14">
            </div>
            <div class="form-group">
                <label>CNH</label>
                <input value="<?php echo $funcionario->getCnh(); ?>"
                       data-mask="00000000000"
                       type="text"
                       name="cnh"
                       class="form-control"
                       placeholder="Entre com a CNH"
                       data-parsley-minlength-message="Preencha o campo todo"
                       data-parsley-minlength="11">
            </div>
            <div class="form-group">
                <label>Título Eleitoral (Número Inscrição)*</label>
                <input value="<?php echo $funcionario->getTituloEleitoral(); ?>"
                       data-mask="0000 0000 0000"
                       type="text"
                       name="titulo_eleitoral"
                       class="form-control"
                       placeholder="Entre com Titulo Eleitoral"
                       data-parsley-minlength-message="Preencha o campo todo"
                       data-parsley-minlength="14">
            </div>
            <div class="form-group">
                <label>Seção*</label>
                <input value="<?php echo $funcionario->getSecao(); ?>"
                       data-mask="0000"
                       type="text"
                       name="secao"
                       class="form-control"
                       placeholder="Entre com a  Seção"
                       data-parsley-minlength-message="Preencha o campo todo"
                       data-parsley-minlength="4">
            </div>
            <div class="form-group">
                <label>Zona*</label>
                <input value="<?php echo $funcionario->getZona(); ?>"
                       data-mask="000"
                       type="text"
                       name="zona"
                       class="form-control"
                       placeholder="Entre com a Zona"
                       data-parsley-minlength-message="Preencha o campo todo"
                       data-parsley-minlength="3">
            </div>
            <div class="form-group">
                <label>Local de Emissão* <?php $localEmissao = $municipioModel->getDadoById($funcionario->getLocalEmissao()); ?></label>
                <input value="<?php echo $localEmissao->getMunicipio() . ", " . $localEmissao->getEstado(); ?>"
                       type="text"
                       id="local_emissao_cp_"
                       name="local_emissao_cp_"
                       class="municipio form-control"
                       placeholder="Entre com Local de Emissão">
                <input value="<?php echo $funcionario->getLocalEmissao(); ?>"
                       type="text"
                       id="local_emissao"
                       name="local_emissao"
                       class="form-control oculto fino"
                       placeholder="Entre com Local de Emissão"
                       data-parsley-required-message="Campo obrigatório"
                       data-parsley-required="true">
            </div>
            <div class="form-group">
                <label>Nacionalidade*</label>
                <select id="nacionalidade"
                        maxlength="50"
                        name="nacionalidade"
                        class="form-control">
                    <?php foreach ($pni as $pniItem): ?>
                        <option value="<?php echo $pniItem->getId(); ?>"<?php
                                if ($pniItem->getId() == $funcionario->getNacionalidade()): echo 'selected="selected"';
                                endif;
                                ?>><?php echo utf8_encode($pniItem->getNacionalidade()); ?></option>
<?php endforeach; ?>
                </select>
            </div>
            <div id="_internacional">
                <div class="form-group">
                    <label>Chegada*</label>
                    <input value="<?php echo StringHelper::dataEN2BR($funcionario->getNChegada()); ?>"
                           data-mask="00/00/0000"
                           type="text"
                           name="n_chegada"
                           class="form-control"
                           placeholder="Entre com a Chegada">
                </div>
                <div class="form-group">
                    <label>Expedido*</label>
                    <input value="<?php echo $funcionario->getNExpedido(); ?>"
                           type="text"
                           maxlength="50"
                           name="n_expedido"
                           class="form-control"
                           placeholder="Entre com Orgão Expeditor">
                </div>
                <div class="form-group">
                    <label>Estado*</label>
                    <input value="<?php echo $funcionario->getNEstado(); ?>"
                           type="text"
                           maxlength="50"
                           name="n_estado"
                           class="form-control"
                           placeholder="Entre com Estado">
                </div>
            </div>
            <div class="form-group">
                <label>Observação</label>
                <textarea name="observacao"
                          class="form-control"
                          rows="3"
                          placeholder="Observação"><?php echo $funcionario->getObservacao(); ?></textarea>
            </div>
            <div class="form-group">
                <label>E-mail*</label>
                <input value="<?php echo $funcionario->getEmail(); ?>"
                       maxlength="50"
                       type="text"
                       name="email"
                       data-parsley-type-message="E-mail invalido"
                       data-parsley-type="email"
                       data-parsley-required-message="Campo obrigatório"
                       data-parsley-required="true"
                       class="form-control"
                       placeholder="Entre com o E-mail">
            </div>
            <div class="form-group">
                <label>Senha*</label>
                <input value="<?php echo $funcionario->getSenha(); ?>"
                       data-parsley-required-message="Campo obrigatório"
                       data-parsley-required="true"
                       data-parsley-minlength-message="Senha deve conter no minimo 3 digitos"
                       data-parsley-minlength="3"
                       type="password"
                       name="senha"
                       class="form-control"
                       placeholder="Entre com a Senha">
            </div>
            <div class="form-group">
                <label>Foto*</label>
                <input class="oculto fino"
                       data-parsley-required-message="Selecione uma foto"
                       type="text"
                       name="foto"
                       id="cropOutput"
                       />
                <div id="cropContaineroutput"
                     class="cropContaineroutput">
                    <img class="croppedImg" src="<?php echo $funcionario->getImagem(); ?>">
                </div>                
            </div>
            <div class="form-group">
                <label>Permissões</label>             
            </div>
            <div class="checkbox">
                <label>
                    <input name="permissoes[]" value="trabalhador" type="checkbox" <?php if (in_array("trabalhador", $grupos)) : echo 'checked="true"'; endif; ?>> Ativo
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input name="permissoes[]" value="cad_empresa" type="checkbox" <?php if (in_array("cad_empresa", $grupos)) : echo 'checked="true"'; endif; ?>> Cadastra Empresa
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input name="permissoes[]" value="cad_funcionario" type="checkbox" <?php if (in_array("cad_funcionario", $grupos)) : echo 'checked="true"'; endif; ?>> Cadastra Funcionário
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input name="permissoes[]" value="root" type="checkbox" <?php if (in_array("root", $grupos)) : echo 'checked="true"'; endif; ?>> Root
                </label>
            </div>
            <div id="areatoken"
                 class="oculto">
                <div class="form-group">
                    <label>Chave</label>
                    <textarea id="chave"
                              name="chave"
                              class="form-control"
                              rows="3"
                              placeholder="Entre com a chave para confirmar"></textarea>
                </div>
                <div class="alert alert-info alert-dismissible">
                    <button type="button"
                            class="close"
                            data-dismiss="alert"
                            aria-hidden="true">&times;</button>
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
            <button type="submit"
                    id="botaoenviar"
                    value="enviar"
                    class="btn btn-primary">Enviar</button>
        </div>
        <textarea id="transfer"
                  class="form-control transparente fino"
                  rows="3"></textarea>
    </form>
</div>
<!-- /.box -->