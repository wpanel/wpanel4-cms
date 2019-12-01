<?= form_open('newsletter', array('role' => 'form')); ?>
    <div class="form-group">
        <label class="control-label" for="nome">Nome</label>
        <input class="form-control" name="nome" id="nome" placeholder="Seu nome..." type="text">
    </div>
    <div class="form-group">
        <label class="control-label" for="email">Email</label>
        <input class="form-control" name="email" id="email" placeholder="Seu email..." type="text">
    </div>
    <button type="submit" class="btn btn-primary">
        <span class="glyphicon glyphicon-envelope"></span> Enviar
    </button>
<?= form_close(); ?>