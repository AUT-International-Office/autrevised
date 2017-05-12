/**
 * Created by rajab on 5/6/2017.
 */
$(document).ready(function () {
    var reals = $(".tagParent");
    $.each(reals, function (index, value) {
        var paddingLeft = (count($(value).find(".tagReal").text(), '\\.')+1)*15+'px';
        $(value).find(".tagReal").css('padding-left', paddingLeft);
        $(value).find(".tagDescription").css('padding-left', paddingLeft);
        console.log(paddingLeft + $(value).find(".tagReal").text());
    });

});

function count(s1, letter) {
    s1 = $.trim(s1);
    console.log(s1);
    return ( s1.match( RegExp(letter,'g') ) || [] ).length;
}