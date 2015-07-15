'use strict';

jQuery(document).ready(function () {

    var undoManager = new UndoManager();
    var updateUI = function () {
        jQuery('#undo').prop( "disabled", !undoManager.hasUndo() );
        jQuery('#redo').prop( "disabled", !undoManager.hasRedo() );
    };
    updateUI();
    var toggleClass = function(jqElement, className){
        var textDiv = jQuery('#text');
        jqElement.removeClass('btn-transform-lowercase').removeClass('btn-transform-uppercase').removeClass('btn-transform-title');
        textDiv.find('.parse-first-word').removeClass('btn-transform-title');

        textDiv.addClass(className);
    };

    undoManager.setCallback(function(){
        updateUI();
    });
    var undoManagerForElement = function(selector){
        var undoElement = jQuery(selector).clone();
        var redoElement;
        undoManager.add({
            undo: function() {
                redoElement = jQuery(selector).clone();
                jQuery(selector).replaceWith(undoElement);
            },
            redo: function() {
                jQuery(selector).replaceWith(redoElement);
            }
        });
    }


    jQuery('#uppercase').on("click", function (e) {
        undoManagerForElement('#text');
        var textDiv = jQuery('#text');
        toggleClass(textDiv, 'btn-transform-uppercase');
    });
    jQuery('#lowercase').on("click", function (e) {
        undoManagerForElement('#text');
        var textDiv = jQuery('#text');
        toggleClass(textDiv, 'btn-transform-lowercase')
    });
    jQuery('#title').on("click", function (e) {
        undoManagerForElement('#text');
        var textDiv = jQuery('#text');
        toggleClass(textDiv, 'btn-transform-title')
    });
    jQuery('#sentence').on("click", function (e) {
        undoManagerForElement('#text');
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
        undoManagerForElement('#text');
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