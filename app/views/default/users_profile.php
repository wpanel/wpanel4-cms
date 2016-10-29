<div class="panel panel-default">
    <div class="panel-heading">Alteração de dados pessoais</div>
    <div class="panel-body">
        <?= form_open('account/profile', array('role' => 'form', 'class' => 'form-horizontal',)); ?>
        <input type="hidden" name="id" value="<?= $row->id; ?>" />
        <div class="form-group">
            <div class="radio col-sm-offset-2 col-sm-10">
                <label>
                    <input type="radio" name="tipo" id="tipo_pf" value="PF" <?php if ($row->tipo == 'PF') echo 'checked="checked"'; ?> /> Pessoa física &nbsp;&nbsp;&nbsp;
                </label>
                <label>
                    <input type="radio" name="tipo" id="tipo_pj" value="PJ" <?php if ($row->tipo == 'PJ') echo 'checked="checked"'; ?> /> Pessoa jurídica
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="nome_razao" id="lb_nome" class="col-sm-2 control-label">Nome</label>
            <label for="nome_razao" id="lb_razao" class="col-sm-2 control-label">Razão social</label>
            <div class="col-sm-10">
                <input type="text" name="nome_razao" id="nome_razao" value="<?= $row->nome_razao ?>" class="form-control"  />
                <?= form_error('nome_razao'); ?>
            </div>
        </div>
        <div class="form-group" id="fantasia">
            <label for="apelido_fantasia" class="col-sm-2 control-label">Nome fantasia</label>
            <div class="col-sm-10">
                <input type="text" name="apelido_fantasia" id="apelido_fantasia" value="<?= $row->apelido_fantasia; ?>" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label for="cpf_cnpj" id="lb_cpf" class="col-sm-2 control-label">CPF</label>
            <label for="cpf_cnpj" id="lb_cnpj" class="col-sm-2 control-label">CNPJ</label>
            <div class="col-sm-10">
                <input type="text" name="cpf_cnpj" id="cpf_cnpj" value="<?= $row->cpf_cnpj; ?>" class="form-control" />
                <?= form_error('cpf_cnpj'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="endereco" class="col-sm-2 control-label">Endereço</label>
            <div class="col-sm-6">
                <input type="text" name="endereco" id="endereco" value="<?= $row->endereco; ?>" class="form-control" />
            </div>
            <label for="numero" class="col-sm-1 control-label">Número</label>
            <div class="col-sm-2">
                <input type="text" name="numero" id="numero" value="<?= $row->numero; ?>" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label for="bairro" class="col-sm-2 control-label">Bairro</label>
            <div class="col-sm-4">
                <input type="text" name="bairro" id="bairro" value="<?= $row->bairro; ?>" class="form-control" />
            </div>
            <label for="cidade" class="col-sm-1 control-label">Cidade</label>
            <div class="col-sm-4">
                <input type="text" name="cidade" id="cidade" value="<?= $row->cidade; ?>" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label for="uf" class="col-sm-2 control-label">UF</label>
            <div class="col-sm-1">
                <input type="text" name="uf" id="uf" value="<?= $row->uf; ?>" class="form-control" />
            </div>
            <label for="cep" class="col-sm-1 control-label">CEP</label>
            <div class="col-sm-2">
                <input type="text" name="cep" id="cep" value="<?= $row->cep; ?>" class="form-control" />
            </div>
        </div>
        <div class="form-group" id="departamento">
            <label for="departamento" class="col-sm-2 control-label">Departamento</label>
            <div class="col-sm-6">
                <input type="text" name="departamento" id="departamento" value="<?= $row->departamento; ?>" class="form-control" />
            </div>
        </div>
        <div class="form-group" id="contato">
            <label for="contato" class="col-sm-2 control-label">Contato</label>
            <div class="col-sm-6">
                <input type="text" name="contato" id="contato" value="<?= $row->contato; ?>" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label for="telefone" class="col-sm-2 control-label">Telefone</label>
            <div class="col-sm-5">
                <input type="text" name="telefone" id="telefone" value="<?= $row->telefone; ?>" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">E-mail</label>
            <div class="col-sm-5">
                <input type="text" name="email" id="email" value="<?= $row->email; ?>" class="form-control" />
                <?= form_error('email'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="senha" class="col-sm-2 control-label">Senha</label>
            <div class="col-sm-3">
                <input type="password" name="senha" id="senha" class="form-control" />
                <?= form_error('senha'); ?>
            </div>
            <div class="checkbox col-sm-5">
                <label>
                    <input type="checkbox" name="alterar_senha" value="1"/> Alterar a senha.
                </label>
            </div>
        </div>
        <hr/>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" >Salvar</button>
                <?= anchor('', 'Cancelar', array('class' => 'btn btn-danger')); ?>
            </div>
        </div>
        </form>		
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        <?php if ($row->tipo == 'PF') echo 'form_pf();'; else echo 'form_pj();'; ?>
    });
</script>