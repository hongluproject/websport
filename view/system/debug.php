<style type="text/css">
#mm_debug_button {
	border:solid 1px #f00; 
	background:#f00; color:#fff; 
	padding:4px; 
	position: absolute; 
	top:0; 
	right:0;
	font-size:14px;
	z-index: 10001;
}
#mm_debug_container {
	margin: 10px 0; 
	color:#000; 
	clear:both; 
	position:absolute; 
	top:0; 
	right:0; 
	width:800px;
	display:none;
	font-size:12px;
    z-index: 10000;
}
#mm_debug_nav a {
	background:#00f;
	color:#fff;
	margin-right:8px;
	padding:5px 10px 3px 10px;
	font-size:10px;
}
#mm_debug_nav a.now {
	background: #f00;
}
.mm_debug_tab {
	display: none;
	background: #efefef;
	border: solid 1px #333;
	padding: 10px;
	overflow: auto;
	font-size: 12px;
}
.mm_debug_tab pre {
	font-size: 12px !important;
}
.mm_debug_tab li {
}
</style>
 
<a href="#" id="mm_debug_button" toggleString="Debug&#9650">Debug&#9660</a>
<div id="mm_debug_container">
    <div id="mm_debug_nav">
        <a href="javascript:;" class="now">Basic</a>
        <a href="javascript:;">Log</a>
        <a href="javascript:;">Config</a>
        <a href="javascript:;">DB</a>
        <a href="javascript:;">Request</a>
        <a href="javascript:;">Constant</a>
        <a href="javascript:;">Session</a>
        <a href="javascript:;">Cookie</a>
        <a href="javascript:;">Server</a>
        <a href="javascript:;">Load</a>
    	<div style="clear:both;"></div>
    </div>

    <div class="mm_debug_tab" style="display:block;">
        <b>Memory Usage</b>
        <pre><?php print number_format(memory_get_usage() - START_MEMORY_USAGE); ?> bytes
<?php print number_format(memory_get_usage()); ?> bytes (process)
<?php print number_format(memory_get_peak_usage(TRUE)); ?> bytes (process peak)</pre>

        <b>Execution Time</b>
        <pre><?php print round((microtime(true) - START_TIME), 5); ?> seconds</pre>

        <b>URL Path</b>
        <?php print dump(PATH); ?>

        <b>Locale</b>
        <?php print dump(LOCALE); ?>

        <b>Timezone</b>
        <?php print dump(date_default_timezone_get()); ?>
    </div>

    <div class="mm_debug_tab">
        <ul>
    	<?php
    	$msgs = \Core\Logger::instance()->getMessages();
    	if(!empty($msgs)){
            foreach($msgs as $msg)
            {
                if($msg['level'] == 'debug') echo '[' . date('Y-m-d H:i:s', floor($msg['time'])). "] {$msg['level']}: {$msg['text']}" . '<br />';
            }
    	}
        ?>
        </ul>
    </div>

    <div class="mm_debug_tab">
        <?php
        print dump($GLOBALS['config']);
        ?>
    </div>

    <div class="mm_debug_tab">
        <?php
        if(class_exists('\Core\Database', FALSE))
        {
        	$highlight = function($string)
        	{
        		return str_replace(array("&lt;?php", "?&gt;"),'',substr(highlight_string('<?php '.$string.' ?>', TRUE),36));
        	};

        	foreach(\Core\Database::$queries as $type => $queries)
        	{
        		print '<b>' . ucfirst($type) . ' ('. count($queries). ' queries)</b>';
        		print '<ul>';
        		foreach($queries as $data)
        		{
        			print '<li>' . $highlight('/* ' . round(($data[0]*1000), 2) . 'ms */ ' . wordwrap($data[1])). '</li>';
        		}
        		print '</ul>';
        	}

        	if(\Core\Error::$found)
        	{
        		print '<b>Last Query Run</b>';
        		print '<pre>'. $highlight(\Core\DataBase::$last_query). '</pre>';
        	}
        }
        ?>
	</div>

	<div class="mm_debug_tab">
        <?php if(!empty($_POST)) { ?>
        <b>$_POST Data</b>
        <?php print dump($_POST); ?>
        <?php } ?>

        <?php if(!empty($_GET)) { ?>
        <b>$_GET Data</b>
        <?php print dump($_GET); ?>
        <?php } ?>
    </div>

    <div class="mm_debug_tab">
        <?php
        $defined = get_defined_constants(true);
        print dump($defined['user']);
        ?>
    </div>

    <div class="mm_debug_tab">
        <?php
        if(!empty($_SESSION)) {
            print dump($_SESSION);
        }
        ?>
    </div>

    <div class="mm_debug_tab">
        <?php
        if(!empty($_COOKIE)) {
            print dump($_COOKIE);
        }
        ?>
    </div>

	<div class="mm_debug_tab">
        <?php print dump($_SERVER); ?>
    </div>

    <div class="mm_debug_tab">
        <?php $loaded_extensions = get_loaded_extensions(); ?>
        <b><?php print count($loaded_extensions); ?> Extensions Loaded:</b>
        <pre><?php foreach($loaded_extensions as $i => $extension) print '<font>' . str_pad($extension, 20, ' ') . '</font>' . (($i+1)%5 == 0 ? "\n" : ''); ?>
        </pre>

        <?php $included_files = get_included_files(); ?>
        <b><?php print count($included_files); ?> PHP Files Included:</b>
        <pre><?php foreach($included_files as $i => $file) print '<font>' . str_pad(str_replace(SP, '', $file), 50, ' ') . '</font>' . (($i+1)%2 == 0 ? "\n" : ''); ?></pre>
	</div>
</div>
<script type="text/javascript">
function toggleString(obj)
{
	var tmp = $(obj).text(); 
	$(obj).text($(obj).attr('toggleString'));
	$(obj).attr('toggleString', tmp);
}


$(document).ready(function(){
    $('#mm_debug_button').toggle(function(){
        $('#mm_debug_container').show();
        toggleString(this);
    },function(){
        $('#mm_debug_container').hide();
        toggleString(this);
    });

    $('#mm_debug_nav a').each(function(index){
        $(this).click(function(){
            $('#mm_debug_nav a').removeClass('now');
            $(this).addClass('now');
            $('.mm_debug_tab').hide();
            $('.mm_debug_tab').eq(index).show();
        });
    });
})
</script>
