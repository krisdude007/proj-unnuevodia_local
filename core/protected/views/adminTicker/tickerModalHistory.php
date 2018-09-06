<div>
    <table class="dtStyle" width="100%" style="border-collapse: collapse;">
        <col>
        <col width='100%'>
        <col>
        <tr><th style="padding:2px;border: 1px solid #000;">Date</th><th style="padding:2px;border: 1px solid #000;">Status</th><th style="padding:2px;border: 1px solid #000;">Producer</th></tr>
        <?php foreach ($parsedAudits as $parsedAudit): ?>
            <tr>
                <td style="padding:1px 3px;border: 1px solid #000;"><?php echo(str_replace(" ", "&nbsp;", date("m/d/Y h:i:s a", strtotime($parsedAudit['created_on'])))); ?></td>
                <td style="padding:1px 3px;border: 1px solid #000;">
                    <div style="position: relative;">&nbsp;
                        <div style="position: absolute;top:0px;width: 100%;overflow: hidden;white-space: nowrap;">
                            <a title="<?php echo($parsedAudit['status']); ?>" style="cursor:pointer;"><?php echo($parsedAudit['status']); ?></a>
                        </div>
                    </div>
                </td>
                <td style="padding:1px 3px;border: 1px solid #000;"><?php echo(str_replace(" ", "&nbsp;", $parsedAudit['username'])); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>