
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

$(document).ready(function () {
    // Delete resource
    $('button[name="delete-resource"]').on('click', function (e) {
        e.preventDefault()
        var $form = $(this).closest('form')
        $('#confirm-delete').modal({backdrop: 'static', keyboard: false}).one('click', '#delete', function (e) {
            $form.trigger('submit')
        })
    })

    // Cyber kleuren
    $('*').each(function() {
        //kleur 1
        if(
            $(this).css("background-color") === "rgb(249, 184, 30)" ||
            $(this).css("background-color") === "#f9b81e") {
            $(this).css("background-color","#76d2b6");
            //reverse colors
            //$(this).find('li a').css("color","#fff");
            //$(this).find('li.active a').css("color","#111");
        }
        //kleur 2
        if(
            $(this).css("background-color") === "rgb(252, 234, 186)" ||
            $(this).css("background-color") === "#fceaba") {
            $(this).css("background-color","#d6f1e9");
        }
        if(
            $(this).css("border-bottom-color") === "rgb(252, 234, 186)" ||
            $(this).css("border-bottom-color") === "#fceaba") {
            $(this).css("border-bottom-color","#d6f1e9");
        }
        //kleur 3
        if(
            $(this).css("background-color") === "rgb(252, 245, 226)" ||
            $(this).css("background-color") === "#fcf5e2") {
            $(this).css("background-color","#ebf8f4");
        }
    });
});