<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<?php 
include "conn_nz.php";

$chart_data = array();
$data = getQuery("select title,count(*)jml from nm_table where title is not null  group by 1 order by 2 desc;");
while($row = odbc_fetch_array($data)){
	$chart_data['title'][] = $row['TITLE'];
	$chart_data['jml'][] = $row['JML'];
}
//var_dump($chart_data);

$witel = getDistinct('witel');
$reg = getDistinct('reg');
$web = getDistinct('title');
$datel = getDistinct('datel');
?>
<div class="row">
  <div class="col-sm-6">Regional : <select id="reg"><option value=''>All</option><?php foreach($reg as $w) echo "<option value='$w'>$w</option>";?></select></div>
  <div class="col-sm-6">Witel : <select id="witel"><option value=''>All</option><?php foreach($witel as $w) echo "<option value='$w'>$w</option>";?></select></div>
</div>

<form class="form-inline">
	<div class="row">
		<div class="col-sm-6">Kategori Arpu : <br/>
			<?php foreach($datel as $w) echo "<input type='checkbox' class='datel' value='$w'> $w <br/>" ?>
		</div>
		<div class="col-sm-6">Web Interest : <br/>
				<?php foreach($web as $w) echo "<input type='checkbox' class='web_interest_1' value='$w'> $w <br/>" ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">QoS</div>
		<div class="col-sm-6">Num Device</div>
	</div>
</form>
<div class="row">
	<div class="col-sm-12"><div id="jml" class='alert alert-success'>0</div></div>
</div>


<script>
$(document).ready(function() {
	$('input[type="checkbox"]').on('click',function(){
        var group = $(this).attr("class");
        var checked = [];
        $('input[type="checkbox"].' + group + ':checked').each(function(){
            checked.push($(this).val());
        });
        requestData(group,checked);
    });  
	$('select').on('change',function(){
		requestData($(this).attr('id'),$(this).val());
	}); 
});

function requestData(t,v) {
	$.ajax({
		url: 'json.php',
		type: "POST",
		dataType: "json",
		data : {type :t,val:v},
		success: function(data) {
			$("#jml").text(data.jml);
			$.each(data.filter, function(k,v){
				$("input[value='"+v+"']").attr('checked', true);
			});
		},
		cache: false
	});
}
</script>