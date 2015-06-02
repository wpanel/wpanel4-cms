$(function () {

    /* Dá vida ao colorpicker do painel de configurações. */
    /* ---------------------------------------------------------------------- */
    $('.colorpicker').colorpicker();
    
    /* -------------------------------------------------------------------------
     * Este bloco faz o funcionamento do formulário de cadastro 
     * de itens de menu. 
     * ---------------------------------------------------------------------- */
    $("#tipo_link").click(function () {
        $("#form_link").show();
        $("#form_post").hide();
        $("#form_posts").hide();
        $("#form_funcional").hide();
    });
    $("#tipo_post").click(function () {
        $("#form_link").hide();
        $("#form_post").show();
        $("#form_posts").hide();
        $("#form_funcional").hide();
    });
    $("#tipo_posts").click(function () {
        $("#form_link").hide();
        $("#form_post").hide();
        $("#form_posts").show();
        $("#form_funcional").hide();
    });
    $("#tipo_funcional").click(function () {
        $("#form_link").hide();
        $("#form_post").hide();
        $("#form_posts").hide();
        $("#form_funcional").show();
    });

});