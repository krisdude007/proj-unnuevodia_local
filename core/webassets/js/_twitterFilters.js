var filterHandler = function(){
    $('.removeFilter').off('click');
    $('.removeFilter').on('click',function(e){
        e.preventDefault();
        removeFilter($(this).attr('rel'));
    });
    $('.placeFilter').off('click');
    $('.placeFilter').on('click',function(){       
        if($('#placesInclude').val().length > 0){
            var include = $('#placesInclude').val().match(/\w+|"[^"]+"/g), i = include.length;
            while(i--){
                include[i] = include[i].replace(/"/g,"");
            }
            var incregex = '(?=.*?'+include.join( ')|(?=.*?' )+')';
        } else {
            var incregex = '';
        }            
        if($('#placesExclude').val().length > 0){
            var exclude = $('#placesExclude').val().match(/\w+|"[^"]+"/g), i = exclude.length;
            while(i--){
                exclude[i] = exclude[i].replace(/"/g,"");
            }
            var exregex = '(?!.*?'+exclude.join( ')(?!.*?' )+')';            
        } else {
            var exregex = '';
        }
        var regex = '^'+incregex+exregex+'.*$';
        rTable.fnFilter(regex,14,true);
        var description = Array();
        if(incregex != ''){
            description.push('Includes: '+include.join(','));
        }
        if(exregex != ''){
            description.push('Excludes: '+exclude.join(','));
        }        
        if(description.join(' and ') != ''){
            showFilter(14,'Location '+description.join(' and '));
        } else {
            removeFilter(14);
        }
    });        
    $('.locationFilter').off('change');
    $('.locationFilter').on('change',function(){
        rTable.fnFilter($(this).val(),13);
        if($(this).val() == ''){
            removeFilter(13);
        } else {
            var description = $(this).next().html();
            showFilter(13,description);                
        }
    });        
    $('.verifiedFilter').off('change');
    $('.verifiedFilter').on('change',function(){
        rTable.fnFilter($(this).val(),12);
        if($(this).val() == ''){
            removeFilter(12);
        } else {
            var description = $(this).next().html();
            showFilter(12,description);                
        }
    });        
    $('.accountLanguageInclusion').off('change');
    $('.accountLanguageInclusion').on('change',function(){
        accountLanguage();
    });
    $('.accountLanguageFilter').off('change');
    $('.accountLanguageFilter').on('change',function(){
        accountLanguage();
    });                
    $('.languageInclusion').off('change');
    $('.languageInclusion').on('change',function(){
        language();
    });
    $('.languageFilter').off('change');
    $('.languageFilter').on('change',function(){
        language();
    });            
    $('.mediaFilter').off('change');
    $('.mediaFilter').on('change',function(){        
        rTable.fnFilter($(this).val(),9);
        if($(this).val() == ''){
            removeFilter(9);
        } else {
            var description = $(this).next().html();
            showFilter(9,description);                
        }
    });        
    $('.accountProfanityFilter').off('change');
    $('.accountProfanityFilter').on('change',function(){
        rTable.fnFilter($(this).val(),8);
        if($(this).val() == ''){
            removeFilter(8);
        } else {
            var description = $(this).next().html();
            showFilter(8,description);                        
        }
    });
    $('.profanityFilter').off('change');
    $('.profanityFilter').on('change',function(){
        rTable.fnFilter($(this).val(),7);
        if($(this).val() == ''){
            removeFilter(7);
        } else {        
            var description = $(this).next().html();
            showFilter(7,description);                
        }
    });
    $('.categoryFilter').off('change');
    $('.categoryFilter').on('change',function(e){
        var search = $(this).val();
        rTable.fnFilter(search,6);
        if($(this).val() == ''){
            removeFilter(6);
        } else {        
            var description = 'Responses to: "'+$(this).val()+'"';
            showFilter(6,description);                
        }
    });
    $('.keywordFilter').off('click');
    $('.keywordFilter').on('click',function(){       
        if($('#keywordsInclude').val().length > 0){
            var include = $('#keywordsInclude').val().match(/\w+|"[^"]+"/g), i = include.length;
            while(i--){
                include[i] = include[i].replace(/"/g,"");
            }
            var incregex = '(?=.*?'+include.join( ')|(?=.*?' )+')';
        } else {
            var incregex = '';
        }            
        if($('#keywordsExclude').val().length > 0){
            var exclude = $('#keywordsExclude').val().match(/\w+|"[^"]+"/g), i = exclude.length;
            while(i--){
                exclude[i] = exclude[i].replace(/"/g,"");
            }
            var exregex = '(?!.*?'+exclude.join( ')(?!.*?' )+')';            
        } else {
            var exregex = '';
        }
        if($('#keywordsEndsWith').val().length > 0){
            var ends = $('#keywordsEndsWith').val().match(/\w+|"[^"]+"/g), i = ends.length;
            while(i--){
                ends[i] = ends[i].replace(/"/g,"");
            }
            var endsregex = '.*?('+ends.join( '|' )+')';            
        } else {
            var endsregex = '';
        }        
        if($('#keywordsStartsWith').val().length > 0){
            var starts = $('#keywordsStartsWith').val().match(/\w+|"[^"]+"/g), i = starts.length;
            while(i--){
                starts[i] = starts[i].replace(/"/g,"");
            }
            var startsregex = '('+starts.join( '|' )+').*?';            
        } else {
            var startsregex = '';
        }
        var description = Array();
        var regex = new Array();
        if(startsregex != ''){
            regex.push(startsregex);
            description.push('Starts with: '+starts.join(','));            
        }
        if(incregex != '' || exregex != ''){
            regex.push(incregex+exregex+'.*');            
            if(incregex != ''){
                description.push('Includes: '+include.join(','));            
            }
            if(exregex != ''){
                description.push('Excludes: '+exclude.join(','));            
            }
        }        
        if(endsregex != ''){
            regex.push(endsregex);
            description.push('Ends with: '+ends.join(','));            
        }
        var regexString = regex.join('|'); 
        if(regex.length == 0){
            regexString = '.*'
        }
        regex = '^('+regexString+')$';
        rTable.fnFilter(regex,5,true);
        if(regexString == '.*'){
            removeFilter(5);
        } else {
            showFilter(5,'Tweet '+description.join(' and '));
        }
    });        
    $('.accountFilter').off('click');
    $('.accountFilter').on('click',function(){ 
        if($('#accountsInclude').val().length > 0){
            var include = $('#accountsInclude').val().match(/\w+|"[^"]+"/g), i = include.length;
            while(i--){
                include[i] = include[i].replace(/"/g,"");
            }
            var incregex = '(?=.*?'+include.join( ')|(?=.*?' )+')';
        } else {
            var incregex = '';
        }            
        if($('#accountsExclude').val().length > 0){
            var exclude = $('#accountsExclude').val().match(/\w+|"[^"]+"/g), i = exclude.length;
            while(i--){
                exclude[i] = exclude[i].replace(/"/g,"");
            }
            var exregex = '(?!.*?'+exclude.join( ')(?!.*?' )+')';            
        } else {
            var exregex = '';
        }
        if($('#accountsEndsWith').val().length > 0){
            var ends = $('#accountsEndsWith').val().match(/\w+|"[^"]+"/g), i = ends.length;
            while(i--){
                ends[i] = ends[i].replace(/"/g,"");
            }
            var endsregex = '.*?('+ends.join( '|' )+')';            
        } else {
            var endsregex = '';
        }        
        if($('#accountsStartsWith').val().length > 0){
            var starts = $('#accountsStartsWith').val().match(/\w+|"[^"]+"/g), i = starts.length;
            while(i--){
                starts[i] = starts[i].replace(/"/g,"");
            }
            var startsregex = '('+starts.join( '|' )+').*?';            
        } else {
            var startsregex = '';
        }
        var description = Array();
        var regex = new Array();
        if(startsregex != ''){
            regex.push(startsregex);
            description.push('Starts with: '+starts.join(','));            
        }
        if(incregex != '' || exregex != ''){
            regex.push(incregex+exregex+'.*');            
            if(incregex != ''){
                description.push('Includes: '+include.join(','));            
            }
            if(exregex != ''){
                description.push('Excludes: '+exclude.join(','));            
            }
        }        
        if(endsregex != ''){
            regex.push(endsregex);
            description.push('Ends with: '+ends.join(','));            
        }
        var regexString = regex.join('|'); 
        if(regex.length == 0){
            regexString = '.*'
        }
        regex = '^('+regexString+')$';
        rTable.fnFilter(regex,3,true);
        if(regexString == '.*'){
            removeFilter(3);
        } else {
            showFilter(3,'Username '+description.join(' and '));
        }
    });                
}

function resetAccountLanguage(){
    $(".accountLanguageFilter option:selected").removeAttr("selected");        
    rTable.fnFilter('',11);
    removeFilter(11);
}
function resetLanguage(){
    $(".languageFilter option:selected").removeAttr("selected");        
    rTable.fnFilter('',10);
    removeFilter(10);
}
var language = function(){
    var arr = $('.languageFilter').val();
    var description = 'Tweet language'
    if(arr.length > 0){
        if($('input:radio[name=languageInclusion]:checked').val() == 'include'){            
            description = description+' includes: ';
            var regex = '(?=.*?'+arr.join( ')|(?=.*?' )+')';
        } else {
            description = description+' excludes: ';
            var regex = '(?!.*?'+arr.join( ')(?!.*?' )+')';            
        }
    } else {
        var regex = '';
    }            
    var regex = '^'+regex+'.*$';
    rTable.fnFilter(regex,10,true);    
    showFilter(10,description+arr.join(', '));
}
var accountLanguage = function(){
    var arr = $('.accountLanguageFilter').val();
    var description = 'User language';
    if(arr.length > 0){
        if($('input:radio[name=accountLanguageInclusion]:checked').val() == 'include'){
            description = description+' includes: ';
            var regex = '(?=.*?'+arr.join( ')|(?=.*?' )+')';
        } else {
            description = description+' excludes: ';
            var regex = '(?!.*?'+arr.join( ')(?!.*?' )+')';            
        }
    } else {
        var regex = '';
    }            
    var regex = '^'+regex+'.*$';
    rTable.fnFilter(regex,11,true);    
    showFilter(11,description+arr.join(', '));
}

var removeFilter = function(column){
    var rSettings = rTable.fnSettings();
    columnString = rSettings.aoColumns[column].nTh.innerHTML.replace(' ','');
    var el = $('#'+columnString);
    el.remove();
    clearFilters(column);
}

var clearFilters = function(column){
    var rSettings = rTable.fnSettings();
    var collection = '';
    if(column){
        if(column != 15){
            rSettings.aoPreSearchCols[column].sSearch = '';
            columnString = rSettings.aoColumns[column].nTh.innerHTML.replace(' ','');
            collection = $('.'+columnString);        
        } else {            
            removeShapes();            
        }
    } else {
        removeShapes();
        for(i = 0; i < rSettings.aoPreSearchCols.length; i++) {
            rSettings.aoPreSearchCols[i].sSearch = '';
        }
        collection = $('.twitterFilter');
        $('#currentFilters').html('');
    }
    rTable.fnDraw();
    $.each(collection,function(i,e){
        switch($(e).prop('tagName')){
            case 'SELECT':
                $(e).val([]);                
                break;
            case 'INPUT':
                switch($(e).attr('type')){
                    case 'radio':
                        $('input[name="'+$(e).attr('name')+'"]').attr('checked', false);
                        $('input[name="'+$(e).attr('name')+'"]:first').attr('checked', true);
                        break;
                    case 'text':
                        $(e).val(''); 
                        break;
                    default:
                        break;
                }
                break;
            default:
                break;
        }
    });
}

var showFilter = function(column,description){
    var rSettings = rTable.fnSettings();
    columnString = rSettings.aoColumns[column].nTh.innerHTML.replace(' ','');
    var el = $('#'+columnString);
    if(el.length == 0){
        $('#currentFilters').append(
            $('<div>').addClass('filterDisplay').attr({'id':columnString}).append(
                $('<div>').css({'float':'left'}).addClass('description').html(description)
            ).append(
                $('<a>').addClass('removeFilter').html('X').attr({'href':'#','rel':column})
            )
        );
    } else {
        el.children('.description').html(description);
    }
    filterHandler();
}

//MAP FUNCTIONS!

var map = '';
var shapes = new Array();
var drawingManager;

function inBounds(geoArea){
    geoArea = geoArea.split(/,/);
    if(shapes.length == 0){
        return true;
    }
    if(geoArea == ''){
        return false;
    }
    var inside = false;
    if(geoArea.length == 2){
        var point = new google.maps.LatLng(geoArea[1],geoArea[0])
        $.each(shapes,function(i,e){
            if(e.getBounds().contains(point)){
                inside = true;
            }
        });
    } else {
        var polygon = new google.maps.LatLngBounds(
            new google.maps.LatLng(geoArea[1],geoArea[0]),
            new google.maps.LatLng(geoArea[7],geoArea[6])
        );
        $.each(shapes,function(i,e){
            if(e.getBounds().intersects(polygon)){
                inside = true;
            }
        });        
    }
    return(inside);
}

function removeShapes(){
    $.fn.dataTableExt.afnFiltering.splice(0,1);
    rTable.fnDraw(true);            
    $.each(shapes,function(i,e){
        e.setMap(null);
    });
    shapes = Array();
}
function initialize(lat, lng) {    
    var mapOptions = {
        zoom: 4,
        center: new google.maps.LatLng(lat, lng),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);

    drawingManager = new google.maps.drawing.DrawingManager({
        drawingMode: null,
        drawingControl: true,
        drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: [
                google.maps.drawing.OverlayType.RECTANGLE,
                google.maps.drawing.OverlayType.CIRCLE,
            ]
        },
        rectangleOptions:{
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            clickable: true,
            editable: false,
            zIndex: 1
        },
        circleOptions:{
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            clickable: true,
            editable: false,
            zIndex: 1
        },     
    });
    drawingManager.setMap(map);  
    google.maps.event.addListener(drawingManager, 'rectanglecomplete', function(e) {      
        shapes.push(e);
        showFilter(15,'Show Tweets in Selected Areas');
        $.fn.dataTableExt.afnFiltering.splice(0,1);
        $.fn.dataTableExt.afnFiltering.push(function (oSettings, aData, iDataIndex) {
            if(aData[15] == '' && aData[16] == ''){
                return false;
            }
            if (inBounds(aData[15]) || inBounds(aData[16])) {
                return true
            } else {
                return false;
            }
        });        
        rTable.fnDraw(true);
    });
    google.maps.event.addListener(drawingManager, 'circlecomplete', function(e) {
        shapes.push(e);
        showFilter(15,'Show Tweets in Selected Areas');
        $.fn.dataTableExt.afnFiltering.splice(0,1);
        $.fn.dataTableExt.afnFiltering.push(function (oSettings, aData, iDataIndex) {
            if(aData[15] == '' && aData[16] == ''){
                return false;
            }
            if (inBounds(aData[15]) || inBounds(aData[16])) {
                return true
            } else {
                return false;
            }
        });        
        rTable.fnDraw(true);
    });
}