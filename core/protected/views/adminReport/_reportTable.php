<table <?php echo isset($id) ? $id : ""; ?> cellspacing="0" cellpadding="0" class="fab-a-blue <?php if(isset($classes)) echo $classes; ?>">
    <tbody>
        <?php
        $i = 0;
        foreach ($rows as $key => $value) {
            $parameters = array('label' => $key, 'value' => $value);
            if (isset($headerRow) && $i == 0)
                $parameters['headerRow'] = true;
            $this->renderPartial('_reportRow', Array('parameters' => $parameters, 
            	'link' => isset($links[$i])? $links[$i]: '', 
            	'startDate' => isset($startDate)? $startDate : false, 
            	'endDate' => isset($endDate) ?$endDate : false
            ));
            $i++;
        }
        ?>
    </tbody>
</table>