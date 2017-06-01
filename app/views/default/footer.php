				</div>
				<div class="col-sm-3 col-md-3 wpn-sidebar">
                    <h4 class="page-header">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisa
                    </h4>
                    <?= wpn_widget('searchform'); ?>

                    <h4 class="page-header">
                        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Eventos
                    </h4>
                    <?= wpn_widget('eventsmenu', array('attributes' => array('class' => 'menu-sidebar'))); ?>

                    <h4 class="page-header">
                        <span class="glyphicon glyphicon-tag" aria-hidden="true"></span> Categorias
                    </h4>
                    <?= wpn_widget('categorymenu', array('inicial_id' => 0, 'main_attr' => array('class' => 'menu-sidebar'))); ?>

                </div>
            </div>
            <div class="row wpn-footer">
            	<div class="col-sm-4 col-md-4">
                    <h4 class="page-header">Sobre</h4>
                    <?= wpn_widget('sitedescription'); ?>
                </div>
                <div class="col-sm-4 col-md-4">
                    <h4 class="page-header">Newsletter</h4>
                   <?= wpn_widget('formnewsletter'); ?>
                </div>
                <div class="col-sm-4 col-md-4">
                    <h4 class="page-header">Social</h4>
                    <?= wpn_widget('likebox'); ?>
                </div>
            </div>
        </div>
                
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 wpn-copyright">
                    <p><?= wpn_config('copyright'); ?></p>
                </div>
            </div>
        </div>
        
    </body>
    <?= wpn_widget('ganalytics'); ?>
</html>