/** * Main JS File * * @author Your Inspiration Themes * @package YITH Footer Banner * @version 1.0.3 */jQuery(document).ready(function($) {    if($.cookie(templateDir) == '1') {        $(".fbanner").hide();    }    $("#showhidefbanner a").on('click',function(event){        event.preventDefault();        $('.fbanner').hide();    });    $("#showhideforever a").on('click',function(event){        event.preventDefault();        $(".fbanner").hide();        $.cookie(templateDir, '1',{ expires: 365, path: '/' });    });});