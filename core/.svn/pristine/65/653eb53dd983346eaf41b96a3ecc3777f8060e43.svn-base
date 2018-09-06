var changeHandlers = function(){ 
    $('.fab-onoffswitch-checkbox').off('change'); 
    $('.fab-onoffswitch-checkbox').on('change',function(e){ 
        var obj = new Object; 
        obj.value = +$(this).is(':checked'); 
        obj.id = $(this).attr('id').match(/\d+/)[0];
        obj.CSRF_TOKEN = getCsrfToken();
        var request = $.ajax({ 
            url:"/admin/saveSetting", 
            type:'POST', 
            data:$.param(obj), 
            success: function(data){ 
                if(!data){ 
                    alert('failed to save.'); 
                } 
            }                             
        });         
    }); 
} 

$(document).ready(function () { 
    App.init(); // init the rest of plugins and elements 

    $("ul#fab-collapsed li.fab-first").click(function () { 

        if ($('#fab-nav-collapsed').hasClass('fab-small')) { 

            $('.fab-text').css('display', 'block'); 
            $('#fab-nav-collapsed').removeClass('fab-small'); 
            $('#fab-nav-collapsed').addClass('fab-large'); 
            $('.fab-page-content').css('margin-left', '107px'); 


        } else if ($('#fab-nav-collapsed').hasClass('fab-large')) { 

            $('.fab-text').css('display', 'none'); 
            $('#fab-nav-collapsed').removeClass('fab-large'); 
            $('#fab-nav-collapsed').addClass('fab-small'); 
            $('.fab-page-content').css('margin-left', '51px'); 

        } 
    }); 

    // workaround for webkit browsers 
    $(".fab-nav-collapse").on('shown',function () { 
        $(this).removeClass("collapse"); 
    }).on('hidden', function () { 
        $(this).removeClass("collapse"); 
    }); 


    var handleChoosenSelect = function () { 
        if (!jQuery().chosen) { 
            return; 
        } 
        $(".fab-chosen").chosen(); 
        $(".fab-chosen-with-diselect").chosen({ 
            allow_single_deselect: true 
        }); 
    } 

    var handleMainMenu = function () { 
        jQuery('.fab-page-sidebar .fab-has-sub > a').click(function () { 

            var handleContentHeight = function() { 
                /*    var content = $('.fab-page-content'); 
                            var sidebar = $('.fab-page-sidebar'); 

                            if (!content.attr("data-height")) { 
                                content.attr("data-height", content.height()); 
                            } 

                            if (sidebar.height() > content.height()) { 
                                content.height(sidebar.height() + 20);     
                            } else { 
                                content.height(content.attr("data-height")); 
                            }*/ 
                $('.fab-page-sidebar').css('height','auto');  
            } 

            var last = jQuery('.fab-has-sub.fab-open', $('.fab-page-sidebar')); 
            if (last.size() == 0) { 
            //last = jQuery('.has-sub.active', $('.page-sidebar')); 
            } 
            last.removeClass("fab-open"); 
            jQuery('.fab-arrow', last).removeClass("fab-open"); 
            jQuery('.fab-sub', last).slideUp(200); 

            var sub = jQuery(this).next(); 
            if (sub.is(":visible")) { 
                jQuery('.fab-arrow', jQuery(this)).removeClass("fab-open"); 
                jQuery(this).parent().removeClass("fab-open"); 
                sub.slideUp(200, function(){ 
                    handleContentHeight(); 
                }); 
            } else { 
                jQuery('.arrow', jQuery(this)).addClass("fab-open"); 
                jQuery(this).parent().addClass("fab-open"); 
                sub.slideDown(200, function(){ 
                    handleContentHeight(); 
                }); 
            } 
        }); 
    } 
    handleChoosenSelect(); 
    handleMainMenu();  
}); 


changeHandlers(); 

