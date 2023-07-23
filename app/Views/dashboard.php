<?php
    use App\Models\Crud;
    $this->Crud = new Crud();
?>
<?=$this->extend('designs/backend');?>
<?=$this->section('title');?>
    <?=$title;?>
<?=$this->endSection();?>

<?=$this->section('content');?>

 <!-- Admin Dashboard -->
<?php if($role == 'administrator' || $role == 'developer') { ?>
    <!-- content @s -->
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Website Analytics</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Welcome to Analytics Dashboard.</p>
                                </div>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu">
                                        <ul class="nk-block-tools g-3">
                                            <li>
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-calender-date"></em><span><span class="d-none d-md-inline">Last</span> 30 Days</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="#"><span>Last 30 Days</span></a></li>
                                                            <li><a href="#"><span>Last 6 Months</span></a></li>
                                                            <li><a href="#"><span>Last 1 Years</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="nk-block-tools-opt"><a href="#" class="btn btn-primary"><em class="icon ni ni-reports"></em><span>Reports</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    <div class="nk-block">
                        <div class="row g-gs">
                            <div class="col-lg-7 col-xxl-6">
                                <div class="card card-bordered h-100">
                                    <div class="card-inner">
                                        <div class="card-title-group pb-3 g-2">
                                            <div class="card-title card-title-sm">
                                                <h6 class="title">Audience Overview</h6>
                                                <p>How have your users, sessions, bounce rate metrics trended.</p>
                                            </div>
                                            <div class="card-tools shrink-0 d-none d-sm-block">
                                                <ul class="nav nav-switch-s2 nav-tabs bg-white">
                                                    <li class="nav-item"><a href="#" class="nav-link">7 D</a></li>
                                                    <li class="nav-item"><a href="#" class="nav-link active">1 M</a></li>
                                                    <li class="nav-item"><a href="#" class="nav-link">3 M</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="analytic-ov">
                                            <div class="analytic-data-group analytic-ov-group g-3">
                                                <div class="analytic-data analytic-ov-data">
                                                    <div class="title">Users</div>
                                                    <div class="amount">2.57K</div>
                                                    <div class="change up"><em class="icon ni ni-arrow-long-up"></em>12.37%</div>
                                                </div>
                                                <div class="analytic-data analytic-ov-data">
                                                    <div class="title">Sessions</div>
                                                    <div class="amount">3.98K</div>
                                                    <div class="change up"><em class="icon ni ni-arrow-long-up"></em>47.74%</div>
                                                </div>
                                                <div class="analytic-data analytic-ov-data">
                                                    <div class="title">Users</div>
                                                    <div class="amount">28.49%</div>
                                                    <div class="change down"><em class="icon ni ni-arrow-long-down"></em>12.37%</div>
                                                </div>
                                                <div class="analytic-data analytic-ov-data">
                                                    <div class="title">Users</div>
                                                    <div class="amount">7m 28s</div>
                                                    <div class="change down"><em class="icon ni ni-arrow-long-down"></em>0.35%</div>
                                                </div>
                                            </div>
                                            <div class="analytic-ov-ck">
                                                <canvas class="analytics-line-large" id="analyticOvData"></canvas>
                                            </div>
                                            <div class="chart-label-group ms-5">
                                                <div class="chart-label">01 Jan, 2020</div>
                                                <div class="chart-label d-none d-sm-block">15 Jan, 2020</div>
                                                <div class="chart-label">30 Jan, 2020</div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .card -->
                            </div><!-- .col -->
                            <div class="col-md-6 col-lg-5 col-xxl-3">
                                <div class="card card-bordered h-100">
                                    <div class="card-inner">
                                        <div class="card-title-group align-start pb-3 g-2">
                                            <div class="card-title card-title-sm">
                                                <h6 class="title">Active Users</h6>
                                                <p>How do your users visited in the time.</p>
                                            </div>
                                            <div class="card-tools">
                                                <em class="card-hint icon ni ni-help" data-bs-toggle="tooltip" data-bs-placement="left" title="Users of this month"></em>
                                            </div>
                                        </div>
                                        <div class="analytic-au">
                                            <div class="analytic-data-group analytic-au-group g-3">
                                                <div class="analytic-data analytic-au-data">
                                                    <div class="title">Monthly</div>
                                                    <div class="amount">9.28K</div>
                                                    <div class="change up"><em class="icon ni ni-arrow-long-up"></em>4.63%</div>
                                                </div>
                                                <div class="analytic-data analytic-au-data">
                                                    <div class="title">Weekly</div>
                                                    <div class="amount">2.69K</div>
                                                    <div class="change down"><em class="icon ni ni-arrow-long-down"></em>1.92%</div>
                                                </div>
                                                <div class="analytic-data analytic-au-data">
                                                    <div class="title">Daily (Avg)</div>
                                                    <div class="amount">0.94K</div>
                                                    <div class="change up"><em class="icon ni ni-arrow-long-up"></em>3.45%</div>
                                                </div>
                                            </div>
                                            <div class="analytic-au-ck">
                                                <canvas class="analytics-au-chart" id="analyticAuData"></canvas>
                                            </div>
                                            <div class="chart-label-group">
                                                <div class="chart-label">01 Jan, 2020</div>
                                                <div class="chart-label">30 Jan, 2020</div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .card -->
                            </div><!-- .col -->
                            <div class="col-md-6 col-lg-5 col-xxl-3">
                                <div class="card card-bordered h-100">
                                    <div class="card-inner">
                                        <div class="card-title-group align-start pb-3 g-2">
                                            <div class="card-title card-title-sm">
                                                <h6 class="title">Website Performance</h6>
                                                <p>How has performend this month.</p>
                                            </div>
                                            <div class="card-tools">
                                                <em class="card-hint icon ni ni-help" data-bs-toggle="tooltip" data-bs-placement="left" title="Performance of this month"></em>
                                            </div>
                                        </div>
                                        <div class="analytic-wp">
                                            <div class="analytic-wp-group g-3">
                                                <div class="analytic-data analytic-wp-data">
                                                    <div class="analytic-wp-graph">
                                                        <div class="title">Bounce Rate <span>(avg)</span></div>
                                                        <div class="analytic-wp-ck">
                                                            <canvas class="analytics-line-small" id="BounceRateData"></canvas>
                                                        </div>
                                                    </div>
                                                    <div class="analytic-wp-text">
                                                        <div class="amount amount-sm">23.59%</div>
                                                        <div class="change up"><em class="icon ni ni-arrow-long-up"></em>4.5%</div>
                                                        <div class="subtitle">vs. last month</div>
                                                    </div>
                                                </div>
                                                <div class="analytic-data analytic-wp-data">
                                                    <div class="analytic-wp-graph">
                                                        <div class="title">Pageviews <span>(avg)</span></div>
                                                        <div class="analytic-wp-ck">
                                                            <canvas class="analytics-line-small" id="PageviewsData"></canvas>
                                                        </div>
                                                    </div>
                                                    <div class="analytic-wp-text">
                                                        <div class="amount amount-sm">5.48</div>
                                                        <div class="change down"><em class="icon ni ni-arrow-long-down"></em>-1.48%</div>
                                                        <div class="subtitle">vs. last month</div>
                                                    </div>
                                                </div>
                                                <div class="analytic-data analytic-wp-data">
                                                    <div class="analytic-wp-graph">
                                                        <div class="title">New Users <span>(avg)</span></div>
                                                        <div class="analytic-wp-ck">
                                                            <canvas class="analytics-line-small" id="NewUsersData"></canvas>
                                                        </div>
                                                    </div>
                                                    <div class="analytic-wp-text">
                                                        <div class="amount amount-sm">549</div>
                                                        <div class="change up"><em class="icon ni ni-arrow-long-up"></em>6.8%</div>
                                                        <div class="subtitle">vs. last month</div>
                                                    </div>
                                                </div>
                                                <div class="analytic-data analytic-wp-data">
                                                    <div class="analytic-wp-graph">
                                                        <div class="title">Time on Site <span>(avg)</span></div>
                                                        <div class="analytic-wp-ck">
                                                            <canvas class="analytics-line-small" id="TimeOnSiteData"></canvas>
                                                        </div>
                                                    </div>
                                                    <div class="analytic-wp-text">
                                                        <div class="amount amount-sm">3m 35s</div>
                                                        <div class="change up"><em class="icon ni ni-arrow-long-up"></em>1.4%</div>
                                                        <div class="subtitle">vs. last month</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .card -->
                            </div><!-- .col -->
                            <div class="col-lg-7 col-xxl-6">
                                <div class="card card-bordered h-100">
                                    <div class="card-inner mb-n2">
                                        <div class="card-title-group">
                                            <div class="card-title card-title-sm">
                                                <h6 class="title">Traffic Channel</h6>
                                                <p>Top traffic channels metrics.</p>
                                            </div>
                                            <div class="card-tools">
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle dropdown-indicator btn btn-sm btn-outline-light btn-white" data-bs-toggle="dropdown">30 Days</a>
                                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="#"><span>7 Days</span></a></li>
                                                            <li><a href="#"><span>15 Days</span></a></li>
                                                            <li><a href="#"><span>30 Days</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-list is-loose traffic-channel-table">
                                        <div class="nk-tb-item nk-tb-head">
                                            <div class="nk-tb-col nk-tb-channel"><span>Channel</span></div>
                                            <div class="nk-tb-col nk-tb-sessions"><span>Sessions</span></div>
                                            <div class="nk-tb-col nk-tb-prev-sessions"><span>Prev Sessions</span></div>
                                            <div class="nk-tb-col nk-tb-change"><span>Change</span></div>
                                            <div class="nk-tb-col nk-tb-trend tb-col-sm text-end"><span>Trend</span></div>
                                        </div><!-- .nk-tb-head -->
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead">Organic Search</span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-sessions">
                                                <span class="tb-sub tb-amount"><span>4,305</span></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-prev-sessions">
                                                <span class="tb-sub tb-amount"><span>4,129</span></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-change">
                                                <span class="tb-sub"><span>4.29%</span> <span class="change up"><em class="icon ni ni-arrow-long-up"></em></span></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-trend text-end">
                                                <div class="traffic-channel-ck ms-auto">
                                                    <canvas class="analytics-line-small" id="OrganicSearchData"></canvas>
                                                </div>
                                            </div>
                                        </div><!-- .nk-tb-item -->
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead">Social Media</span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-sessions">
                                                <span class="tb-sub tb-amount"><span>859</span></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-prev-sessions">
                                                <span class="tb-sub tb-amount"><span>936</span></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-change">
                                                <span class="tb-sub"><span>15.8%</span> <span class="change down"><em class="icon ni ni-arrow-long-down"></em></span></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-trend text-end">
                                                <div class="traffic-channel-ck ms-auto">
                                                    <canvas class="analytics-line-small" id="SocialMediaData"></canvas>
                                                </div>
                                            </div>
                                        </div><!-- .nk-tb-item -->
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead">Referrals</span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-sessions">
                                                <span class="tb-sub tb-amount"><span>482</span></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-prev-sessions">
                                                <span class="tb-sub tb-amount"><span>793</span></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-change">
                                                <span class="tb-sub"><span>41.3%</span> <span class="change down"><em class="icon ni ni-arrow-long-down"></em></span></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-trend text-end">
                                                <div class="traffic-channel-ck ms-auto">
                                                    <canvas class="analytics-line-small" id="ReferralsData"></canvas>
                                                </div>
                                            </div>
                                        </div><!-- .nk-tb-item -->
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col nk-tb-channel">
                                                <span class="tb-lead">Others</span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-sessions">
                                                <span class="tb-sub tb-amount"><span>138</span></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-prev-sessions">
                                                <span class="tb-sub tb-amount"><span>97</span></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-change">
                                                <span class="tb-sub"><span>12.6%</span> <span class="change up"><em class="icon ni ni-arrow-long-up"></em></span></span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-trend text-end">
                                                <div class="traffic-channel-ck ms-auto">
                                                    <canvas class="analytics-line-small" id="OthersData"></canvas>
                                                </div>
                                            </div>
                                        </div><!-- .nk-tb-item -->
                                    </div><!-- .nk-tb-list -->
                                </div><!-- .card -->
                            </div><!-- .col -->
                            <div class="col-md-6 col-xxl-3">
                                <div class="card card-bordered h-100">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title card-title-sm">
                                                <h6 class="title">Traffic Channel</h6>
                                            </div>
                                            <div class="card-tools">
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle dropdown-indicator btn btn-sm btn-outline-light btn-white" data-bs-toggle="dropdown">30 Days</a>
                                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="#"><span>7 Days</span></a></li>
                                                            <li><a href="#"><span>15 Days</span></a></li>
                                                            <li><a href="#"><span>30 Days</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="traffic-channel">
                                            <div class="traffic-channel-doughnut-ck">
                                                <canvas class="analytics-doughnut" id="TrafficChannelDoughnutData"></canvas>
                                            </div>
                                            <div class="traffic-channel-group g-2">
                                                <div class="traffic-channel-data">
                                                    <div class="title"><span class="dot dot-lg sq" data-bg="#9cabff"></span><span>Organic Search</span></div>
                                                    <div class="amount">4,305 <small>58.63%</small></div>
                                                </div>
                                                <div class="traffic-channel-data">
                                                    <div class="title"><span class="dot dot-lg sq" data-bg="#b8acff"></span><span>Social Media</span></div>
                                                    <div class="amount">859 <small>23.94%</small></div>
                                                </div>
                                                <div class="traffic-channel-data">
                                                    <div class="title"><span class="dot dot-lg sq" data-bg="#ffa9ce"></span><span>Referrals</span></div>
                                                    <div class="amount">482 <small>12.94%</small></div>
                                                </div>
                                                <div class="traffic-channel-data">
                                                    <div class="title"><span class="dot dot-lg sq" data-bg="#f9db7b"></span><span>Others</span></div>
                                                    <div class="amount">138 <small>4.49%</small></div>
                                                </div>
                                            </div><!-- .traffic-channel-group -->
                                        </div><!-- .traffic-channel -->
                                    </div>
                                </div><!-- .card -->
                            </div><!-- .col -->
                            <div class="col-md-6 col-xxl-3">
                                <div class="card card-bordered h-100">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title card-title-sm">
                                                <h6 class="title">Users by Country</h6>
                                            </div>
                                            <div class="card-tools">
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle dropdown-indicator btn btn-sm btn-outline-light btn-white" data-bs-toggle="dropdown">30 Days</a>
                                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="#"><span>7 Days</span></a></li>
                                                            <li><a href="#"><span>15 Days</span></a></li>
                                                            <li><a href="#"><span>30 Days</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="analytics-map">
                                            <div class="vector-map" id="worldMap"></div>
                                            <table class="analytics-map-data-list">
                                                <tr class="analytics-map-data">
                                                    <td class="country">United States</td>
                                                    <td class="amount">12,094</td>
                                                    <td class="percent">23.54%</td>
                                                </tr>
                                                <tr class="analytics-map-data">
                                                    <td class="country">India</td>
                                                    <td class="amount">7,984</td>
                                                    <td class="percent">7.16%</td>
                                                </tr>
                                                <tr class="analytics-map-data">
                                                    <td class="country">Turkey</td>
                                                    <td class="amount">6,338</td>
                                                    <td class="percent">6.54%</td>
                                                </tr>
                                                <tr class="analytics-map-data">
                                                    <td class="country">Bangladesh</td>
                                                    <td class="amount">4,749</td>
                                                    <td class="percent">5.29%</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div><!-- .card -->
                            </div><!-- .col -->
                            <div class="col-xxl-6">
                                <div class="card card-bordered h-100">
                                    <div class="card-inner mb-n2">
                                        <div class="card-title-group">
                                            <div class="card-title card-title-sm">
                                                <h6 class="title">Browser Used</h6>
                                            </div>
                                            <div class="card-tools">
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle dropdown-indicator btn btn-sm btn-outline-light btn-white" data-bs-toggle="dropdown">30 Days</a>
                                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="#"><span>7 Days</span></a></li>
                                                            <li><a href="#"><span>15 Days</span></a></li>
                                                            <li><a href="#"><span>30 Days</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-list is-loose">
                                        <div class="nk-tb-item nk-tb-head">
                                            <div class="nk-tb-col"><span>Browser</span></div>
                                            <div class="nk-tb-col text-end"><span>Users</span></div>
                                            <div class="nk-tb-col"><span>% Users</span></div>
                                            <div class="nk-tb-col tb-col-sm text-end"><span>Bounce Rate</span></div>
                                        </div><!-- .nk-tb-head -->
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col">
                                                <div class="icon-text">
                                                    <em class="text-primary icon ni ni-globe"></em>
                                                    <span class="tb-lead">Google Chrome</span>
                                                </div>
                                            </div>
                                            <div class="nk-tb-col text-end">
                                                <span class="tb-sub tb-amount"><span>1,641</span></span>
                                            </div>
                                            <div class="nk-tb-col">
                                                <div class="progress progress-md progress-alt bg-transparent">
                                                    <div class="progress-bar" data-progress="72.84"></div>
                                                    <div class="progress-amount">72.84%</div>
                                                </div>
                                            </div>
                                            <div class="nk-tb-col tb-col-sm text-end">
                                                <span class="tb-sub">22.62%</span>
                                            </div>
                                        </div><!-- .nk-tb-item -->
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col">
                                                <div class="icon-text">
                                                    <em class="text-danger icon ni ni-globe"></em>
                                                    <span class="tb-lead">Mozilla Firefox</span>
                                                </div>
                                            </div>
                                            <div class="nk-tb-col text-end">
                                                <span class="tb-sub tb-amount"><span>497</span></span>
                                            </div>
                                            <div class="nk-tb-col">
                                                <div class="progress progress-md progress-alt bg-transparent">
                                                    <div class="progress-bar" data-progress="7.93"></div>
                                                    <div class="progress-amount">7.93%</div>
                                                </div>
                                            </div>
                                            <div class="nk-tb-col tb-col-sm text-end">
                                                <span class="tb-sub">20.49%</span>
                                            </div>
                                        </div><!-- .nk-tb-item -->
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col">
                                                <div class="icon-text">
                                                    <em class="text-info icon ni ni-globe"></em>
                                                    <span class="tb-lead">Safari Browser</span>
                                                </div>
                                            </div>
                                            <div class="nk-tb-col text-end">
                                                <span class="tb-sub tb-amount"><span>187</span></span>
                                            </div>
                                            <div class="nk-tb-col">
                                                <div class="progress progress-md progress-alt bg-transparent">
                                                    <div class="progress-bar" data-progress="4.87"></div>
                                                    <div class="progress-amount">4.87%</div>
                                                </div>
                                            </div>
                                            <div class="nk-tb-col tb-col-sm text-end">
                                                <span class="tb-sub">21.34%</span>
                                            </div>
                                        </div><!-- .nk-tb-item -->
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col">
                                                <div class="icon-text">
                                                    <em class="text-orange icon ni ni-globe"></em>
                                                    <span class="tb-lead">UC Browser</span>
                                                </div>
                                            </div>
                                            <div class="nk-tb-col text-end">
                                                <span class="tb-sub tb-amount"><span>96</span></span>
                                            </div>
                                            <div class="nk-tb-col">
                                                <div class="progress progress-md progress-alt bg-transparent">
                                                    <div class="progress-bar" data-progress="2.46"></div>
                                                    <div class="progress-amount">2.46%</div>
                                                </div>
                                            </div>
                                            <div class="nk-tb-col tb-col-sm text-end">
                                                <span class="tb-sub">20.33%</span>
                                            </div>
                                        </div><!-- .nk-tb-item -->
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col">
                                                <div class="icon-text">
                                                    <em class="text-blue icon ni ni-globe"></em>
                                                    <span class="tb-lead">Edge / IE</span>
                                                </div>
                                            </div>
                                            <div class="nk-tb-col text-end">
                                                <span class="tb-sub tb-amount"><span>28</span></span>
                                            </div>
                                            <div class="nk-tb-col">
                                                <div class="progress progress-md progress-alt bg-transparent">
                                                    <div class="progress-bar" data-progress="1.14"></div>
                                                    <div class="progress-amount">1.14%</div>
                                                </div>
                                            </div>
                                            <div class="nk-tb-col tb-col-sm text-end">
                                                <span class="tb-sub">21.34%</span>
                                            </div>
                                        </div><!-- .nk-tb-item -->
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col">
                                                <div class="icon-text">
                                                    <em class="text-purple icon ni ni-globe"></em>
                                                    <span class="tb-lead">Other Browser</span>
                                                </div>
                                            </div>
                                            <div class="nk-tb-col text-end">
                                                <span class="tb-sub tb-amount"><span>683</span></span>
                                            </div>
                                            <div class="nk-tb-col">
                                                <div class="progress progress-md progress-alt bg-transparent">
                                                    <div class="progress-bar" data-progress="10.76"></div>
                                                    <div class="progress-amount">10.76%</div>
                                                </div>
                                            </div>
                                            <div class="nk-tb-col tb-col-sm text-end">
                                                <span class="tb-sub">20.49%</span>
                                            </div>
                                        </div><!-- .nk-tb-item -->
                                    </div><!-- .nk-tb-list -->
                                </div><!-- .card -->
                            </div><!-- .col -->
                            <div class="col-md-6 col-xxl-3">
                                <div class="card card-bordered h-100">
                                    <div class="card-inner mb-n2">
                                        <div class="card-title-group">
                                            <div class="card-title card-title-sm">
                                                <h6 class="title">Pages View by Users</h6>
                                            </div>
                                            <div class="card-tools">
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle dropdown-indicator btn btn-sm btn-outline-light btn-white" data-bs-toggle="dropdown">30 Days</a>
                                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="#"><span>7 Days</span></a></li>
                                                            <li><a href="#"><span>15 Days</span></a></li>
                                                            <li><a href="#"><span>30 Days</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-list is-compact">
                                        <div class="nk-tb-item nk-tb-head">
                                            <div class="nk-tb-col"><span>Page</span></div>
                                            <div class="nk-tb-col text-end"><span>Page Views</span></div>
                                        </div><!-- .nk-tb-head -->
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col">
                                                <span class="tb-sub"><span>/</span></span>
                                            </div>
                                            <div class="nk-tb-col text-end">
                                                <span class="tb-sub tb-amount"><span>2,879</span></span>
                                            </div>
                                        </div><!-- .nk-tb-item -->
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col">
                                                <span class="tb-sub"><span>/subscription/index.html</span></span>
                                            </div>
                                            <div class="nk-tb-col text-end">
                                                <span class="tb-sub tb-amount"><span>2,094</span></span>
                                            </div>
                                        </div><!-- .nk-tb-item -->
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col">
                                                <span class="tb-sub"><span>/general/index.html</span></span>
                                            </div>
                                            <div class="nk-tb-col text-end">
                                                <span class="tb-sub tb-amount"><span>1,634</span></span>
                                            </div>
                                        </div><!-- .nk-tb-item -->
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col">
                                                <span class="tb-sub"><span>/crypto/index.html</span></span>
                                            </div>
                                            <div class="nk-tb-col text-end">
                                                <span class="tb-sub tb-amount"><span>1,497</span></span>
                                            </div>
                                        </div><!-- .nk-tb-item -->
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col">
                                                <span class="tb-sub"><span>/invest/index.html</span></span>
                                            </div>
                                            <div class="nk-tb-col text-end">
                                                <span class="tb-sub tb-amount"><span>1,349</span></span>
                                            </div>
                                        </div><!-- .nk-tb-item -->
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col">
                                                <span class="tb-sub"><span>/subscription/profile.html</span></span>
                                            </div>
                                            <div class="nk-tb-col text-end">
                                                <span class="tb-sub tb-amount"><span>984</span></span>
                                            </div>
                                        </div><!-- .nk-tb-item -->
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col">
                                                <span class="tb-sub"><span>/general/index-crypto.html</span></span>
                                            </div>
                                            <div class="nk-tb-col text-end">
                                                <span class="tb-sub tb-amount"><span>879</span></span>
                                            </div>
                                        </div><!-- .nk-tb-item -->
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col">
                                                <span class="tb-sub"><span>/apps/messages/index.html</span></span>
                                            </div>
                                            <div class="nk-tb-col text-end">
                                                <span class="tb-sub tb-amount"><span>598</span></span>
                                            </div>
                                        </div><!-- .nk-tb-item -->
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col">
                                                <span class="tb-sub"><span>/general/index-crypto.html</span></span>
                                            </div>
                                            <div class="nk-tb-col text-end">
                                                <span class="tb-sub tb-amount"><span>436</span></span>
                                            </div>
                                        </div><!-- .nk-tb-item -->
                                    </div><!-- .nk-tb-list -->
                                </div><!-- .card -->
                            </div><!-- .col -->
                            <div class="col-md-6 col-xxl-3">
                                <div class="card card-bordered h-100">
                                    <div class="card-inner h-100 stretch flex-column">
                                        <div class="card-title-group">
                                            <div class="card-title card-title-sm">
                                                <h6 class="title">Sessions by Device</h6>
                                            </div>
                                            <div class="card-tools">
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle dropdown-indicator btn btn-sm btn-outline-light btn-white" data-bs-toggle="dropdown">30 Days</a>
                                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="#"><span>7 Days</span></a></li>
                                                            <li><a href="#"><span>15 Days</span></a></li>
                                                            <li><a href="#"><span>30 Days</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="device-status my-auto">
                                            <div class="device-status-ck">
                                                <canvas class="analytics-doughnut" id="deviceStatusData"></canvas>
                                            </div>
                                            <div class="device-status-group">
                                                <div class="device-status-data">
                                                    <em data-color="#798bff" class="icon ni ni-monitor"></em>
                                                    <div class="title">Desktop</div>
                                                    <div class="amount">84.5%</div>
                                                    <div class="change up text-danger"><em class="icon ni ni-arrow-long-up"></em>4.5%</div>
                                                </div>
                                                <div class="device-status-data">
                                                    <em data-color="#baaeff" class="icon ni ni-mobile"></em>
                                                    <div class="title">Mobile</div>
                                                    <div class="amount">14.2%</div>
                                                    <div class="change up text-danger"><em class="icon ni ni-arrow-long-up"></em>133.2%</div>
                                                </div>
                                                <div class="device-status-data">
                                                    <em data-color="#7de1f8" class="icon ni ni-tablet"></em>
                                                    <div class="title">Tablet</div>
                                                    <div class="amount">1.3%</div>
                                                    <div class="change up text-danger"><em class="icon ni ni-arrow-long-up"></em>25.3%</div>
                                                </div>
                                            </div><!-- .device-status-group -->
                                        </div><!-- .device-status -->
                                    </div>
                                </div><!-- .card -->
                            </div><!-- .col -->
                        </div><!-- .row -->
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>
    <!-- content @e -->
<?php } ?>
<span class="d-none" id="rev_chart"></span>

