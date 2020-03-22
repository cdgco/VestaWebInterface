/** 
*
* Vesta Web Interface
*
* Copyright (C) 2020 Carter Roeser <carter@cdgtech.one>
* https://cdgco.github.io/VestaWebInterface
*
* Vesta Web Interface is free software: you can redistribute it and/or modify
* it under the terms of version 3 of the GNU General Public License as published 
* by the Free Software Foundation.
*
* Vesta Web Interface is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
* 
* You should have received a copy of the GNU General Public License
* along with Vesta Web Interface.  If not, see
* <https://github.com/cdgco/VestaWebInterface/blob/master/LICENSE>.
*
*/

if( $('li.dropdown.vwi-notif').length ) {
    $('li.dropdown.vwi-notif a').on('click', function (event) {
        $('li.dropdown.vwi-notif a').parent().toggleClass('open');
    });

    var numNotif = $('.mail-content-notif').length
    if(numNotif == 0) {
        $("#nonotifications").show(); 
    }
    else { 
        $("#nonotifications").hide();
    }
    $('body').on('click', function (e) {
        if( $('#activenotification').length ) {
                 $("#heartbeat").removeClass("heartbit");
                 $("#point").removeClass("point");
                 $("#bell").removeClass("fa-bell");
                 $("#bell").addClass("fa-bell-o");
             }

        if (!$('li.dropdown.vwi-notif').is(e.target) 
            && $('li.dropdown.vwi-notif').has(e.target).length === 0 
            && $('.open').has(e.target).length === 0
        ) {
            $('li.dropdown.vwi-notif').removeClass('open');
        }
    });

    function dismissNotification(e){
        var numNotif = $('.mail-content-notif').length
        e1 = String(e)
        $("#notification" + e1).fadeOut("normal", function() { $(this).remove(); } );
        $(".message-center").append('<div class="mail-content notif-loader"><h5><i class="fa fa-spinner fa-pulse"></i> Dismissing</h5><hr></div>');
        $.ajax({  
                type: "POST",  
                url: processLocation + "acknowledge-notification.php",  
                data: { 'num': e1 },
                success: function(data){ $(".notif-loader").fadeOut("normal", function() { $(this).remove(); } ); if(numNotif == 1) { $("#nonotifications").show(); } console.log("Notification " + e1 + " dismissed.")},
                error: function(){ $(".notif-loader").fadeOut("normal", function() { $(this).remove(); } ); if(numNotif == 1) { $("#nonotifications").show(); } alert("Notification Error. Please try again later."); } 
            });
        if($('.mail-content-notif').length == 1) { $("#nonotifications").show(); }
    }
}