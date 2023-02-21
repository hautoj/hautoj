<?php $show_title="首页 - $OJ_NAME"; ?>
<?php include("template/$OJ_TEMPLATE/header.php");?>
<div class="padding">
    <div class="ui three column grid">
        <div class="eleven wide column">
            <h4 class="ui top attached block header"><i class="ui info icon"></i>每日提交</h4>
            <div class="ui bottom attached segment">
                <div id="submissions-chart"></div>
            </div>

            <h4 class="ui top attached block header"><i class="ui info icon"></i><?php echo $MSG_NEWS;?></h4>
            <div class="ui bottom attached segment">
                <table class="ui very basic table">
                    <thead>
                        <tr>
                            <th><?php echo $MSG_TITLE;?></th>
                            <th><?php echo $MSG_TIME;?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_news = "select * FROM `news` WHERE `defunct`!='Y' AND `title`!='faqs.cn' ORDER BY `importance` ASC,`time` DESC LIMIT 10";
                        $result_news = mysql_query_cache( $sql_news );
                        if ( $result_news ) {
                            foreach ( $result_news as $row ) {
                                echo "<tr>"."<td>"
                                    ."<a href=\"viewnews.php?id=".$row["news_id"]."\">"
                                    .$row["title"]."</a></td>"
                                    ."<td>".$row["time"]."</td>"."</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <h4 class="ui top attached block header"><i class="ui star icon"></i><?php echo $OJ_INDEX_NEWS_TITLE;?></h4>
            <div class="ui bottom attached segment">
                <table class="ui very basic left aligned table" style="table-layout: fixed; ">
                    <tbody>

                        <?php
                        $sql_news = "select * FROM `news` WHERE `defunct`!='Y' AND `title`='$OJ_INDEX_NEWS_TITLE' ORDER BY `importance` ASC,`time` DESC";
                        $result_news = mysql_query_cache( $sql_news );
                        if ( $result_news ) {
                            foreach ( $result_news as $row ) {
                                echo "<tr>"."<td>"
                                    .bbcode_to_html($row["content"])."</td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
<!--        删除侧边栏-->
<!--        <div class="right floated five wide column">-->
<!--            <h4 class="ui top attached block header"><i class="ui rss icon"></i> --><?php //echo $MSG_RECENT_PROBLEM;?><!-- </h4>-->
<!--            <div class="ui bottom attached segment">-->
<!--                <table class="ui very basic center aligned table">-->
<!--                    <thead>-->
<!--                        <tr>-->
<!--                            <th width="60%">--><?php //echo $MSG_TITLE;?><!--</th>-->
<!--                            <th width="40%">--><?php //echo $MSG_TIME;?><!--</th>-->
<!--                        </tr>-->
<!--                    </thead>-->
<!--                    <tbody>-->
<!--                    --><?php
//                        $sql_problems = "select * FROM `problem` where defunct='N' ORDER BY `problem_id` DESC LIMIT 5";
//                        $result_problems = mysql_query_cache( $sql_problems );
//                        if ( $result_problems ) {
//                            $i = 1;
//                            foreach ( $result_problems as $row ) {
//                                echo "<tr>"."<td>"
//                                    ."<a href=\"problem.php?id=".$row["problem_id"]."\">"
//                                    .$row["title"]."</a></td>"
//                                    ."<td>".substr($row["in_date"],0,10)."</td>"."</tr>";
//                            }
//                        }
//                    ?>
<!--                    </tbody>-->
<!--                </table>-->
<!--            </div>-->
<!--            <h4 class="ui top attached block header"><i class="ui search icon"></i>--><?php //echo $MSG_SEARCH;?><!--</h4>-->
<!--            <div class="ui bottom attached segment">-->
<!--                <form action="problem.php" method="get">-->
<!--                    <div class="ui search" style="width: 100%; ">-->
<!--                        <div class="ui left icon input" style="width: 100%; ">-->
<!--                            <input class="prompt" style="width: 100%; " type="text" placeholder="--><?php //echo $MSG_PROBLEM_ID ;?><!-- …" name="id">-->
<!--                            <i class="search icon"></i>-->
<!--                        </div>-->
<!--                        <div class="results" style="width: 100%; "></div>-->
<!--                    </div>-->
<!--                </form>-->
<!--            </div>-->
<!--            <h4 class="ui top attached block header"><i class="ui calendar icon"></i>--><?php //echo $MSG_RECENT_CONTEST ;?><!--</h4>-->
<!--            <div class="ui bottom attached center aligned segment">-->
<!--                <table class="ui very basic center aligned table">-->
<!--                    <thead>-->
<!--                        <tr>-->
<!--                            <th>--><?php //echo $MSG_CONTEST_NAME;?><!--</th>-->
<!--                            <th>--><?php //echo $MSG_START_TIME;?><!--</th>-->
<!--                        </tr>-->
<!--                    </thead>-->
<!--                    <tbody>-->
<!--                    --><?php
//                        $sql_contests = "select * FROM `contest` where defunct='N' ORDER BY `contest_id` DESC LIMIT 5";
//                        $result_contests = mysql_query_cache( $sql_contests );
//                        if ( $result_contests ) {
//                            $i = 1;
//                            foreach ( $result_contests as $row ) {
//                                echo "<tr>"."<td>"
//                                    ."<a href=\"contest.php?cid=".$row["contest_id"]."\">"
//                                    .$row["title"]."</a></td>"
//                                    ."<td>".$row["start_time"]."</td>"."</tr>";
//                            }
//                        }
//                    ?>
<!--                    </tbody>-->
<!--                </table>-->
<!--            </div>-->
<!--        </div>-->
    </div>
</div>

<script src="https://cdn.bootcdn.net/ajax/libs/apexcharts/3.36.3/apexcharts.min.js"></script>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    var SUBMISSIONS_PER_DAY = <?php echo json_encode($chart_data_all); ?> ;
    var ACCEPTED_PER_DAY = <?php echo json_encode($chart_data_ac); ?> ;
    var dateArray = Array.from(SUBMISSIONS_PER_DAY).map(e => e[0]);
    var totalCounts = Array.from(SUBMISSIONS_PER_DAY).map(e => e[1]);
    var acCounts = Array.from(ACCEPTED_PER_DAY).map(e => e[1]);
    console.log(dateArray);
    var options = {
        series: [
            { name: '提交', data: totalCounts },
            { name: '通过', data: acCounts },
        ],
        chart: {
            height: 280,
            type: 'area',
            zoom: {
                enabled: false
            }
        },
        stroke: {
            width: 0.5,
            curve: 'straight'
        },
        dataLabels: {
            enabled: false
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.9,
                stops: [0, 100]
            }
        },
        xaxis: {
            categories: dateArray,
            labels: {
                formatter: function (val) {
                    // convert YYYY-mm-dd to mm-dd
                    var date = new Date(val);
                    return date.getMonth() + 1 + '/' + date.getDate();
                }
            }
        }
    };
    var chart = new ApexCharts(document.querySelector("#submissions-chart"), options);
    chart.render();
});
</script>
<?php include("template/$OJ_TEMPLATE/footer.php");?>
