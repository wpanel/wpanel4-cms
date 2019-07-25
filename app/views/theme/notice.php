<?php 

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

defined('BASEPATH') OR exit('No direct script access allowed'); 

?>
<!--

Mostra mensagens de alerta com o elemento alert do bootstrap.

-->
<?php if (isset($notice) && is_array($notice)) : ?>
    <div id="notices" class="row">
        <div class="col-sm-12 col-md-12">
            <div style="margin:5px 8px 5px 5px;" class="alert alert-<?php echo $notice['type']; ?> alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo $notice['message']; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<!--

Mostra mensagens de alerta com o elemento modal do bootstrap.

<?php if (isset($notice) && is_array($notice)) : ?>
    <div class="modal fade" id="message_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Mensagem</h4>
                </div>
                <div class="modal-body">
                    <p><?php echo $notice['message']; ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

-->