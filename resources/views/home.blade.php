@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 chart-container">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Tickets by Priority</div>

                    <div class="card-body">
                        <!-- Chart's container -->
                        <div id="bar_chart" style="height: 300px;"></div>
                        <!-- Charting library -->
                        <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
                        <!-- Chartisan -->
                        <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
                        <!-- Your application script -->
                        <script>
                            const bar_chart = new Chartisan({
                                el: '#bar_chart',
                                url: "@chart('bar_chart')",
                                hooks: new ChartisanHooks()
                                    .legend()
                                    .tooltip(),

                            });
                        </script>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Tickets by Type</div>

                        <div class="card-body">
                        
                            <!-- Chart's container -->
                            <div id="pie_chart" style="height: 300px;"></div>
                            <!-- Charting library -->
                            <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
                            <!-- Chartisan -->
                            <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
                            <!-- Your application script -->
                            <script>
                            
                                // This example only works for
                                // echarts front-end library.

                                const pie_chart = new Chartisan({
                                el: '#pie_chart',
                                url: "@chart('pie_chart')",
                                hooks: new ChartisanHooks()
                                    .legend()
                                    //.colors()
                                    .tooltip()
                                    .axis(false)
                                    // .custom(({ data }) => ({
                                    //     ...data,
                                    //     series: data.series.map((serie = any) => ({
                                    //         ...serie,
                                    //         label: { show: false },
                                    //     })),
                                    // }))
                                    .datasets([
                                    { type: 'pie', radius: ['40%', '60%'] },
                                    ]),
                                });
                                
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
