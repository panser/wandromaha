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

});