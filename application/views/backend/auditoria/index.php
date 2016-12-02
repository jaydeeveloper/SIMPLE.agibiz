<ul class="breadcrumb">
    <li class="active">
        Auditoría
    </li>
</ul>


<?= $this->pagination->create_links() ?>

<table class="table">
    <thead>
        <tr>
            <th><a href="<?= current_url().'?order=fecha&direction='.($direction == 'ASC'? 'DESC':'ASC')?>">Fecha <?= $order == 'fecha' ? $direction == 'ASC' ? '<i class="icon-chevron-down"></i>' : '<i class="icon-chevron-up"></i>'  : '' ?></a></th>
            <th><a href="<?= current_url().'?order=proceso&direction='.($direction == 'ASC'? 'DESC':'ASC')?>">Proceso <?= $order == 'proceso' ? $direction == 'ASC' ? '<i class="icon-chevron-down"></i>' : '<i class="icon-chevron-up"></i>'  : '' ?></a></th>
            <th><a href="<?= current_url().'?order=operacion&direction='.($direction == 'ASC'? 'DESC':'ASC')?>">Operacion <?= $order == 'operacion' ? $direction == 'ASC' ? '<i class="icon-chevron-down"></i>' : '<i class="icon-chevron-up"></i>'  : '' ?></a></th>
            <th><a href="<?= current_url().'?order=usuario&direction='.($direction == 'ASC'? 'DESC':'ASC')?>">Usuario <?= $order == 'usuario' ? $direction == 'ASC' ? '<i class="icon-chevron-down"></i>' : '<i class="icon-chevron-up"></i>'  : '' ?></a></th>
            <th>Motivo</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($registros as $r): ?>
        <tr>
            <td><?=$r->fecha?></td>
            <td><?=$r->proceso?></td>
            <td><?=$r->operacion?></td>
            <td><?=htmlspecialchars($r->usuario)?></td>
            <td><?=$r->motivo?></td>
            <td width="10%" style="text-align: right;"><a href="<?= site_url('backend/auditoria/ver_detalles/'.$r->id)?>" class="btn btn-primary"><i class="icon-white icon-eye-open"></i> Ver detalles</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->pagination->create_links() ?>







