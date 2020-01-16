(function () {

})();



function newGraph(graph, data) {
    graph.find('graph-area').css('height', graph.width() * 0.75 + "px");
    return {
        me: graph,
        xAxis: graph.find('graph-x'),
        yAxis: graph.find('graph-y'),
        pointArea: graph.find('graph-area'),
        data: data,
        addPoint: function(graphInfo, pointArea, point, orderNumber, color) {
            pointArea.append('<graph-point color="' + color + '"></graph-point>');
            pointArea.find('graph-point').last().css({
                top: 100 - ((point.y / graphInfo.max) * 100) + '%',
                left: orderNumber + '%'
            });
        },
        drawLine: function(pointArea, drawFrom, drawTo, color) {
            pointArea.prepend('<svg>' +
                '<line x1="' + drawFrom[0].offsetLeft + '" y1="' + drawFrom[0].offsetTop + '" x2="' + drawTo[0].offsetLeft + '" y2="' + drawTo[0].offsetTop + '" style="stroke:' + color + ';stroke-width:2" />' +
                'Sorry, your browser does not support inline SVG.' +
                '</svg>');
        }
    };
}

function setUpGraph(graph) {
    var color = ['#800000', '#4F7700', '#004D4D', '#006600'];
    for (var i = 0; i < graph.data.item[0].points.length; i++)
        graph.xAxis.append('<graph-x-item>' + graph.data.item[0].points[i].x + '</graph-x-item>').find('graph-x-item').last().css('left', ((graph.pointArea.width() / 11) * (i + 1)) * 100 / graph.pointArea.width() + '%');
    for (var i = 0; i < 10; i++)
        graph.yAxis.append('<graph-y-item>' + (((graph.data.max - graph.data.min) / 10) * i).toFixed(1) + '</graph-y-item>').find('graph-y-item').last().css('top', 100 - (i * 10) + '%');
    graph.yAxis.append('<graph-y-item>' + graph.data.max + '</graph-y-item>');

    for (var j = 0; j < graph.data.item.length; j++) {
        for (var l = 0; l < graph.data.item[j].points.length; l++) {
            var point = graph.data.item[j].points[l];
            if (point == undefined)
                break;
            graph.addPoint(graph.data, graph.pointArea, point, ((graph.pointArea.width() / 11) * (l + 1)) * 100 / graph.pointArea.width(), color[j]);
            if (l != 0)
                graph.drawLine(graph.pointArea, graph.pointArea.find('graph-point').last().prev(), graph.pointArea.find('graph-point').last(), color[j]);
        }
    }
}

/*
  Progress Circle
*/
function updatePC(percent, circle) {
  circle.find('style').remove();
    circle.append(function() {
      var circleStyle;
    
      //setting back (before) circle
      if (percent == 0) return "";
      else if (percent > 0 && percent < 50)
        circleStyle =
          "progress-circle:before { border-color: #353535 #353535 #353535 #BAB8B8;}";
      else if (percent >= 50 && percent < 75)
        circleStyle =
          "progress-circle:before { border-color: #353535 #353535 #BAB8B8 #BAB8B8;}";
      else if (percent >= 75 && percent < 100)
        circleStyle =
          "progress-circle:before { border-color: #353535 #BAB8B8 #BAB8B8 #BAB8B8;}";
      else if (percent == 100)
        circleStyle = "progress-circle:before { border-color: #BAB8B8;}";
    
      //setting front (after) circle
      if (percent > 0 && percent <= 25)
        circleStyle +=
          "progress-circle:after { border-left-color: #353535; transform: translate(-50%, -50%) rotate(" + (45 - (360 * percent / 100)) + "deg) }";
      else if (percent > 25 && percent <= 100)
        circleStyle +=
          "progress-circle:after { border-left-color: #BAB8B8; transform: translate(-50%, -50%) rotate(" + (135 - (360 * percent / 100)) + "deg) }";
    
      return "<style>" + circleStyle + "</style>";
    }).find('progress-circle-percent').text(percent + '%');
}


function fullPageLoad(toggle) {
    switch(toggle) {
        case 'off': $('panel-content').removeClass('loading').children().removeClass('disabled'); break;
        case 'on': $('panel-content').addClass('loading').children().addClass('disabled'); break;
    }
}


function setUpDropdowns() {
    $('dropdown-current').click(function () {
        $(this).closest('dropdown').toggleClass('active'); 
    });
    $('dropdown-options-item').click(function () {
        let ddHead = $(this).closest('dropdown').find('dropdown-head');
        
        ddHead.find('dropdown-current').text($(this).text());
        ddHead.find('input').val($(this).attr('data-id'));
        $(this).closest('dropdown').removeClass('active');
    });
}

function updateProgBar() {
    $('.prog-bar').each(function () {
        let percent = $(this).attr('data-prog');
        $(this).find('.prog-bar-bg').css('width', percent+'%');
    });
}

function setDD(sectionTag) {
    $(sectionTag).find('.dd-tab').click(function () {
        $(this).parent().toggleClass('active');
    });
}

function setBLDD(sectionTag) {
    $(sectionTag).find('.box-dropdown-click').click(function () {
        $(this).closest('.box-dropdown').toggleClass('active');
    });
}

function setRadioInput(sectionTag) {
    $(sectionTag).find('.isb-radio').each(function () {
        let radioSection = $(this), radioInput = radioSection.children('input').eq(0);
        $(this).find('.input-select-item').click(function () {
            radioSection.find('.active').removeClass('active');
            radioInput.val($(this).find('input').val());
            $(this).addClass('active');
        });
    });
}

function setSelectInput(sectionTag) {
    $(sectionTag).find('.input-select').not('.isb-radio').each(function () {
        $(this).find('.input-select-item').click(function () {
            $(this).toggleClass('active');
            $(this).find('input').val(1-$(this).find('input').val());
        });
    });
}

function autocomplete(div) {
    let typeLock = false, updateValues = function (text) {
        typeLock = true;
        paneljs.fetch({type:'api', call:div.attr('data-category')+'/autocomplete', postData:{type:div.attr('data-item'), text:text}}, (data) => {
            data = data.data;
            div.find('.autocomplete-list').empty();
            for (var i = 0; i < data.length; i++) {
                div.find('.autocomplete-list').append('<div class="autocomplete-item" data-id="'+data[i].id+'">'+data[i].name+'</div>');
            }
            
            div.find('.autocomplete-item').click(function () {
                div.find('input[type=text]').val($(this).text());
                div.find('input[type=hidden]').eq(0).val($(this).attr('data-id'));
                div.find('.autocomplete-list').empty();
            });
            
            typeLock = false;
        });
    };
    div.find('input[type=text]').on('input', function() {
        div.find('input[type="hidden"]').eq(0).val($(this).val());
        if (!typeLock && $(this).val().length !== 0) updateValues($(this).val());
        else div.find('.autocomplete-list').empty();
    }).focusout(function (e) {

    });
}

