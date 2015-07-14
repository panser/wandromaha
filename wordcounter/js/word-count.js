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
    jQuery('#uppercase').on("click", function (e) {
        textDiv.removeClass('btn-transform-lowercase').removeClass('btn-transform-title');
        textDiv.find('.parse-first-word').removeClass('btn-transform-title');
        textDiv.addClass('btn-transform-uppercase');
    });
    jQuery('#lowercase').on("click", function (e) {
        textDiv.removeClass('btn-transform-uppercase').removeClass('btn-transform-title');
        textDiv.find('.parse-first-word').removeClass('btn-transform-title');
        textDiv.addClass('btn-transform-lowercase');
    });
    jQuery('#title').on("click", function (e) {
        textDiv.removeClass('btn-transform-lowercase').removeClass('btn-transform-uppercase');
        textDiv.find('.parse-first-word').removeClass('btn-transform-title');
        textDiv.addClass('btn-transform-title');
    });
    jQuery('#sentence').on("click", function (e) {
        textDiv.removeClass('btn-transform-lowercase').removeClass('btn-transform-uppercase').removeClass('btn-transform-title');
        var text = textDiv.text();

        //var lines = textDiv.text().match( /[^\.!\?]+[\.!\?]+/g );
        //var output = '<span class="parse-sentence">' + lines.join('</span><span class="parse-sentence">') + '</span>';
        text = text.replace(/([\.!\?])(\s*)([a-zA-Z0-9]+)/g, '<span class="parse-punctuation">$1</span>$2<span class="parse-first-word">$3</span>');
        text = text.replace(/(\w+)/, '<span class="parse-first-word">$1</span>');
        textDiv.text('');
        textDiv.append(text);

        textDiv.find('.parse-first-word').addClass('btn-transform-title');
    });
    jQuery('#clear').on("click", function (e) {
        textDiv.text('');
        jQuery('#result').hide();
        textDiv.removeClass( 'btn-transform-uppercase' );
        textDiv.removeClass( 'btn-transform-lowercase' );
        textDiv.removeClass( 'btn-transform-title' );
        textDiv.find('.parse-first-word').removeClass('btn-transform-title');
    });

});