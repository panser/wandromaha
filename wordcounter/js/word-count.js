'use strict';

jQuery(document).ready(function () {
    var div = document.getElementById("result");
    var textarea = document.getElementById("text");

    function wordCount( val ){
        try {
            var wordCountObj = {
                charactersNoSpaces: val.replace(/\s+/g, '').length,
                characters: val.length,
                words: val.match(/\S+/g).length,
                lines: val.split(/\r*\n/).length
            }
        }catch(err) {
            jQuery('#result').hide();
        }
        return wordCountObj;
    }

    textarea.addEventListener("input", function(){
        jQuery('#result').show();

        var c = wordCount( this.value );
        try {
            div.innerHTML = (
            "<br>Characters (no spaces): " + c.charactersNoSpaces +
            "<br>Characters (and spaces): " + c.characters +
            "<br>Words: " + c.words +
            "<br>Lines: " + c.lines
            );
        }catch(err) {
            jQuery('#result').hide();
        }
    }, false);

    var textDiv = jQuery('#text');
    var text;
    jQuery('#uppercase').on("click", function (e) {
        textDiv.addClass( 'btn-transform-uppercase' );
    });
    jQuery('#lowercase').on("click", function (e) {
        textDiv.addClass( 'btn-transform-lowercase' );
    });
    jQuery('#title').on("click", function (e) {
        textDiv.addClass( 'btn-transform-title' );
    });
    jQuery('#sentence').on("click", function (e) {
        text = textDiv.val();
        var lines = text.split('.');
        var output = '';
        jQuery.each(lines, function(key, line) {
            output += line.charAt(0).toUpperCase() + line.slice(1);
            if(line.length !== 0){
                output += '.';
            }
        });
        textDiv.val(output);
    });
    jQuery('#clear').on("click", function (e) {
        textDiv.val('');
        jQuery('#result').hide();
        textDiv.removeClass( 'btn-transform-uppercase' );
        textDiv.removeClass( 'btn-transform-lowercase' );
        textDiv.removeClass( 'btn-transform-title' );
    });

});