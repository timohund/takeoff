<div style="background-color: #fff; font-size: 12px; font-color: #000; font-family: Arial">

    <div style="margin 5px; width: 180px; float: left; background-color: #fff;">
        <span>General Information: </span>
        <table style="border: solid 1px; border-collapse: collapse; width: 160px;">
			<tr>
				<td>Overall Memory Usage: </td>
				<td><?php echo $this->toMb($this->overallUsage); ?> MB</td>
			</tr>
			<tr>
				<td>Peak Memory Usage: </td>
				<td><?php echo $this->toMb($this->peakUsage); ?> MB</td>
			</tr>
			<tr>
				<td>Collected Profiler Samples: </td>
                <td><?php echo $this->sampleCount; ?></td>
			</tr>
            <tr>
                <td>Time spend: </td>
                <td><?php echo $this->timeSpend; ?> ms</td>
            </tr>

		</table>
	</div>
    <div style="margin 5px; width: 450px; float: left; background-color: #fff;">
        <span>TOP 10 Memory Users: </span>
        <table style="border: solid 1px; border-collapse: collapse; width: 400px;">
			<tr>
				<td style="border: solid 1px; padding: 5px;">Mem</td>
                <td style="border: solid 1px; padding: 5px;">Code</td>
				<td style="border: solid 1px; padding: 5px;">Sample Costs</td>
			</tr>
			<?php $i = 0; ?>
			<?php foreach ($this->memoryItems as $memoryItem): ?>
            <tr>
				<?php /** @var $memoryItem Tx_Takeoff_Domain_ProfileSample */?>
                <td style="border: solid 1px; padding: 5px;"><?php echo $this->toMb($memoryItem->getMemoryUsage()); ?> MB</td>
                <td style="border: solid 1px; padding: 5px;"><?php echo $memoryItem->getClosestStackItem(); ?></td>
                <td style="border: solid 1px; padding: 5px;"><?php echo $memoryItem->getCosts(); ?></td>
            </tr>
			<?php $i++; ?>
			<?php if ($i == 20) {
				break;
			} ?>
			<?php endforeach ?>
        </table>

    </div>

    <div style="margin 5px; width: 450px; float: left; background-color: #fff;">
        <span>TOP 10 CPU Users: </span>
        <table style="border: solid 1px; border-collapse: collapse; width: 400px;">
            <tr>
                <td style="border: solid 1px; padding: 5px;">Mem</td>
                <td style="border: solid 1px; padding: 5px;">Code</td>
                <td style="border: solid 1px; padding: 5px;">Sample Costs</td>
            </tr>

			<?php $i = 0; ?>
			<?php foreach ($this->timeItems as $timeItem): ?>
            <tr>
				<?php /** @var $memoryItem Tx_Takeoff_Domain_ProfileSample */?>
                <td style="border: solid 1px; padding: 5px;"><?php echo $this->toMb($timeItem->getMemoryUsage()); ?> MB</td>
                <td style="border: solid 1px; padding: 5px;"><?php echo $timeItem->getClosestStackItem(); ?></td>
                <td style="border: solid 1px; padding: 5px;"><?php echo $timeItem->getCosts(); ?></td>
            </tr>
			<?php $i++ ?>
			<?php if ($i == 20) {
				break;
			} ?>
			<?php endforeach ?>
        </table>

    </div>

</div>
