function wordCount( val ){
    return {
        charactersNoSpaces : val.replace(/\s+/g, '').length,
        characters         : val.length,
        words              : val.match(/\S+/g).length,
        lines              : val.split(/\r*\n/).length
    };
}

var div = document.getElementById("result");
var textarea = document.getElementById("text");

textarea.addEventListener("input", function(){
    var c = wordCount( this.value );
    div.innerHTML = (
    "<br>Characters (no spaces): "+ c.charactersNoSpaces +
    "<br>Characters (and spaces): "+ c.characters +
    "<br>Words: "+ c.words +
    "<br>Lines: "+ c.lines
    );
}, false);