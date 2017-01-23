<!-- charts -->
<script src="<?=base_url()?>assets/lib/flot/jquery.flot.min.js"></script>
<script src="<?=base_url()?>assets/lib/flot/jquery.flot.resize.min.js"></script>
<script src="<?=base_url()?>assets/lib/flot/jquery.flot.pie.min.js"></script>
<script src="<?=base_url()?>assets/lib/flot/jquery.flot.curvedLines.min.js"></script>
<script src="<?=base_url()?>assets/lib/flot/jquery.flot.orderBars.min.js"></script>
<script src="<?=base_url()?>assets/lib/flot/jquery.flot.multihighlight.min.js"></script>
<script src="<?=base_url()?>assets/lib/flot/jquery.flot.pyramid.js"></script>
<script src="<?=base_url()?>assets/lib/flot/jquery.flot.time.min.js"></script>
<script src="<?=base_url()?>assets/lib/flot/jquery.flot.crosshair.min.js"></script>
<script src="<?=base_url()?>assets/lib/flot.tooltip/jquery.flot.tooltip.min.js"></script>
<script src="<?=base_url()?>assets/lib/moment/moment.min.js"></script>

<script>

    $(document).ready(function() {

        //* small charts
        gebo_peity.init();
        gebo_charts.fl_c();

    });

    //* small charts
    gebo_peity = {
        init: function() {
            $.fn.peity.defaults.line = {
                strokeWidth: 1,
                delimiter: ",",
                height: 32,
                max: null,
                min: 0,
                width: 50
            };
            $.fn.peity.defaults.bar = {
                delimiter: ",",
                height: 32,
                max: null,
                min: 0,
                spacing: 1,
                width: 50
            };
            $(".p_bar_up_1 span").peity("bar",{
                colours: ["#6cc334"]
            });
            $(".p_bar_up_2 span").peity("bar",{
                colours: ["#F5F5F5"]
            });
            $(".p_bar_up_3 span").peity("bar",{
                colours: ["#b4dbeb"]
            });
            $(".p_bar_up_4 span").peity("bar",{
                colours: ["#f7bfc3"]
            });
        }
    };

    //* charts
    gebo_charts = {


        fl_c : function() {
            var elem = $('#fl_c');

            var d1 = [
                [new Date('09/23/2016').getTime(),350],
                [new Date('09/24/2016').getTime(),422],
                [new Date('09/25/2016').getTime(),550],
                [new Date('09/26/2016').getTime(),608],
                [new Date('09/27/2016').getTime(),681],
                [new Date('09/28/2016').getTime(),591],
                [new Date('09/29/2016').getTime(),510]
            ];

            var d2 = [
                [new Date('09/23/2016').getTime(),1200],
                [new Date('09/24/2016').getTime(),1400],
                [new Date('09/25/2016').getTime(),1500],
                [new Date('09/26/2016').getTime(),1200],
                [new Date('09/27/2016').getTime(),1340],
                [new Date('09/28/2016').getTime(),1421],
                [new Date('09/29/2016').getTime(),1510]
            ];

            var d3 = [
                [new Date('09/23/2016').getTime(),120],
                [new Date('09/24/2016').getTime(),100],
                [new Date('09/26/2016').getTime(),140],
                [new Date('09/27/2016').getTime(),153],
                [new Date('09/28/2016').getTime(),184],
                [new Date('09/29/2016').getTime(),226]
            ];

            // add 2h to match utc+2
            for (var i1 = 0; i1 < d1.length; ++i1) {d1[i1][0] += 60 * 120 * 1000}
            for (var i2 = 0; i2 < d2.length; ++i2) {d2[i2][0] += 60 * 120 * 1000}
            for (var i3 = 0; i3 < d3.length; ++i3) {d3[i3][0] += 60 * 120 * 1000}

            var ds = [];

            ds.push({
                label: "Umum",
                data:d1,
                bars: {
                    show: true,
                    barWidth: 60 * 220 * 1000,
                    order: 1,
                    lineWidth : 2,
                    fill: 1
                }
            });
            ds.push({
                label: "BPJS",
                data:d2,
                bars: {
                    show: true,
                    barWidth: 60 * 220 * 1000,
                    order: 2,
                    fill: 1
                }
            });
            ds.push({
                label: "Asuransi",
                data:d3,
                bars: {
                    show: true,
                    barWidth: 60 * 220 * 1000,
                    order: 3,
                    fill: 1
                }
            });

            var options = {
                grid:{
                    hoverable:true
                },
                xaxis: {
                    mode: "time",
                    minTickSize: [1, "day"],
                    autoscaleMargin: 0.10

                },
                colors: [ "#b4dbeb", "#8cc7e0", "#64b4d5", "#3ca0ca", "#2d83a6", "#22637e", "#174356", "#0c242e" ]
            };

            $.plot(elem, ds, options);

        },

    };


