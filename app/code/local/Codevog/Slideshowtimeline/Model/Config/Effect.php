<?php
/**
 * @version   1.0 12.0.2012
 * @author    Codevog http://www.codevog.com <mail@codevog.com>
 * @copyright Copyright (C) 2010 - 2012 Codevog
 */

class Codevog_Slideshowtimeline_Model_Config_Effect
{
	/**
	 * effects list
	 *
	 * @var string
	 */
	private $effects = "blindX,blindY,blindZ,cover,curtainX,curtainY,fade,fadeZoom,growX,growY,none,scrollUp,scrollDown,scrollLeft,scrollRight,scrollHorz,scrollVert,shuffle,slideX,slideY,toss,turnUp,turnDown,turnLeft,turnRight,uncover,wipe,zoom";

    public function toOptionArray()
    {
	    $fonts = explode(',', $this->effects);
	    $options = array();
	    foreach ($fonts as $f ){
		    $options[] = array(
			    'value' => $f,
			    'label' => $f,
		    );
	    }

        return $options;
    }

}
