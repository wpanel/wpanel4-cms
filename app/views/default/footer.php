				</div>
				<div class="col-md-3 wpn-sidebar">
                    <h4 class="page-header">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisa
                    </h4>
                    <?= $this->widget->runit('searchform'); ?>

                    <h4 class="page-header">
                        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Eventos
                    </h4>
                    <?= $this->widget->runit('eventsmenu', array('attributes' => array('class' => 'menu-sidebar'))); ?>

                    <h4 class="page-header">
                        <span class="glyphicon glyphicon-tag" aria-hidden="true"></span> Categorias
                    </h4>
                    <?= $this->widget->runit('categorymenu', array('category_id'=>0, 'attributes'=>array('class' => 'menu-sidebar'))); ?>

                </div>
            </div>
            <div class="row wpn-footer">
            	<div class="col-md-4">
                    <h4 class="page-header">Sobre</h4>
                    <?= $this->widget->runit('sitedescription'); ?>
                </div>
                <div class="col-md-4">
                    <h4 class="page-header">Newsletter</h4>
                   <?= $this->widget->runit('formnewsletter'); ?>
                </div>
                <div class="col-md-4">
                    <h4 class="page-header">Social</h4>
                    <?= $this->widget->runit('likebox'); ?>
                </div>
                <div class="col-md-12 wpn-copyright">

                    <div class="wpn-ads">
                        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                        <!-- WPanel CMS -->
                        <ins class="adsbygoogle"
                             style="display:block"
                             data-ad-client="ca-pub-0286050943868335"
                             data-ad-slot="6888761431"
                             data-ad-format="auto"></ins>
                        <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </div>

                    <p><?= wpn_config('copyright'); ?></p>
                </div>
			</div>
		</div>
	</body>
    <?= $wpn_google_analytics; ?>
</html>