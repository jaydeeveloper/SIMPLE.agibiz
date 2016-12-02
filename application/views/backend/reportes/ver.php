<?php
$col_size = count($reporte_tabla[0]);
$row_size = count($reporte_tabla);

?>

<script type="text/javascript">

$(document).ready(function(){

	$(":input").change(function(event){

		$("#filtroForm").submit();

	});
	
	
});

function toggleFiltro() {
    $("#filtro").slideToggle();

	var icon =$("#toggleFiltroBtn").find("i");
	if (icon.hasClass("icon-arrow-down")){
		icon.removeClass("icon-arrow-down");
		icon.addClass("icon-arrow-up");
	} else {
		icon.removeClass("icon-arrow-up");
		icon.addClass("icon-arrow-down");
	}
	
	
    return false;
}

</script>
<ul class="breadcrumb">
	<li><a href="<?= site_url('backend/reportes') ?>">Gestion</a></li>
	<span class="divider">/</span>
	<li><a
		href="<?= site_url('backend/reportes/listar/'.$reporte->Proceso->id) ?>"><?=$reporte->Proceso->nombre?></a></li>
	<span class="divider">/</span>
	<li class="active"><?= $reporte->nombre ?></li>
</ul>

<div class='row-fluid'>
	<div class='pull-right'></div>
</div>
<div class='row-fluid'>
	<form class='form-horizontal' id="filtroForm">
		<input type='hidden' name='busqueda_avanzada' value='1' />
		<div id="filtro" class='well' style='display: <?= $filtro?'block':'none'?>;' >
			<div class="span12">
				<div class='row'>
					<div class="span4">
						<div class='control-group'>
							<div class='controls'>
								<input name="query" value="<?= $query ?>" type="text"
									class="search-query" placeholder="Término a buscar" />
							</div>
						</div>
					</div>
					<div class="span4">
						<div class='control-group'>
							<label class='control-label'>Estado del trámite</label>
							<div class='controls'>
								<label class='radio'><input type='radio' name='pendiente'
									value='-1' <?= $pendiente == -1 ? 'checked' : '' ?>> Cualquiera</label>
								<label class='radio'><input type='radio' name='pendiente'
									value='1' <?= $pendiente == 1 ? 'checked' : '' ?>> En curso</label>
								<label class='radio'><input type='radio' name='pendiente'
									value='0' <?= $pendiente == 0 ? 'checked' : '' ?>> Completado</label>
							</div>
						</div>
					</div>
					<div class="span4">
						<div class='control-group'>
							<label class='control-label'>Fecha de creación</label>
							<div class='controls'>
								<input type='text' name='created_at_desde' placeholder='Desde'
									class='datepicker input-small' value='<?= $created_at_desde ?>' />
								<input type='text' name='created_at_hasta' placeholder='Hasta'
									class='datepicker input-small' value='<?= $created_at_hasta ?>' />


							</div>
						</div>
					</div>

				</div>
			</div>
			<div class="row">
				<div class="pull-right">
					<div class="span1">
						<button type="submit" class="btn btn-primary">Filtrar</button>
					</div>
				</div>
			</div>

		</div>

		<div class="row">
			<div class="span12">
				<div class="pull-left">
					<dl class="dl-horizontal">
						<dt>Duración promedio</dt>
						<dd> <?=$promedio_tramite?abs($promedio_tramite) . ' días':'No hay tramites finalizados'?></dd>
						<dt>Cantidad de trámites</dt>
						<dd> <?=$tramites_completos + $tramites_pendientes?></dd>
						<dt>Completos</dt>
						<dd> <?=$tramites_completos?></dd>
						<dt>En curso</dt>
						<dd><?=$tramites_pendientes?></dd>
						<dt>En curso vencidos</dt>
						<dd><?=$tramites_vencidos?></dd>                                                
					</dl>
					</dl>
				</div>
				<div class="pull-right">
					<div class="col-md-2">
						<a id="toggleFiltroBtn" class="btn btn-default" href='#'
							onclick='toggleFiltro()'><i class="icon icon-arrow-down"></i>Filtro</a>
						<button type="submit" name="formato" value="xls"
							class="btn btn-primary">
							<i class="icon-file icon-white"></i> XLS
						</button>
						<button type="submit" name="formato" value="pdf"
							class="btn btn-primary">
							<i class="icon-file icon-white"></i>PDF
						</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<table class="table table-striped">
	<thead>

		<tr>
		<?php for($col=0;$col<$col_size;$col++):?>
		<th><?php echo $reporte_tabla[0][$col];?></th>
		<?php endfor;?>
		</tr>

	</thead>

	<?php for($row=1;$row<$row_size;$row++):?>
		<tr>
		<?php for($col = 0;$col<$col_size;$col++):?>
			<td><?php echo $reporte_tabla[$row][$col];?></td>
		<?php endfor;?>
		</tr>
	<?php endfor;?>
</table>

<?= $this->pagination->create_links()?>