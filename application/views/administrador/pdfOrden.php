<?php $this->load->view("head") ?> 
<style>
	.demo {
		border:1px solid #C0C0C0;
		border-collapse:collapse;
        padding:5px;
        margin-top: 50px;
	}
	.demo th {
		border:1px solid #C0C0C0;
		padding:5px;
        background:#F0F0F0;
        text-align: center;
	}
	.demo td {
		border:1px solid #C0C0C0;
        padding:5px;
        font-size: 14px;
        text-align: center;
    }
    .fondoGris{
        background-color: gainsboro;
        border: 2px solid black !important;
    }
</style>
<table class="demo">
	<thead>
	<tr>
		<th colspan="13">ORDEN DE COMPRA</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td colspan="2" class="fondoGris">NOMBRE DE PROVEEDOR</td>
		<td><?= $proveedor?></td>
		<td></td>
        <td colspan="2" class="fondoGris">FOLIO DE PROVEEDOR</td>
        <td><?= $folioProveedor ?></td>
		<td></td>
		<td class="fondoGris">NO. ORDEN</td>
        <td><?= $numeroOrden?></td>
        <td></td>
        <td></td>
		<td></td>
    </tr>
    <tr>
    <td colspan="2" class="fondoGris">FECHA</td>
		<td><?= $fecha?></td>
		<td></td>
        <td colspan="2" class="fondoGris">AREA SOLICITANTE:</td>
        <td><?= $area?></td>
		<td></td>
		<td class="fondoGris">NO. REQUISICIÓN</td>
        <td><?= $numeroRequisicion?></td>
        <td></td>
        <td></td>
		<td></td>
	</tr><tr>
    <td colspan="2" class="fondoGris">RFC</td>
		<td><?= $rfc?></td>
		<td></td>
        <td colspan="2" class="fondoGris">CLAVE DE AREA</td>
        <td><?= $claveArea?></td>
		<td></td>
		<td class="fondoGris">UNIDAD</td>
        <td><?= $unidadOrden?></td>
        <td></td>
        <td></td>
		<td></td>
	</tr><tr>
		<td></td>
		<td></td>
		<td></td>
        <td></td>
        <td></td>
		<td></td>
		<td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
		<td></td>
		<td></td>
	</tr><tr>
		<td>NO</td>
		<td>PARTIDA</td>
        <td>CANTIDAD</td>
        <td>UNIDAD</td>
		<td>DESCRIPCION</td>
		<td>P/UNITARIO</td>
        <td>R. FEDERAL</td>
        <td></td>
        <td>R. ESTATAL</td>
        <td>R. FISCAL</td>
        <td>IMPORTE</td>
        <td colspan="2">IVA</td>
	</tr><tr>
		<td><?= $idOrden?></td>
		<td><?= $partida?></td>
		<td><?= number_format($cantidad,2,".",",")?></td>
        <td><?= $unidad?></td>
        <td><?= $descripcion?></td>
		<td>$<?= number_format($precioUnitario,2,".",",")?></td>
		<td><?= $rFederal?></td>
        <td></td>
        <td><?= $rEstatal?></td>
		<td><?= $rFiscal?></td>
		<td>$<?= number_format($importe,2,".",",")?></td>
        <td colspan="2">$<?= number_format($iva,2,".",",")?></td>
	</tr><tr>
		<td colspan="2" class="fondoGris"> NOTA</td>
		<td colspan="11" class="fondoGris"><?= $nota?></td>
	</tr><tr>
		<td colspan="13"></td>
	</tr><tr>
		<td colspan="3">REALIZA</td>
		<td></td>
		<td colspan="4">VO.BO</td>
        <td></td>
        <td colspan="4">AUTORIZA</td>
	</tr><tr>
    <td colspan="3">L.T. EDUARDO MORAN GODINEZ</td>
		<td></td>
		<td colspan="4">MTRO. JOSE ALFREDO MORALES ZUASO</td>
        <td></td>
        <td colspan="4">MTRO. FERNANDO GOMEZ CARRASCO</td>
	</tr><tr>
    <td colspan="3">JEFE DE ADQUISICIONES</td>
		<td></td>
		<td colspan="4">ENG. DE HACIENDA MUNICIPAL</td>
        <td></td>
        <td colspan="4">PRESIDENTE MUNICIPAL</td>
	</tr><tr>
		<td colspan="13"></td>
	</tr><tr>
		<td colspan="13">NOMBRES Y CARGOS AUTOMATICOS</td>
	</tr><tr>
		<td></td>
		<td></td>
		<td></td>
        <td></td>
        <td></td>
		<td></td>
		<td></td>
        <td></td>
        <td></td>
		<td></td>
		<td></td>
        <td></td>
        <td></td>
	</tr><tr>
    <td></td>
		<td></td>
		<td></td>
        <td></td>
        <td></td>
		<td></td>
		<td></td>
        <td></td>
        <td></td>
		<td></td>
		<td></td>
        <td></td>
        <td></td>
	</tr>
	
	</tbody>
</table>