<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Grouper Class
 *
 * @package     ExpressionEngine
 * @category        Plugin
 * @author      Matt Nichoslon
 * @copyright       Copyright (c) 2012, Matt Nichoslon
 * @link        http://archivestudio.co.uk
 */

$plugin_info = array(
  'pi_name'         => 'Grouper',
  'pi_version'      => '1.0',
  'pi_author'       => 'Matt Nicholson',
  'pi_author_url'   => 'http://archivestudio.co.uk/',
  'pi_description'  => 'Allows you to create croups within entry feeds based on a count',
  'pi_usage'        => Grouper::usage()
);

class Grouper
{

    public $return_data = "";

    // --------------------------------------------------------------------

    /**
     * Grouper
     *
     * Wrap :nth entries with specific markup
     *
     * @access  public
     * @return  string
     */
    public function __construct()
    {
        $this->EE =& get_instance();

       
    }
    
    public function start(){
    
    	$count = $this->EE->TMPL->fetch_param('count');
    	$group_count = $this->EE->TMPL->fetch_param('groupby');
    	$total = $this->EE->TMPL->fetch_param('total');
    	
    	$data['last_class'] = '';
    	
    	if(($count - 1) % $group_count == 0):
    		$groups = ceil($total / $group_count);
    		if($count == $groups) $data['last_class'] = $this->EE->TMPL->fetch_param('last_class');
    	endif;
    	
		// If group count is 1, it means do it once, not do it every time
		if($group_count == 1):
			return ($count == 1) ? $this->EE->TMPL->tagdata :"";
		else:
			return (($count - 1) % $group_count == 0) ? $this->EE->TMPL->parse_variables($this->EE->TMPL->tagdata, array($data)) :"";
		endif;
    }
    
    public function end(){
    	$count = $this->EE->TMPL->fetch_param('count');
    	$group_count = $this->EE->TMPL->fetch_param('groupby');
    	$total = $this->EE->TMPL->fetch_param('total');
    	
		// If group count is 1, it means last not every
		if($group_count == 1):
			
			return ($count == $total) ? $this->EE->TMPL->tagdata : "";
			
		endif;
		return ($count % $group_count == 0 || $count == $total) ? $this->EE->TMPL->tagdata :"";
    }

    // --------------------------------------------------------------------

    /**
     * Usage
     *
     * This function describes how the plugin is used.
     *
     * @access  public
     * @return  string
     */
    public static function usage()
    {
        ob_start();  ?>

The grouper allows you to output additional markup based on the count of the entries feed. You can open a <div> in one portion of the feed and close it later as necessary, creating a 'group'. Useful for outputting grids of images that require addition markup to define rows, or can be used to determine an :nth iteration

    {exp:grouper}

Group start

{exp:grouper:start groupby="5" count="{count}"}
{exp:grouper:end groupby="5" count="{count}" total="{total_results}"}



    <?php
        $buffer = ob_get_contents();
        ob_end_clean();

        return $buffer;
    }
    // END
}
/* End of file pi.memberlist.php */
/* Location: ./system/expressionengine/third_party/memberlist/pi.memberlist.php */