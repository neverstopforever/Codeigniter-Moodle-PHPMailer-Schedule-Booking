<!--BEGIN PAGE CONTAINER -->
<div class="page-container">
    <div class="table_loading"></div>
    <!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
        <div class="<?php echo $layoutClass ?>">
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo $_base_url; ?>" ><?= $this->lang->line('menu_Home') ?></a>
                </li>
                <li>
                    <a href="javascript:;"><?php echo $this->lang->line('menu_academics'); ?></a>
                </li>
                <li class="active">
                    <?php echo $this->lang->line('festivities_festivities');?>
                </li>
            </ul>
            <div class="panel panel-default">
                <div class="panel-body" id="bookly-tbs">
                    <!-- Navigation for calendar like : 2016 -->
                    <div class="bookly-holidays-nav">
                        <div class="input-group input-group-lg">
                            <!--Previous navigation for calendar like : 2015 -->
                            <div class="input-group-btn">
                                <button class="btn btn-default bookly-js-jCalBtn" data-trigger=".jCal .left" type="button">
                                    <i class="fa fa-chevron-left">&nbsp;</i>
                                </button>
                            </div>
                            <input class="form-control text-center jcal_year" id="appendedPrependedInput" readonly="" type="text" value="">
                             
                            <!-- Next navigation for calendar like : 2017 -->
                            <div class="input-group-btn">
                                <button class="btn btn-default bookly-js-jCalBtn" style="border-radius: 0 7px 7px 0!important;" data-trigger=".jCal .right" type="button">
                                    <i class="fa fa-chevron-right">&nbsp;</i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Intilize festivity calendar on this div -->
                    <div id="festivities_calendar" class="bookly-js-holidays jCal-wrap bookly-margin-top-lg"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT -->
</div>

<script>
var festivities       = <?php echo isset($festivities) ? json_encode($festivities) : json_encode(array()) ?>;
var selected_language = '<?php echo isset($selected_language) ? $selected_language : 'spanish' ?>';
</script>
<!-- Original Code of Jcal from refernce site -->
<!-- <script>
    jQuery(function ($) {
        var d = new Date();
        $('.bookly-js-holidays').jCal({
            day         : new Date(d.getFullYear(), 0, 1),
            days        : 1,
            showMonths  : 12,
            scrollSpeed : 350,
            events      : {"2":{"m":1,"d":1},"13":{"m":1,"d":21},"24":{"m":2,"d":18},"35":{"m":5,"d":27},"46":{"m":7,"d":4},"57":{"m":9,"d":2},"68":{"m":10,"d":14},"79":{"m":11,"d":11},"90":{"m":11,"d":28},"101":{"m":12,"d":25},"111":{"m":10,"d":17,"y":2016},"112":{"m":10,"d":18,"y":2016},"113":{"m":10,"d":19,"y":2016},"114":{"m":10,"d":20,"y":2016},"115":{"m":10,"d":21,"y":2016},"116":{"m":10,"d":22,"y":2016},"117":{"m":10,"d":23,"y":2016},"118":{"m":10,"d":24,"y":2016},"119":{"m":10,"d":25,"y":2016},"120":{"m":10,"d":26,"y":2016},"121":{"m":10,"d":27,"y":2016},"122":{"m":10,"d":28,"y":2016},"123":{"m":10,"d":29,"y":2016},"124":{"m":10,"d":30,"y":2016}},
            action      : 'ab_staff_holidays_update',
            staff_id    : 1,
            dayOffset   : 1,
            loadingImg  : "http:\/\/demo1.booking-wp-plugin.com\/wp-content\/plugins\/appointment-booking\/backend\/resources\/images\/loading.gif"        });

        $('.bookly-js-jCalBtn').on('click', function(e) {
            e.preventDefault();
            var trigger = $(this).data('trigger');
            $('.bookly-js-holidays').find($(trigger)).trigger('click');
        })
    });
</script>