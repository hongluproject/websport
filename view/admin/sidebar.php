<div class="well sidebar-nav">
    <ul class="nav nav-list"><?php
        foreach ($menu as $_i => $item)
        {
            $class = '';
            if ($item[1])
            {
                $title = '<a href="' . $item[1] . '">' . $item[0] . '</a>';
                if ($_SERVER['REQUEST_URI'] == $item[1] || in_array($_i,$path)) $class = 'active';
            }
            else
            {
                $class = 'nav-header';
                $title = $item[0];
            }
            if ($class) $class = ' class="' . $class . '"';
            echo '<li' . $class . '>' . $title . '</li>';
        }
        ?>
    </ul>
</div>