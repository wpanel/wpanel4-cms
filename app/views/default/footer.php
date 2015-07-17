				</div>
				<div class="col-md-3">

                    <h4 class="page-header"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisa</h4>
                    <?= $this->widget->run('searchform'); ?>

                    <h4 class="page-header"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Eventos</h4>
                    <?= $this->widget->run('eventsmenu', array('attributes' => array('class' => 'menu-sidebar'))); ?>

                    <h4 class="page-header"><span class="glyphicon glyphicon-tag" aria-hidden="true"></span> Categorias</h4>
                    <?= $this->widget->run('categorymenu', array('category_id'=>0, 'attributes'=>array('class' => 'menu-sidebar'))); ?>

				</div>
			</div>
			<!-- Rodape | Inicio -->
            <div class="row wpn-rodape">
                <div class="col-md-4">
                    <h4 class="page-header">Sobre</h4>
                    <?= $this->widget->run('sitedescription'); ?>
                </div>
                <div class="col-md-4">
                    <h4 class="page-header">Newsletter</h4>
                   <?= $this->widget->run('formnewsletter'); ?>
                </div>
                <div class="col-md-4">
                    <h4 class="page-header">Social</h4>
                    <?= $this->widget->run('likebox'); ?>
                </div>
                <div class="col-md-12 copyright">
                    <p><?= $wpn_copyright; ?></p>
                </div>
            </div>
            <!-- Rodape | Fim -->
		</div>
	</body>
    <?= $wpn_google_analytics; ?>
</html>