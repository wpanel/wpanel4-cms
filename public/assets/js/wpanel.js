/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

$(document).ready(function() {

    // Mostra a janela modal de alerta quando for usada.
    $('#message_modal').modal('show');

    // Executa o sub-menu.
    $(function(){
        $('[data-submenu]').submenupicker();
    });

});