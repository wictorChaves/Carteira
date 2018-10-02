<?php

use model\EstadoCivilModel;
use model\EstadosModel;
use model\PaisnacionalidadeidiomaModel;

$estadoCivil = new EstadoCivilModel();
$estadosCivil = $estadoCivil->getDados();

$estadosModel = new EstadosModel();
$estados = $estadosModel->getDados();

$paisnacionalidadeidioma = new PaisnacionalidadeidiomaModel();
$pni = $paisnacionalidadeidioma->getDados();
?>
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
                <label>Nome*</label>
                <input value=""
                       maxlength="50"
                       type="text"
                       name="nome"
                       class="form-control"
                       placeholder="Entre com o Nome"
                       data-parsley-required-message="Campo obrigatório"
                       data-parsley-required="true">
            </div>            
            <div class="form-group">
                <label>CPF*</label>
                <input value=""
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
                <label>RG*</label>
                <input value=""
                       maxlength="20"
                       data-parsley-required-message="Campo obrigatório"
                       data-parsley-required="true"
                       type="text"
                       name="rg"
                       class="form-control"
                       placeholder="Entre com RG">
            </div>
            <div class="form-group">
                <label>Mãe*</label>
                <input value=""
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
                <input value=""
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
                       value=""
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
                               checked>
                        Masculino
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio"
                               name="sexo"
                               id="optionsRadios2"
                               value="0">
                        Feminino
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label>Estado Civil*</label>
                <select name="estado_civil"
                        class="form-control">
                            <?php foreach ($estadosCivil as $estadoCivilItem): ?>
                        <option value="<?php echo $estadoCivilItem->getId(); ?>"><?php echo utf8_encode($estadoCivilItem->getEstado()); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>            
            <div class="form-group">
                <label>PIS*</label>
                <input value=""
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
                <input value=""
                       data-mask="00000-0000"
                       type="text"
                       name="numero_carteira"
                       class="form-control"
                       placeholder="Entre com Número da carteira">
            </div>
            <div class="form-group">
                <label>Local de Emissão*</label>
                <input value="Ipatinga, MG"
                       type="text"
                       id="local_emissao_cp_"
                       name="local_emissao_cp_"
                       class="municipio form-control"
                       placeholder="Entre com Local de Emissão">
                <input value="2680"
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
                        if ($pniItem->getNacionalidade() == 'Brasileiro'): echo 'selected="selected"';
                        endif;
                        ?>><?php echo utf8_encode($pniItem->getNacionalidade()); ?></option>
                            <?php endforeach; ?>
                </select>
            </div>  
            <div id="nascional">
                <div class="form-group">
                    <label>Natural de*</label>
                    <input id="naturalidade_cp_"
                           type="text"
                           value="Ipatinga, MG"
                           name="naturalidade_cp_"
                           class="municipio form-control"
                           placeholder="Entre com a Naturalidade">
                    <input id="naturalidade"
                           value="2680"
                           type="text"
                           name="naturalidade"
                           class="form-control oculto fino"
                           placeholder="Entre com a naturalid">
                </div>
                <div class="form-group">
                    <label>Título Eleitoral (Número Inscrição)*</label>
                    <input value=""
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
                    <input value=""
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
                    <input value=""
                           data-mask="000"
                           type="text"
                           name="zona"
                           class="form-control"
                           placeholder="Entre com a Zona"
                           data-parsley-minlength-message="Preencha o campo todo"
                           data-parsley-minlength="3">
                </div>
            </div> 
            <div id="internacional">
                <div class="form-group">
                    <label>Chegada*</label>
                    <input data-mask="00/00/0000"
                           type="text"
                           name="n_chegada"
                           class="form-control"
                           placeholder="Entre com a Chegada">
                </div>
                <div class="form-group">
                    <label>Expedido*</label>
                    <input type="text"
                           maxlength="50"
                           name="n_expedido"
                           class="form-control"
                           placeholder="Entre com Orgão Expeditor">
                </div>
                <div class="form-group">
                    <label>Estado*</label>
                    <input type="text"
                           maxlength="50"
                           name="n_estado"
                           class="form-control"
                           placeholder="Entre com Estado">
                </div>
            </div>            
            <div class="form-group">
                <label>CNH</label>
                <input value=""
                       data-mask="00000000000"
                       type="text"
                       name="cnh"
                       class="form-control"
                       placeholder="Entre com a CNH"
                       data-parsley-minlength-message="Preencha o campo todo"
                       data-parsley-minlength="11">
            </div>
            <div class="form-group">
                <label>Observação</label>
                <textarea name="observacao"
                          class="form-control"
                          rows="3"
                          placeholder="Observação"></textarea>
            </div>
            <div class="form-group">
                <label>E-mail*</label>
                <input value=""
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
                <input value=""
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
                       data-parsley-required="true"
                       type="text"
                       name="foto"
                       id="cropOutput"
                       />
                <div id="cropContaineroutput"
                     class="cropContaineroutput"></div>                
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