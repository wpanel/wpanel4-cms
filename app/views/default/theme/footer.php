<?php 

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') || exit('No direct script access allowed');

?>

                </div>
                <div class="col-md-3 wpn-sidebar">
                    <h4 class="page-header">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisa
                    </h4>
                    <?= $this->widget->load('wpnsearchform'); ?>
                    <h4 class="page-header">
                        <span class="glyphicon glyphicon-tag" aria-hidden="true"></span> Categorias
                    </h4>
                    <?= $this->widget->load('wpncategorymenu', array('inicial_id' => 0, 'main_attr' => array('class' => 'menu-sidebar'))); ?>
                    <?= $this->widget->load('wpnsidebarbanner'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <h4 class="page-header">Sobre</h4>
                    <?= $this->widget->load('Wpnsitedescription'); ?>
                </div>
                <div class="col-md-4 col-sm-4">
                    <h4 class="page-header">Newsletter</h4>
                    <?= $this->widget->load('Wpnformnewsletter'); ?>
                </div>
                <div class="col-md-4 col-sm-4">
                    <h4 class="page-header">Social</h4>
                    <?= $this->widget->load('wpnlikebox'); ?>
                </div>
            </div>
            <div class="row wpn-footer">
                <div class="col-md-12">
                    <p><?= $this->widget->load('wpnfooterbanner'); ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 wpn-copyright">
                    <p><?= wpn_config('copyright'); ?></p>
                </div>
            </div>
        </div>
    </body>
    <?= $this->widget->load('wpnganalytics'); ?>
</html>