<?=$this->endSection();?>
<?=$this->section('scripts');?>
    <?php
        $pie_data = array();
        $pie = $this->Crud->read_single_order('country_id', 161, 'state', 'name', 'asc');
        foreach($pie as $key => $value){
            $pie_data[$key] = strtoupper($value->name);
        }
        
    ?>
    <script>
        var site_url = '<?php echo site_url(); ?>';   
        var calEvents = <?php if(!empty($pie_data)){ echo json_encode($pie_data); } ?>;
        var partner_chart = <?php echo $partner_chat; ?>;
        var ch_js = '<?php echo site_url('assets/backend/js/charts/chart-crm.js?v='.time()); ?>';   
        
        $(function() {
            load_sales_rev();load_sales_qty();load_top_fuel();load_least_fuel();
        });

        $('.typeBtn').click(function() {
            $('#date_type').val($(this).attr('data-value'));
            $('#filter_type').html($(this).html());
            $(this).addClass('active');
            $(this).siblings().removeClass('active');
            load_sales_rev();load_sales_qty();load_top_fuel();
        });

        $('.typeBtn1').click(function() {
            $('#date_type1').val($(this).attr('data-value'));
            $('#filter_type1').html($(this).html());
            $(this).addClass('active');
            $(this).siblings().removeClass('active');
            load_top_fuel();
        });

        $('.typeBtn2').click(function() {
            $('#date_type2').val($(this).attr('data-value'));
            $('#filter_type2').html($(this).html());
            $(this).addClass('active');
            $(this).siblings().removeClass('active');
            load_least_fuel();
        });

        function load_sales_rev(){
            
            $('#rev_data').html('<div class="col-sm-12 text-center"><i class="ni ni-loader" style="font-size:24px;"></i></div>');
            var date_type = $('#date_type').val();
            var date_from = $('#date_from').val();
            var date_to = $('#date_to').val();

            //$('#crt').html('<div class="col-sm-12 text-center"><i class="ni ni-loader" style="font-size:24px;"></i></div>');
        
            $.ajax({
                url: site_url + 'dashboard/sales_rev',
                type: 'post',
                data: { date_type: date_type, date_from: date_from, date_to: date_to },
                success: function (data) {
                    var dt = JSON.parse(data);
                    $('#rev_data').html(dt.rev_data);
                    $('#cat_text').html(dt.cat_text);
                    $('#rev_chart').html(dt.rev_chart);
                    $.getScript(site_url + '/assets/backend/js/charts/chart-crm.js');
                    
                },
                complete: function () {
                    //$('#crt').html('<canvas class="analytics-au-chart tesst" id="analyticAuData"></canvas>');
                    setTimeout(function(){
                       //$.getScript(ch_js);

                    }, 3000)
                    
                }

            });
        
        }

        function load_sales_qty(){            
            $('#category_pet').html('<div class="col-sm-12 text-center"><i class="ni ni-loader" style="font-size:24px;"></i></div>');
            $('#category_die').html('<div class="col-sm-12 text-center"><i class="ni ni-loader" style="font-size:24px;"></i></div>');
            $('#category_ker').html('<div class="col-sm-12 text-center"><i class="ni ni-loader" style="font-size:24px;"></i></div>');
            $('#category_gas').html('<div class="col-sm-12 text-center"><i class="ni ni-loader" style="font-size:24px;"></i></div>');
            var date_type = $('#date_type').val();
            var date_from = $('#date_from').val();
            var date_to = $('#date_to').val();
        
            $.ajax({
                url: site_url + 'dashboard/sales_qty',
                type: 'post',
                data: { date_type: date_type, date_from: date_from, date_to: date_to },
                success: function (data) {
                    var dt = JSON.parse(data);
                    $('#category_pet').html(dt.category_pet);
                    $('#category_die').html(dt.category_die);
                    $('#category_ker').html(dt.category_ker);
                    $('#category_gas').html(dt.category_gas);
                    
                }
            });
        
        }

        function load_top_fuel(){            
            $('#top_selling').html('<div class="col-sm-12 text-center"><i class="ni ni-loader" style="font-size:24px;"></i></div>');
            var date_type = $('#date_type1').val();
            var date_from = $('#date_from').val();
            var date_to = $('#date_to').val();
        
            $.ajax({
                url: site_url + 'dashboard/top_fuel',
                type: 'post',
                data: { date_type: date_type, date_from: date_from, date_to: date_to },
                success: function (data) {
                    var dt = JSON.parse(data);
                    $('#top_selling').html(dt.top_selling);
                    
                }
            });
        
        }

        function load_least_fuel(){            
            $('#least_selling').html('<div class="col-sm-12 text-center"><i class="ni ni-loader" style="font-size:24px;"></i></div>');
            var date_type = $('#date_type2').val();
            var date_from = $('#date_from').val();
            var date_to = $('#date_to').val();
        
            $.ajax({
                url: site_url + 'dashboard/least_fuel',
                type: 'post',
                data: { date_type: date_type, date_from: date_from, date_to: date_to },
                success: function (data) {
                    var dt = JSON.parse(data);
                    $('#least_selling').html(dt.least_selling);
                    
                }
            });
        
        }
        

    </script>
     <script src="<?=site_url();?>assets/backend/js/charts/chart-crm.js?v=<?=time(); ?>"></script>
    <?=$this->endSection();?>
