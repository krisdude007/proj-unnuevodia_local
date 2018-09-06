/**
 * @fileoverview This demo is used for MarkerClusterer. It will show 100 markers
 * using MarkerClusterer and count the time to show the difference between using
 * MarkerClusterer and without MarkerClusterer.
 * @author Luke Mahe (v2 author: Xiaoxi Wu)
 */
var markerMgr = {};

markerMgr.records = null;
markerMgr.mapDisplayOnly = null;
markerMgr.map = null;
markerMgr.markerClusterer = null;
markerMgr.markers = [];
markerMgr.infoWindow = null;

markerMgr.init = function() {
    var options = {
      'mapTypeId': google.maps.MapTypeId.ROADMAP
    };

    markerMgr.map = new google.maps.Map(document.getElementById('map'), options);
    markerMgr.records = data.records;
    markerMgr.mapDisplayOnly = data.mapDisplayOnly;

    var useGmm = document.getElementById('usegmm');
    google.maps.event.addDomListener(useGmm, 'click', markerMgr.change);

    markerMgr.infoWindow = new google.maps.InfoWindow();

    markerMgr.showMarkers();
    var bounds = new google.maps.LatLngBounds();
    for(var i=0; i < markerMgr.records.length; i++){
        bounds.extend(new google.maps.LatLng(markerMgr.records[i].latitude, markerMgr.records[i].longitude));
    }
    markerMgr.map.fitBounds(bounds);
};

markerMgr.showMarkers = function() {
  markerMgr.markers = [];


  if (markerMgr.markerClusterer) {
    markerMgr.markerClusterer.clearMarkers();
  }

  //var panel = $('markerlist');
  //panel.innerHTML = '';

  for (var i = 0; i < markerMgr.records.length; i++) {
    /*
    var titleText = markerMgr.records[i].FirstName + ' ' + markerMgr.records[i].LastName;
    if (titleText == '') {
      titleText = 'Ananymous';
    }

    var item = document.createElement('DIV');
    var title = document.createElement('A');
    title.href = '#';
    title.className = 'title';
    title.innerHTML = titleText;

    item.appendChild(title);
    //panel.appendChild(item);
    */
    
    var latLng = new google.maps.LatLng(markerMgr.records[i].latitude,
        markerMgr.records[i].longitude);

    var imageUrl = '/core/webassets/images/mapNode.png';
    var markerImage = new google.maps.MarkerImage(imageUrl,
        new google.maps.Size(24, 32));

    var marker = new google.maps.Marker({
      'position': latLng,
      'icon': markerImage
    });

    var fn = markerMgr.markerClickFunction(markerMgr.records[i], latLng);
    google.maps.event.addListener(marker, 'click', fn);
    $('tr[id = "'+markerMgr.records[i].UserID+'"]').click(fn);
    //console.log(markerRow);
    //google.maps.event.addDomListener(markerRow, 'click', fn);
    markerMgr.markers.push(marker);
  }
  window.setTimeout(markerMgr.time, 0);
};

markerMgr.updateClickFunction = function(){
    for (var i = 0; i < markerMgr.records.length; i++) {
        var latLng = new google.maps.LatLng(markerMgr.records[i].latitude,
            markerMgr.records[i].longitude);
        var fn = markerMgr.markerClickFunction(markerMgr.records[i], latLng);
        $('tr[id = "'+markerMgr.records[i].UserID+'"]').click(fn);
    }
}

markerMgr.markerClickFunction = function(marker, latlng) {
  return function(e) {

    $(markerMgr.oTable.fnSettings().aoData).each(function (){
        $(this.nTr).removeClass('row_selected');

        if(marker.UserID == $(this.nTr).context.id) {
            
            $(this.nTr).addClass('row_selected');
            $(markerMgr.oTable.fnDisplayRow(this.nTr));
            //console.log(markerMgr.oTable.fnPagingInfo().iPage);
        }
    });
    
    e.cancelBubble = true;
    e.returnValue = false;
    if (e.stopPropagation) {
      e.stopPropagation();
      e.preventDefault();
    }
    
    var income = marker.AreaHouseholdIncome;
    if(income == null || income == 0){
        income = 'No data available';
    }else{
        income = '$' + income;
    }
    
    var infoHtml = '';
        infoHtml += '<div class="info">';
        infoHtml += markerMgr.attributeCanBeDisplayed('map_show_name', '<h3>' + marker.FirstName + ' ' + marker.LastName + '</h3>');
        infoHtml += '<div><table class="markerTable">';
        infoHtml += markerMgr.attributeCanBeDisplayed('map_show_email', '<tr><td>Email:</td><td><a href="mailto:' + marker.Email + '">' + marker.Email + '</a></td></tr>');
        infoHtml += markerMgr.attributeCanBeDisplayed('map_show_video_count', '<tr><td>Videos:</td><td>' + marker.Videos + '</td></tr>'); 
        infoHtml += markerMgr.attributeCanBeDisplayed('map_show_vote_count', '<tr><td>Votes:</td><td>' + marker.Votes + '</td></tr>');
        infoHtml += markerMgr.attributeCanBeDisplayed('map_show_zip', '<tr><td>Zip:</td><td>' + marker.ZipCode + '</td></tr>');
        infoHtml += markerMgr.attributeCanBeDisplayed('map_show_income', '<tr><td>Avg.&nbsp;Income:</td><td>' + income + '</td></tr>');
        infoHtml += '</table></div>';
        infoHtml += '</div>';

    markerMgr.infoWindow.setContent(infoHtml);
    markerMgr.infoWindow.setPosition(latlng);
    // zoom to node when clicked.
//    var bounds = new google.maps.LatLngBounds();
//    bounds.extend(latlng);
//    markerMgr.map.fitBounds(bounds);
    
    // display info window only if at least one map_show setting is enabled
    if(markerMgr.mapDisplayOnly.length != 0) {
      markerMgr.infoWindow.open(markerMgr.map);
    }
  };
};

markerMgr.attributeCanBeDisplayed = function(attribute, output) {
  
  var attributes = markerMgr.mapDisplayOnly; 
    for (var i = 0; i < attributes.length; i++) {
      if(attributes[i] == attribute) {
        return output;
      }
    }
    return '';
};

markerMgr.clear = function() {
  //$('timetaken').innerHTML = 'cleaning...';
  for (var i = 0, marker; marker = markerMgr.markers[i]; i++) {
    marker.setMap(null);
  }
};

markerMgr.change = function() {
  markerMgr.clear();
  markerMgr.showMarkers();
};

markerMgr.time = function() {
  //$('timetaken').innerHTML = 'timing...';
  //var start = new Date();
  if (document.getElementById('usegmm').checked) {
    markerMgr.markerClusterer = new MarkerClusterer(markerMgr.map, markerMgr.markers);
  } else {
    for (var i = 0, marker; marker = markerMgr.markers[i]; i++) {
      marker.setMap(markerMgr.map);
    }
  }

  //var end = new Date();
  //$('timetaken').innerHTML = end - start;
};