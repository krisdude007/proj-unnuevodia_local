<div class='as-table'>
    <div class="homeTop">
        <b style="font-weight: 300;">Interactuando con</b> Un Nuevo Día
    </div>
    <div class="as-table-row" style="background-color: #d8512b;text-align: center;">
        <div class="as-table-cell">
            <br/>
            <h1>¡Gracias!</h1>
            <div>
                <p>
                    ¡Tu video ha sido enviado para su aprobación!.
                </p>
            </div>
            <br/>
                <button class="btn btn-inverse" style="width:50%;background-color: transparent !important;border-color: white !important; min-height: 45px !important;" onclick="window.location = '<?php echo Yii::app()->createUrl('/question/index'); ?>'">
                Subir Otra
                </button>
            <br/>
            <br/>
            <button class="btn btn-inverse" style="width:50%;background-color: transparent !important;border-color: white !important; min-height: 45px !important;" onclick="window.location = '<?php echo Yii::app()->createUrl('site/index'); ?>'">
                Pàgina Principal
            </button>
            <br/>
            <br/>
            <button class="btn btn-inverse" style="width:50%;background-color: transparent !important;border-color: white !important; min-height: 45px !important;" onclick="window.location = '<?php echo Yii::app()->createUrl('videos/recent'); ?>'">
                Ver Vídeos
            </button>
        </div>
    </div>
</div>