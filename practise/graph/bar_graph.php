<!DOCTYPE HTML>
<html>
<head>  
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Top Oil Reserves"
	},
	axisY: {
		title: "Reserves(MMbbl)"
	},
	data: [{        
		type: "column",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "MMbbl = one million barrels",
		dataPoints: [      
			{ y: 30, label: "Venezuela" },
			{ y: 26,  label: "Saudi" },
			{ y: 16,  label: "Canada" },
			{ y: 15,  label: "Iran" },
			{ y: 14,  label: "Iraq" },
			{ y: 14,  label: "Iraq" },
			{ y: 14,  label: "Iraq" },
			{ y: 10, label: "Kuwait" },
			{ y: 97,  label: "UAE" },
			{ y: 80,  label: "Russia" },
            { y: 97,  label: "UAE" },
			{ y: 80,  label: "Russia" }
		]
	}]
});
chart.render();

}
</script>
</head>
<body>
<div id="chartContainer" style="height: 300px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>