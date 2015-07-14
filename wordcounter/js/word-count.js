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



        var toggleClass = function(jqElement, className){
        var textDiv = jQuery('#text');
        jqElement.removeClass('btn-transform-lowercase').removeClass('btn-transform-uppercase').removeClass('btn-transform-title');
        textDiv.find('.parse-first-word').removeClass('btn-transform-title');

        textDiv.addClass(className);
    };
    var undoManager = new UndoManager();

    jQuery('#uppercase').on("click", function (e) {
        var textDiv = jQuery('#text');
        var undoElement = textDiv.clone();
        var redoElement;
        toggleClass(textDiv, 'btn-transform-uppercase');
        undoManager.add({
            undo: function() {
                redoElement = jQuery('#text').clone();
                jQuery('#text').replaceWith(undoElement);
            },
            redo: function() {
                jQuery('#text').replaceWith(redoElement);
            }
        });
    });
    jQuery('#lowercase').on("click", function (e) {
        var textDiv = jQuery('#text');
        toggleClass(textDiv, 'btn-transform-lowercase')
    });
    jQuery('#title').on("click", function (e) {
        var textDiv = jQuery('#text');
        toggleClass(textDiv, 'btn-transform-title')
    });
    jQuery('#sentence').on("click", function (e) {
        var textDiv = jQuery('#text');
        var text = textDiv.text();
        text = text.replace(/([\.!\?])(\s*)([a-zA-Z0-9]+)/g, '<span class="parse-punctuation">$1</span>$2<span class="parse-first-word">$3</span>');
        text = text.replace(/(\w+)/, '<span class="parse-first-word">$1</span>');
        textDiv.text('');
        textDiv.append(text);

        textDiv.removeClass('btn-transform-lowercase').removeClass('btn-transform-uppercase').removeClass('btn-transform-title');
        textDiv.find('.parse-first-word').addClass('btn-transform-title');
    });
    jQuery('#clear').on("click", function (e) {
        var textDiv = jQuery('#text');
        textDiv.text('');
        jQuery('#result').hide();
        textDiv.removeClass('btn-transform-lowercase').removeClass('btn-transform-uppercase').removeClass('btn-transform-title');
        textDiv.find('.parse-first-word').removeClass('btn-transform-title');
    });


    jQuery('#undo').on("click", function (e) {
        undoManager.undo();
    });
    jQuery('#redo').on("click", function (e) {
        undoManager.redo();
    });

});