<?=$this->load->view(branded_view('cp/header'), array('head_files' => '<script type="text/javascript" src="' . branded_include('js/report.invoice.js') . '"></script>'));?>
<h1>Invoice #<?=$invoice['id'];?> (<?=$invoice['date'];?>)</h1>

<? if ($invoice['refunded'] == TRUE) { ?>
	<div class="warning">
		<span>This charge was refunded <?=$invoice['refund_date'];?>.</span>
	</div>
<? } ?>

<div>
	<div style="float: left; width: 45%">
		<h3>Billing Address</h3>
		<?=format_street_address($invoice['billing_address']);?>
	</div>
	
	<? if (!empty($order) and isset($order['shipping']) and !empty($order['shipping'])) { ?>
	<div style="float: left; width: 45%">
		<h3>Shipping Address</h3>
		<?=format_street_address($order['shipping']);?>
	</div>
	<? } ?>
	<div style="clear:both"></div>
</div>

<table class="dataset spaced" cellspacing="0" cellspacing="0">
	<thead>
		<tr>
			<td style="width: 45%">Item</td>
			<td style="width: 20%">Quantity</td>
			<td style="width: 15%">Shipped</td>
			<td style="width: 20%">Subtotal</td>
		</tr>
	</thead>
	<tbody>
		<? foreach ($invoice_lines as $line) { ?>
			<tr <? if (isset($line['shipped']) and empty($line['shipped'])) { ?>class="highlight"<? } ?>>
				<td><?=$line['line'];?></td>
				<td><?=$line['quantity'];?></td>
				<td>
					<? if (!isset($line['shipped'])) { ?>
						n/a
					<? } else { ?>
						<input type="radio" class="shipped_no" rel="<?=$line['order_products_id'];?>" name="shipped_<?=$line['order_products_id'];?>" <? if ($line['shipped'] == FALSE) { ?>checked="checked"<? } ?>value="0" /> No  <input type="radio" class="shipped_yes" rel="<?=$line['order_products_id'];?>" <? if ($line['shipped'] == TRUE) { ?>checked="checked"<? } ?> name="shipped_<?=$line['order_products_id'];?>" value="1" /> Yes
					<? } ?>
				</td>
				<td><?=setting('currency_symbol');?><?=$line['sub_total'];?></td>
			</tr>
		<? } ?>
		<tr>
			<td colspan="3" style="text-align: right">Tax: <?=$invoice['tax_name'];?> (<?=$invoice['tax_rate'];?>%)</td>
			<td><?=setting('currency_symbol');?><?=$invoice['tax_paid'];?></td>
		</tr>
	</tbody>
</table>

<div class="total">
	<h2>Invoice Total</h2>
	<p><?=$this->config->item('currency_symbol');?><?=$invoice['amount'];?></p>
</div>
<?=$this->load->view(branded_view('cp/footer'));?>