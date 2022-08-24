    let base_url = $('#base_url').val();
    let _token   = $('meta[name="csrf-token"]').attr('content');
   
    
    $(document).on('click', '.superadmin-change-vendor-status', function() 
    {           
        var actionDiv = $(this); 
        var id = actionDiv.attr('data-id');  
        var flash = actionDiv.attr('flash');
        var table = actionDiv.attr('table');
        var status = actionDiv.attr('status');
        var alert_status = actionDiv.attr('alert_status');

        if(alert_status == 1){
            var on_alert_msg = "disable"
        }else if(alert_status == 2){
            var on_alert_msg = "enable"
        }else if(alert_status == 3){
            var on_alert_msg = "delete"
        }else{
            var on_alert_msg = "change status of"
        }
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        if (confirm('Do you really want to '+ on_alert_msg+' this record ?')) {
            $.ajax({
                url: base_url + '/superadmin-change-status-of-user',                    
                type: 'POST',
                dataType: 'json',
                headers:headers,
                data: {id:id,flashdata_message:flash,table:table,status:status},
                beforeSend: function() {
                    actionDiv.html(
                        "<i class='fa fa-spin fa-spinner' style='color: #0c0c0c !important;'></i>"
                    );
                },
                success: function(data) {
                    if (data.status == true) {
                        success_toast('', data.message);
                        reload_table();
                    }                         
                }
            });
        }
    });

    $(document).on('click', '.cityadmin-change-vendor-status', function() 
    {           
        var actionDiv = $(this); 
        var id = actionDiv.attr('data-id');  
        var flash = actionDiv.attr('flash');
        var table = actionDiv.attr('table');
        var status = actionDiv.attr('status');
        var alert_status = actionDiv.attr('alert_status');

        if(alert_status == 1){
            var on_alert_msg = "disable"
        }else if(alert_status == 2){
            var on_alert_msg = "enable"
        }else if(alert_status == 3){
            var on_alert_msg = "delete"
        }else{
            var on_alert_msg = "change status of"
        }
        
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        if (confirm('Do you really want to '+ on_alert_msg+' this record ?')) {
            $.ajax({
                url: base_url + '/cityadmin-change-status-of-user',                    
                type: 'POST',
                dataType: 'json',
                headers:headers,
                data: {id:id,flashdata_message:flash,table:table,status:status},
                beforeSend: function() {
                    actionDiv.html(
                        "<i class='fa fa-spin fa-spinner' style='color: #0c0c0c !important;'></i>"
                    );
                },
                success: function(data) {
                    if (data.status == true) {
                        success_toast('', data.message);
                        reload_table();
                    }                         
                }
            });
        }
    });

    $(document).on('click', '.delete-record', function() 
    {           
        var actionDiv = $(this); 
        var id = actionDiv.attr('data-id');  
        var flash = actionDiv.attr('flash');
        var table = actionDiv.attr('table');
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        if (confirm('Do you really want to delete this record ?')) {
            $.ajax({
                url: base_url + '/soft-delete',                    
                type: 'POST',
                dataType: 'json',
                headers:headers,
                data: {id:id,flashdata_message:flash,table:table},
                beforeSend: function() {
                    actionDiv.html(
                        "<i class='fa fa-spin fa-spinner' style='color: #0c0c0c !important;'></i>"
                    );
                },
                success: function(data) {
                    if (data.status == true) {
                        success_toast('', data.message);
                        reload_table();
                    }                         
                }
            });
        }
    });
    
    


 $(document).on('click', '.delete-record-of-city-admin', function() 
    {           
        var actionDiv = $(this); 
        var id = actionDiv.attr('data-id');  
        var flash = actionDiv.attr('flash');
        var table = actionDiv.attr('table');
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        if (confirm('Do you really want to delete this record ?')) {
            $.ajax({
                url: base_url + '/soft-delete-of-city-admin',                    
                type: 'POST',
                dataType: 'json',
                headers:headers,
                data: {id:id,flashdata_message:flash,table:table},
                beforeSend: function() {
                    actionDiv.html(
                        "<i class='fa fa-spin fa-spinner' style='color: #0c0c0c !important;'></i>"
                    );
                },
                success: function(data) {
                    if (data.status == true) {
                        success_toast('', data.message);
                        reload_table();
                    }                         
                }
            });
        }
    });
    

     $(document).on('click', '.delete-record-of-vendor', function() 
    {           
        var actionDiv = $(this); 
        var id = actionDiv.attr('data-id');  
        var flash = actionDiv.attr('flash');
        var table = actionDiv.attr('table');
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        if (confirm('Do you really want to delete this record ?')) {
            $.ajax({
                url: base_url + '/soft-delete-of-vendor',                    
                type: 'POST',
                dataType: 'json',
                headers:headers,
                data: {id:id,flashdata_message:flash,table:table},
                beforeSend: function() {
                    actionDiv.html(
                        "<i class='fa fa-spin fa-spinner' style='color: #0c0c0c !important;'></i>"
                    );
                },
                success: function(data) {
                    if (data.status == true) {
                        success_toast('', data.message);
                        reload_table();
                    }                         
                }
            });
        }
    });
    