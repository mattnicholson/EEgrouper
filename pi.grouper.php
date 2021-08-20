<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Grouper Class
 *
 * @package     ExpressionEngine
 * @category        Plugin
 * @author      Matt Nichoslon
 * @copyright       Copyright (c) 2012, Matt Nichoslon
 * @link        https://github.com/mattnicholson/EEgrouper
 */

$plugin_info = array(
  'pi_name'         => 'Grouper',
  'pi_version'      => '2.0',
  'pi_author'       => 'Matt Nicholson',
  'pi_author_url'   => 'https://github.com/mattnicholson/EEgrouper',
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

       
    }
    
    public function start(){
    
    	$count = ee()->TMPL->fetch_param('count');
    	$group_count = ee()->TMPL->fetch_param('groupby');
    	$total = ee()->TMPL->fetch_param('total');
    	
    	$data['last_class'] = '';
    	
    	if(($count - 1) % $group_count == 0):
    		$groups = ceil($total / $group_count);
    		if($count == $groups) $data['last_class'] = ee()->TMPL->fetch_param('last_class');
    	endif;
    	
		// If group count is 1, it means do it once, not do it every time
		if($group_count == 1):
			return ($count == 1) ? ee()->TMPL->tagdata :"";
		else:
			return (($count - 1) % $group_count == 0) ? ee()->TMPL->parse_variables(ee()->TMPL->tagdata, array($data)) :"";
		endif;
    }
    
    public function end(){
    	$count = ee()->TMPL->fetch_param('count');
    	$group_count = ee()->TMPL->fetch_param('groupby');
    	$total = ee()->TMPL->fetch_param('total');
    	
		// If group count is 1, it means last not every
		if($group_count == 1):
			
			return ($count == $total) ? ee()->TMPL->tagdata : "";
			
		endif;
		return ($count % $group_count == 0 || $count == $total) ? ee()->TMPL->tagdata :"";
    }
    
    public function nth(){
    	$count = ee()->TMPL->fetch_param('count');
    	$group_count = ee()->TMPL->fetch_param('n');
    	
    	return ($count % $group_count == 0) ? ee()->TMPL->tagdata :"";
    	
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

Grouper start, end and nth

{exp:grouper:start groupby="5" count="{count}" total="{total_results}"}
{exp:grouper:end groupby="5" count="{count}" total="{total_results}"}
{exp:grouper:nth n="5" count="{count}"}



    <?php
        $buffer = ob_get_contents();
        ob_end_clean();

        return $buffer;
    }
    // END
}
/* End of file pi.grouper.php */
/* Location: ./system/expressionengine/third_party/grouper/pi.grouper.php */