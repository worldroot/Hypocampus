$(window).on("load",function(){var a=$("#simple-doughnut-chart");new Chart(a,{type:"doughnut",options:{responsive:!0,maintainAspectRatio:!1,responsiveAnimationDuration:500},data:{labels:["January","February","March","April","May"],datasets:[{label:"My First dataset",data:[65,35,24,45,85],backgroundColor:["#666EE8","#28D094","#FF4961","#1E9FF2","#FF9149"]}]}})});