<?php

defined('JPATH_PLATFORM') or die;

jimport('joomla.form.formfield');

class JFormFieldArtContent extends JFormField
{
    protected $type = 'ArtContent';

    protected function getInput()
    {
        // Initialize field attributes.
        $text   = $this->element['text'] ? $this->element['text'] : '';
        $value  = $this->element['value'] ? $this->element['value'] : '';
        
        // get theme name
        $id     = JRequest::getInt('id');
        // Get a table instance.
        $table  = JTable::getInstance("Style", "TemplatesTable");
        // Attempt to load the row.
        $table->load($id);
        $template = $table->template;
        
        $dataFolder = JURI::root(true).'/templates/'. $template .'/data';
        $document = JFactory::getDocument();
        
        // include js, css files to create modal window
        $pathToModalJs =  JURI::root(true).'/media/system/js/modal.js';
        $document->addScript($pathToModalJs);
        $pathToModalCss = JURI::root(true).'/media/system/css/modal.css';
        $document->addStyleSheet($pathToModalCss);
        
        // include js script - jquery  file
        $pathToJQuery =  JURI::root(true).'/templates/'. $template .'/jquery.js';
        $document->addScript($pathToJQuery);
        
        // include js script - loader file  
        $pathToLoader =  JURI::root(true).'/templates/'. $template .'/data/loader.js';
        $document->addScript($pathToLoader);
        
        // include js script - inline
        $js = 'artHelper = {dataFolder: "' . $dataFolder . '"};';
        $document->addScriptDeclaration($js);
        
        return '<button class="modal" type="submit" name="' .$this->name. '" id="'.$this->id.'">'. JText::_($text) .'</button>
        <div id="log" style="float:left;width:100%;margin-left:150px"></div>';
    }
}
