Grouper
=========

Grouper plugin for expression engine
--------------------------------------

The grouper allows you to output additional markup based on the count of the entries feed. You can open a <div> in one portion of the feed and close it later as necessary, creating a 'group'. Useful for outputting grids of images that require addition markup to define rows, or can be used to determine an :nth iteration

	{exp:grouper}

Methods
===========

Group start
------------

	{exp:grouper:start groupby="5" count="{count}" total="{total_results}"}

Parameters
	
*last_class* {last_class}

Sending in a 'last class' parameter allows you to use a variable tag within the grouper pair, which is useful if you need to style the last group differently (often that's bottom padding or bottom border etc)
	
	
Group end
-------------

	{exp:grouper:end groupby="5" count="{count}" total="{total_results}"}

Group nth
-------------

	{exp:grouper:nth n="5" count="{count}" total="{total_results}"}
	

Examples
==============

Creating a gallery grid
--------------------------
You may need to create a gallery which has 3 images in a row, the last row needing to be styled differently

Set the {count} and {total_results} dynamically, these are variables from the entries pair
Define a class 'last_class' to use for the last item (optional)
Insert the last-class variable in the start group

	{exp:channel:entries}
		  				
	{exp:grouper:start groupby="3" count="{count}" total="{total_results}" last_class="last"}
	<!-- row -->
	<div class="row image-feed-row {last_class}">
	{/exp:grouper:start}
		
		<!-- unit -->
		<div class="unit image-feed-unit col">
			<div class="unit-title">
				<h3 class="unit-heading"><a href="{path={url_title}}">{title}</a></h3>
			</div>
			<div class="unit-image">
				<a href="{path={url_title}}"><img src="http://placehold.it/100x100" alt="{title}" /></a>
			</div>
		</div>
		<!-- unit -->
		
	{exp:grouper:end groupby="3" count="{count}" total="{total_results}"}
	</div>
	<!-- row -->
	{/exp:grouper:end}
	
	{/exp:channel:entries}

:nth item
----------------
Use the grouper:nth to add the 'nth-item' class to an :nth entry

 
	{exp:channel:entries}
		  			
		<!-- unit -->
		<div class="unit image-feed-unit col {exp:grouper:nth n="3" count="{count}"}nth-item{/exp:grouper:nth}">
			<div class="unit-title">
				<h3 class="unit-heading"><a href="{path={url_title}}">{title}</a></h3>
			</div>
			<div class="unit-image">
				<a href="{path={url_title}}"><img src="http://placehold.it/100x100" alt="{title}" /></a>
			</div>
		</div>
		<!-- unit -->
		
	
	{/exp:channel:entries}


