<?php
    for ($i = 0; $i < count($this->items); $i++) {
        $item = &$this->items[$i];
        if (!empty($item->event)){
            $item->event = new stdClass();

            $dispatcher = JDispatcher::getInstance();

            $item->introtext = JHtml::_('content.prepare', $item->introtext, '', 'com_content.category');

            $results = $dispatcher->trigger('onContentAfterTitle', array('com_content.article', &$item, &$item->params, 0));
            $item->event->afterDisplayTitle = trim(implode("\n", $results));

            $results = $dispatcher->trigger('onContentBeforeDisplay', array('com_content.article', &$item, &$item->params, 0));
            $item->event->beforeDisplayContent = trim(implode("\n", $results));

            $results = $dispatcher->trigger('onContentAfterDisplay', array('com_content.article', &$item, &$item->params, 0));
            $item->event->afterDisplayContent = trim(implode("\n", $results));
        }
    }
?>
<?php
if (isset($this->items[0])){
   $this->item = &$this->items[0];
   echo $this->loadTemplate('item');
}
?>
<?php
if (isset($this->items[1])){
   $this->item = &$this->items[1];
   echo $this->loadTemplate('item');
}
?>
