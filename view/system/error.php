<?php if (IS_CLI): ?>
<?php
    if (!empty($exception))
    {
        echo "[" . get_class($exception) . "] ";
        echo $exception->getMessage() . ' on ' . $exception->getFile() . ' [' . $exception->getLine() . ']' . PHP_EOL;
    }
    else
    {
        echo "[Error] ";
        echo "$error" . ($file ? " on {$file} [{$line}]" : '') . PHP_EOL;
    }
    if ($backtrace = \Core\Error::backtrace(2))
    {
        print PHP_EOL;
        foreach ($backtrace as $id => $line)
        {
            if ($id == 0) continue;

            print "\t[$id] ";
            //Skip the first element
            // If this is a class include the class name
            print 'Called by ' . (isset($line['class']) ? $line['class'] . $line['type'] : '');
            print $line['function'] . '()';

            // Print file, line, and source
            print ' in ' . $line['file'] . ' [' . $line['line'] . ']' . PHP_EOL;
        }
        print PHP_EOL;

    }
    ?>
<?php else: ?>
<style type="text/css">
    .system_error {
        border: 1px solid #990000;
        padding: 10px 20px;
        margin: 10px;
        font: 13px/1.4em verdana;
        background: #fff;
    }

    code.source {
        white-space: pre;
        background: #fff;
        padding: 1em;
        display: block;
        margin: 1em 0;
        border: 1px solid #bedbeb;
    }

    .system_error .box {
        margin: 1em 0;
        background: #ebf2fa;
        padding: 10px;
        border: 1px solid #bedbeb;
    }

    .code.source em {
        background: #ffc;
    }
</style>

<div class="system_error">

    <?php if ($exception): ?>
    <b style="color: #990000"><?php echo get_class($exception); ?></b>
    <p><?php echo $exception->getMessage(); ?></p>
    <?php else: ?>
    <b style="color: #990000">Error</b>
    <p><?php echo $error; ?></p>
    <?php endif; ?>

    <?php //print dump(debug_backtrace()); ?>

    <?php
    if ($backtrace = \Core\Error::backtrace(1))
    {

        foreach ($backtrace as $id => $line)
        {
            if (!isset($line['file'], $line['line'])) continue;

            print '<div class="box">';

            //Skip the first element
            if ($id !== 0)
            {
                // If this is a class include the class name
                print '<b>Called by ' . (isset($line['class']) ? $line['class'] . $line['type'] : '');
                print $line['function'] . '()</b>';
            }

            // Print file, line, and source
            print ' in ' . $line['file'] . ' [' . $line['line'] . ']';
            print '<code class="source">' . $line['source'] . '</code>';

            if (isset($line['args']))
            {
                print '<b>Function Arguments</b>';
                print dump($line['args']);
            }

            print '</div>';
        }

    }
    if ($exception)
    {
        print '<p><b>' . $exception->getFile() . '</b> (' . $exception->getLine() . ')</p>';
    }
    else
    {
        print '<p><b>' . $file . '</b> (' . $line . ')</p>';
    }
    ?>

</div>
<?php endif; ?>