</script>

<!--chart-->
<div class="row">

    <div class="col-sm-3 tac">

        <div class="wBlock red clearfix">
            <div class="dSpace">
                <h3>Umum</h3>
                <div class="p_bar_up p_bar_up_1 p_canvas">
                    <span style="display: none;">2,4,9,7,12,8,16</span>
                    <canvas class="peity" style="height: 32px; width: 50px;" height="32" width="50"></canvas>
                </div>
                <span class="number">69</span>
            </div>
            <div class="rSpace">
                <span>69 Patient</span> <span>%49 Percentage</span>
                <span>IDR 828,000</span>
            </div>
        </div>

    </div>

    <div class="col-sm-3 tac">

        <div class="wBlock green clearfix">
            <div class="dSpace">
                <h3>BPJS</h3>
                <div class="p_bar_up p_bar_up_2 p_canvas">
                    <span style="display: none;">2,4,9,7,12,8,16</span>
                    <canvas class="peity" style="height: 32px; width: 50px;" height="32" width="50"></canvas>
                </div>
                <span class="number">71</span>
            </div>
            <div class="rSpace">
                <span>71 Patient</span> <span>%50 Percentage</span>
                <span>IDR 852,000</span>
            </div>
        </div>

    </div>

    <div class="col-sm-3 tac">

        <div class="wBlock yellow clearfix">
            <div class="dSpace">
                <h3>Asuransi</h3>
                <div class="p_bar_up p_bar_up_3 p_canvas">
                    <span style="display: none;">2,4,9,7,12,8,16</span>
                    <canvas class="peity" style="height: 32px; width: 50px;" height="32" width="50"></canvas>
                </div>
                <span class="number">0</span>
            </div>
            <div class="rSpace">
                <span>0 Patient</span> <span>%0 Percentage</span>
                <span>IDR 0</span>
            </div>
        </div>

    </div>

    <div class="col-sm-3 tac">

        <div class="wBlock blue clearfix">
            <div class="dSpace">
                <h3>Kontraktor</h3>
                <div class="p_bar_up p_bar_up_4 p_canvas">
                    <span style="display: none;">2,4,9,7,12,8,16</span>
                    <canvas class="peity" style="height: 32px; width: 50px;" height="32" width="50"></canvas>
                </div>
                <span class="number">0</span>
            </div>
            <div class="rSpace">
                <span>0 Patient</span> <span>%0 Percentage</span>
                <span>IDR 0</span>
            </div>
        </div>

    </div>

    <div class="col-sm-6 col-md-6 tac">
        <div id="fl_c" style="height: 270px; width: 90%; margin: 15px auto 0px; padding: 0px; position: relative;"><canvas class="flot-base" width="538" height="270" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 538px; height: 270px;"></canvas><div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);"><div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 53px; top: 253px; left: 13px; text-align: center;">May 21</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 53px; top: 253px; left: 67px; text-align: center;">May 22</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 53px; top: 253px; left: 122px; text-align: center;">May 23</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 53px; top: 253px; left: 176px; text-align: center;">May 24</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 53px; top: 253px; left: 230px; text-align: center;">May 25</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 53px; top: 253px; left: 285px; text-align: center;">May 26</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 53px; top: 253px; left: 339px; text-align: center;">May 27</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 53px; top: 253px; left: 393px; text-align: center;">May 28</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 53px; top: 253px; left: 448px; text-align: center;">May 29</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 53px; top: 253px; left: 502px; text-align: center;">May 30</div></div><div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div class="flot-tick-label tickLabel" style="position: absolute; top: 241px; left: 20px; text-align: right;">0</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 181px; left: 8px; text-align: right;">500</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 121px; left: 2px; text-align: right;">1000</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 61px; left: 2px; text-align: right;">1500</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 1px; left: 2px; text-align: right;">2000</div></div></div><canvas class="flot-overlay" width="538" height="270" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 538px; height: 270px;"></canvas><div class="legend"><div style="position: absolute; width: 54px; height: 63px; top: 13px; right: 23px; background-color: rgb(255, 255, 255); opacity: 0.85;"> </div><table style="position:absolute;top:13px;right:23px;;font-size:smaller;color:#545454"><tbody><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid rgb(180,219,235);overflow:hidden"></div></div></td><td class="legendLabel">Data 1</td></tr><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid rgb(140,199,224);overflow:hidden"></div></div></td><td class="legendLabel">Data 2</td></tr><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid rgb(100,180,213);overflow:hidden"></div></div></td><td class="legendLabel">Data 3</td></tr></tbody></table></div></div>
    </div>

</div>
<!--/chart-->