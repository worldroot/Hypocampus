!function(){new Chartist.Line("#gradient-line-chart1",{labels:["Mon","Tue","Wed","Thu","Fri","Sat","Sun"],series:[[125,200,125,225,175,275,220],[175,275,165,280,120,226,150]]},{low:100,fullWidth:!0,onlyInteger:!0,axisY:{low:0,scaleMinSpace:50},axisX:{showGrid:!1},lineSmooth:Chartist.Interpolation.simple({divisor:2})}).on("created",function(e){var t=e.svg.querySelector("defs")||e.svg.elem("defs");return t.elem("linearGradient",{id:"lineLinear1",x1:0,y1:0,x2:1,y2:0}).elem("stop",{offset:"0%","stop-color":"rgba(168,120,244,0.1)"}).parent().elem("stop",{offset:"10%","stop-color":"rgba(168,120,244,1)"}).parent().elem("stop",{offset:"80%","stop-color":"rgba(255,108,147, 1)"}).parent().elem("stop",{offset:"98%","stop-color":"rgba(255,108,147, 0.1)"}),t.elem("linearGradient",{id:"lineLinear2",x1:0,y1:0,x2:1,y2:0}).elem("stop",{offset:"0%","stop-color":"rgba(0,230,175,0.1)"}).parent().elem("stop",{offset:"10%","stop-color":"rgba(0,230,175,1)"}).parent().elem("stop",{offset:"80%","stop-color":"rgba(255,161,69, 1)"}).parent().elem("stop",{offset:"98%","stop-color":"rgba(255,161,69, 0.1)"}),t}).on("draw",function(e){if("point"===e.type){var t=new Chartist.Svg("circle",{cx:e.x,cy:e.y,"ct:value":e.y,r:10,class:225===e.value.y?"ct-point ct-point-circle":"ct-point ct-point-circle-transperent"});e.element.replace(t)}"line"===e.type&&e.element.animate({d:{begin:1e3,dur:1e3,from:e.path.clone().scale(1,0).translate(0,e.chartRect.height()).stringify(),to:e.path.clone().stringify(),easing:Chartist.Svg.Easing.easeOutQuint}})});var e={axisY:{low:0,high:20,showGrid:!1,showLabel:!1,offset:0},axisX:{showLabel:!0,showGrid:!1},fullWidth:!0},t={axisX:{showLabel:!1,showGrid:!1},axisY:{showLabel:!1,showGrid:!1,low:0,high:20,offset:0},lineSmooth:Chartist.Interpolation.simple({divisor:2}),fullWidth:!0};new Chartist.Bar("#progress-stats-bar-chart",{labels:["Mon","Tue","Wex","Thu","Fri","Sat","Sun"],series:[[18,20,14,18,20,15,18]]},e).on("draw",function(e){"bar"===e.type&&e.element.attr({style:"stroke-width: 25px"})}),new Chartist.Line("#progress-stats-line-chart",{series:[[10,15,7,12,3,16]]},t).on("created",function(e){var t=e.svg.querySelector("defs")||e.svg.elem("defs");return t.elem("linearGradient",{id:"lineLinearStats",x1:0,y1:0,x2:1,y2:0}).elem("stop",{offset:"0%","stop-color":"rgba(252,98,107,0.1)"}).parent().elem("stop",{offset:"10%","stop-color":"rgba(252,98,107,1)"}).parent().elem("stop",{offset:"80%","stop-color":"rgba(252,98,107, 1)"}).parent().elem("stop",{offset:"98%","stop-color":"rgba(252,98,107, 0.1)"}),t}).on("draw",function(e){if("point"===e.type){var t=new Chartist.Svg("circle",{cx:e.x,cy:e.y,"ct:value":e.y,r:5,class:15===e.value.y?"ct-point ct-point-circle":"ct-point ct-point-circle-transperent"});e.element.replace(t)}}),new Chartist.Bar("#progress-stats-bar-chart1",{labels:["Mon","Tue","Wex","Thu","Fri","Sat","Sun"],series:[[20,17,14,18,20,15,18]]},e).on("draw",function(e){"bar"===e.type&&e.element.attr({style:"stroke-width: 25px"})}),new Chartist.Line("#progress-stats-line-chart1",{series:[[3,12,7,15,7,13]]},t).on("created",function(e){var t=e.svg.querySelector("defs")||e.svg.elem("defs");return t.elem("linearGradient",{id:"lineLinearStats1",x1:0,y1:0,x2:1,y2:0}).elem("stop",{offset:"0%","stop-color":"rgba(40,175,208,0.1)"}).parent().elem("stop",{offset:"10%","stop-color":"rgba(40,175,208,1)"}).parent().elem("stop",{offset:"80%","stop-color":"rgba(40,175,208, 1)"}).parent().elem("stop",{offset:"98%","stop-color":"rgba(40,175,208, 0.1)"}),t}).on("draw",function(e){if("point"===e.type){var t=new Chartist.Svg("circle",{cx:e.x,cy:e.y,"ct:value":e.y,r:5,class:15===e.value.y?"ct-point ct-point-circle":"ct-point ct-point-circle-transperent"});e.element.replace(t)}}),new Chartist.Bar("#progress-stats-bar-chart2",{labels:["Mon","Tue","Wex","Thu","Fri","Sat","Sun"],series:[[20,17,14,18,15,20,18]]},e).on("draw",function(e){"bar"===e.type&&e.element.attr({style:"stroke-width: 25px"})}),new Chartist.Line("#progress-stats-line-chart2",{series:[[16,3,10,5,15,10]]},t).on("created",function(e){var t=e.svg.querySelector("defs")||e.svg.elem("defs");return t.elem("linearGradient",{id:"lineLinearStats2",x1:0,y1:0,x2:1,y2:0}).elem("stop",{offset:"0%","stop-color":"rgba(253,185,1,0.1)"}).parent().elem("stop",{offset:"10%","stop-color":"rgba(253,185,1,1)"}).parent().elem("stop",{offset:"80%","stop-color":"rgba(253,185,1, 1)"}).parent().elem("stop",{offset:"98%","stop-color":"rgba(253,185,1, 0.1)"}),t}).on("draw",function(e){if("point"===e.type){var t=new Chartist.Svg("circle",{cx:e.x,cy:e.y,"ct:value":e.y,r:5,class:15===e.value.y?"ct-point ct-point-circle":"ct-point ct-point-circle-transperent"});e.element.replace(t)}})}((window,document,jQuery));