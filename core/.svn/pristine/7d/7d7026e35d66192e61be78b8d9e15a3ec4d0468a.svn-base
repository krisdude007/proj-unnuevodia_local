var tvScreenAppearSettingForm = function(el){
    $(".tvScreenSettingOverlayLink").overlay({
        mask: '#000',
        effect: 'default',
        top:0,
        closeOnClick: true,
        closeOnEsc: true,
        fixed: false,
        oneInstance: true,
        api: true,
        onBeforeLoad: function() {
            // grab wrapper element inside content
            var wrap = this.getOverlay().find(".tvScreenSettingOverlayContent");
            var url = this.getTrigger().attr("href");
           
            wrap.html('');
            wrap.load(url);
        }
    }); 
}
$(document).ready(function() {
    
    tvScreenAppearSettingForm();
     
}); 