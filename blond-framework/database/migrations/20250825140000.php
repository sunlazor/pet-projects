<?php

return new class {
    public function up()
    {
        echo get_class($this) . ' method is up()';
    }

    public function down()
    {
        echo get_class($this) . ' method is down()';
    }
};