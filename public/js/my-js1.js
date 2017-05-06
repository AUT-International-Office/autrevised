/**
 * Created by ASUS on 2/2/2017.
 */

document.filters = {
    $org_ids: [],
    $field_ids: [],
    $tag_ids: [],
    $country_ids: [],
    $ratings: [],
    $visible: 1
};



$(document).ready(function () {
   document.fundItem = $('.fundItem')[0];
   document.tabItem = $('.tabItem')[0];
   console.log(document.fundItem);
   console.log(document.tabItem);

   document.offset = 0;
});


$("[data-toggle *= 'collapse']").click(function(){
    if ($(this).find("i").hasClass("fa-caret-right")){
        $(this).find("i").removeClass("fa-caret-right");
        $(this).find("i").addClass("fa-caret-down");
    }
    else{
        $(this).find("i").removeClass("fa-caret-down");
        $(this).find("i").addClass("fa-caret-right");
    }
});

$(".List").change(function () {

    document.offset = 0;
    var id = $(this).attr('id');
    var value = $(this).val();
    console.log(id);
    if(id == 'CategoryFilter')
        document.filters.$tag_ids = value;
    else if(id == 'OrgFilter')
        document.filters.$org_ids = value;
    else if(id == 'CountryFilter')
        document.filters.$country_ids = value;
    else if(id == 'ResearchFilter')
        document.filters.$field_ids = value;
    else if(id == 'VisibleFilter')
        document.filters.$visible = value;

    console.log(document.filters);
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: '/search',
        type: 'post',
        dataType: 'html',
        data: {_token: CSRF_TOKEN, filter: document.filters, offset: document.offset
        }
    })
        .done(function(data) {
            console.log('success');
            refreshFunds(data);
        })
        .fail(function() {
            console.log("error");

        })

});


$("#searchbox").on('keyup', function (event) {
    document.offset = 0;
   if(event.which == 13 || (!$(this).val()))
   {
       event.preventDefault();
       var $text = '';
       if($(this).val())
           $text = $(this).val();
       document.filters.$text = $text;
       var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
       $.ajax({
           url: '/search',
           type: 'post',
           dataType: 'html',
           data: {_token: CSRF_TOKEN, filter: document.filters, offset: document.offset
           }
       })
           .done(function(data) {
              console.log('success');
               refreshFunds(data);
           })
           .fail(function() {
               console.log("error");

           })
           .always(function() {

           });
   }
});

$(".page-link").on('click', onPage);

function onPage(event) {
    event.preventDefault();
    var me = event.target;
    $(".page-link").parent().removeClass('active');
    $(me).parent().addClass('active');
    document.offset = parseInt($(this).html())-1;
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: '/search',
        type: 'post',
        dataType: 'html',
        data: {
            _token: CSRF_TOKEN, filter: document.filters, offset: document.offset
        }
    })
        .done(function (data) {
            console.log('success');
            refreshFunds(data);
        })
        .fail(function () {
            console.log("error");

        })
}

function refreshFunds(res) {
    var tmp = jQuery.parseJSON(res);
    var data = tmp.result;
    var count = tmp.count/8;
    $('#list').empty();
    // var d = jQuery.parseJSON(data);
    for(var i=0; i<data.length; i++) {
        var el = data[i];
        var item = $(document.fundItem).clone();
        $(item).find('.list-span').html(el.name);
        $(item).find('a').attr('href','#description-' + el.id);
        $(item).find('div').attr('id', 'description-' + el.id);
        var editViewLinks  = $(item).find("#editViewLinks");
        $(item).find('div').text(el.farsi);
        $(editViewLinks).find('.editLink').attr('href','fund/'+el.id);
        $(editViewLinks).find('.viewLink').attr('href','show/fund/'+el.id);
        $(item).find('div').append(editViewLinks);
        $('#list').append(item);
    }

    $('.pagination').empty();
    for(var u=0; u<=count; u++){
        var page = $('<li class="page-item"><a class="page-link"></a></li>');
        var anch = $(page).find('a');
        $(anch).html(u+1);
        $(anch).on('click', onPage);
        if(u == document.offset)
            $(anch).parent().addClass('active');
        $('.pagination').append(page);
    }

    $("#list").collapse();

}
