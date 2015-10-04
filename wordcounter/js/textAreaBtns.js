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
        var html = textDiv.html();
        //заменяем все html-теги перевода строки, на обычные ASCII-знаки
        html = html.replace(/(<\/div>)(<div>)/g, '$1\r\n$2');
        html = html.replace(/()<br>()/g, '$1\r\n$2');
        textDiv.text('');
        textDiv.append(html);

        var text = textDiv.text();
        //оборачуем в отдельный span все первые слова из предложений и разделители строк
        text = text.replace(/([\.!\?])(\s*)([a-zA-Z0-9]+)/g, '<span class="parse-punctuation">$1</span>$2<span class="parse-first-word">$3</span>');
        //заменяем все ASCII-знаки перевода строки на html-теги
        text = text.replace(/(?:\r\n|\r|\n)/g, '<br />');
        //оборачуем в отдельный span первое слово и всего текста
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