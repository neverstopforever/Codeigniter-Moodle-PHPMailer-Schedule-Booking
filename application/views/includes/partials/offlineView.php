<div class="modal fade" id="offline_message" tabindex="-1" role="offline_message" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

            </div>
            <div class="modal-body"><?php echo $this->lang->line('offline_mes'); ?>?</div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script src="<?php echo base_url(); ?>app/offline/offline.js"></script>
<script>
    (function($) {
        var run = function(){
//        var req = new XMLHttpRequest();
//        req.timeout = 5000;
//        req.open('GET', base_url+'ajax/checkConnection?offline=no', true);
//        req.setRequestHeader("X-Requested-With",'XMLHttpRequest');
//        req.send();
            $.ajax({
                method: 'GET',
                headers: {'X-Requested-With': 'XMLHttpRequest'},
                url: base_url+'ajax/checkConnection?offline=no',
                async: true,
                error: function(data){
                    // will fire when timeout is reached
                },
                success: function(data){
                    //do something
                },
                timeout: 5000 // sets timeout to 5 seconds
            });
        };
        setInterval(run, 5000);
    })(jQuery);

    function alertMes(){
        $("#offline_message").modal();
    }
</script>
