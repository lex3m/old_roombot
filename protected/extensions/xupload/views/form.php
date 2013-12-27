<!-- The file upload form used as target for the file upload widget -->
<?php if ($this->showForm) echo CHtml::beginForm($this -> url, 'post', $this -> htmlOptions);?>
<div class="row fileupload-buttonbar">
	<div class="span7">
		<!-- The fileinput-button span is used to style the file input field as button -->
		<span class="btn btn-success fileinput-button" style="background: none repeat scroll 0 0 #FFFFFF;
border: 2px solid #002980;
border-radius: 5px;
color: #002980;
display: inline-block;
font-size: 14px;
font-weight: bold;
margin-right: 20px;
padding: 2px 15px 3px;">
            <i class="icon-plus icon-white"></i>
            <span><?php echo $this->t('1#Add files|0#Choose file', $this->multiple); ?></span>
			<?php
            if ($this -> hasModel()) :
                echo CHtml::activeFileField($this -> model, $this -> attribute, $htmlOptions) . "\n";
            else :
                echo CHtml::fileField($name, $this -> value, $htmlOptions) . "\n";
            endif;
            ?>
		</span>
	</div>
</div>
<!-- The loading indicator is shown during image processing -->
<div class="fileupload-loading"></div>
<br>
<!-- The table listing the files available for upload/download -->
<table class="table table-striped">
	<tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody>
</table>
<?php if ($this->multiple) { ?>
<div class="row fileupload-buttonbar" style='background: url("/images/knopka_srednyaya_left2.png") no-repeat scroll left 0 transparent;
                                            height: 36px;
                                            margin-top: 25px;
                                            padding-left: 22px;'>
    <div class="span7">
        <button type="submit" class="btn btn-primary start" style='background: url("/images/knopka_srednyaya_right2.png") no-repeat scroll right 0 transparent;
                                                            border: medium none;
                                                            display: inline-block;
                                                            font-size: 16px;
                                                            font-weight: bold;
                                                            color: #002980;
                                                            cursor: pointer;
                                                            height: 36px;
                                                            margin: 0;
                                                            padding-right: 23px;
                                                            text-transform: uppercase;'>
            <i class="icon-upload icon-white"></i>
            <span><?php echo $this->t('Add photos');?></span>
        </button>
       <!-- <button type="reset" class="btn btn-warning cancel" style='
                                                            border: medium none;
                                                            display: inline-block;
                                                            font-size: 14px;
                                                            font-weight: bold;
                                                            color: #002980;
                                                            cursor: pointer;
                                                            height: 36px;
                                                            margin: 0;
                                                            padding-right: 23px;
                                                            text-transform: uppercase;'>
            <i class="icon-ban-circle icon-white"></i>
            <span><?php /*echo $this->t('Cancel upload');*/?></span>
        </button>-->
        <!--<button type="button" class="btn btn-danger delete">
                <i class="icon-trash icon-white"></i>
                <span><?php /*echo $this->t('Delete');*/?></span>
            </button>-->
        <!--		<input type="checkbox" class="toggle">-->
    </div>
    <div class='span5'>
        <!-- The global progress bar -->
        <div class="progress progress-success progress-striped active fade">
            <div class="bar" style="width:0%;"></div>
        </div>
    </div>
<?php } ?>
</div>
<div class="row">
    <div class="upload-timer">

    </div>
</div>
<?php if ($this->showForm) echo CHtml::endForm();?>
