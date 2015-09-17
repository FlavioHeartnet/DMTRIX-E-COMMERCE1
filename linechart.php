<?php
/**
 * Created by PhpStorm.
 * User: joao.landino
 * Date: 11/05/2015
 * Time: 11:14
 */

class linechart {

    private $container;
    private $title;
    private $subtitle;
    private $yAxis;
    private $series;


    function __construct($conf) {
        $this->title      = $conf['title'][0];
        $this->subtitle   = $conf['title'][1];
        $this->container   = $conf['container'];
        $this->series      = $conf['series'];
        $this->yAxis      = $conf['y'];
    }


    function render() {


        $series = array();
        $data = array();
        $axis = array();
        foreach ( $this->series as $key=>$row ) {
            $data[$key] = array();
            foreach( $row as $_row ) {
                $axis[] = $_row[0];
                $data[$key][] = $_row[1];
            }
        }
        $axis = "'" . implode("','",$axis) . "'";

        foreach( $data as $key=>$row ) {
            $i = implode(",",$row);
            $series[] = "{name:'{$key}',data:[{$i}]}";
        }
        $series = implode(",",$series);

        $str = "chart = new Highcharts.Chart({
              chart: {
                renderTo: '{$this->container}',
                type: 'bar'
            },
            title: {
                text: 'Grafico de Produtos pedidos ?'
            },
            subtitle: {
                text: 'Fonte: CPD - Centro de Pesquisas DMCard - nº003/catálogo 7789-789 - Ano de 2014'
            },
            xAxis: {

            categories: [{$axis}]

            },
            yAxis: {
                min: 0,
                title: {
                    text: '% de votos',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: '%'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: [{$series}]
        });
      ";
        //Lembra que falei do LiveScript?
        //Header::addLiveScript( $str );
        return $str ;
   }


} 