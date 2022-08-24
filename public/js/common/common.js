    
      $(function() {
        $(document).on("click", ".change-status", function() {
            if (confirm("Do you really want to change status?")) {

                var actionDiv = $(this); 
                var id = actionDiv.attr('data-id');  
                var flash = actionDiv.attr('flash');
                var table = actionDiv.attr('table');
                let status = actionDiv.attr('status').trim() === "1" ? "2" : "1";
    
                $.ajax({
                    url: base_url+'change-status',
                    type: "POST",
                    dataType: "json",
                    data: {
                        pk_id: id,
                        table: table,
                        flashdata_message: flash,
                        status: status
                    },
                    beforeSend: function() {
                        actionDiv.html(
                            "<i class='fa fa-spin fa-spinner' style='color: #0c0c0c !important;'></i>"
                        );
                    },
                    success: function(data) {
                        if (data.status == true) {
                            /*$this.html("<span class='text-success text-black' >Success</span>");*/
                            actionDiv.attr("status", status);
                            success_toast(data.name, data.message);
                            setTimeout(function() {
                                if (status == "1") {
                                    actionDiv.html(
                                        "<i class='fa fa-toggle-on tgle-on' aria-hidden='true' title='Active'></i>"
                                    );
                                } else {
                                    actionDiv.html(
                                        "<i class='fa fa-toggle-on tgle-off fa-rotate-180' aria-hidden='true' title='In-Active'></i>"
                                    );
                                }
                            }, 1000);
                        } else {
                            fail_toast(data.error, data.message);
                            setTimeout(function() {
                                actionDiv.html(
                                    "<i class='fa fa-toggle-on tgle-off fa-rotate-180' aria-hidden='true' title='In-Active'></i>"
                                );
                            }, 1000);
                        }
                    }
                });
            }
        });
    });


    
    $(document).on('click', '.delete-record', function() 
    {           
        var actionDiv = $(this); 
        var id = actionDiv.attr('data-id');  
        var flash = actionDiv.attr('flash');
        var table = actionDiv.attr('table');
        
        if (confirm('Do you really want to delete this record ?')) {
            $.ajax({
                url: base_url+'soft-delete',                    
                type: 'POST',
                dataType: 'json',
                data: {pk_id:id,flashdata_message:flash,table:table},
                beforeSend: function() {
                    actionDiv.html(
                        "<i class='fa fa-spin fa-spinner' style='color: #0c0c0c !important;'></i>"
                    );
                },
                success: function(data) {
                    success_toast(data.name, data.message);
                    reload_table();                                 
                }
            });
        }
    });
    
    
    