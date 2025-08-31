<?php

use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\PrimaryKeyConstraint;
use Doctrine\DBAL\Schema\Table;

return new class {
    public function up()
    {
        $postsTable = Table::editor()
            ->setUnquotedName('posts')
            ->addColumn(
                Column::editor()
                    ->setUnquotedName('id')
                    ->setTypeName('integer')
                    ->setAutoincrement(true)
                    ->setUnsigned(true)
                    ->create(),
            )
            ->addColumn(
                Column::editor()
                    ->setUnquotedName('title')
                    ->setTypeName('string')
                    ->setLength(128)
                    ->setNotNull(true)
                    ->create(),
            )
            ->addColumn(
                Column::editor()
                    ->setUnquotedName('body')
                    ->setTypeName('text')
                    ->setNotNull(true)
                    ->create(),
            )
            ->addColumn(
                Column::editor()
                    ->setUnquotedName('created_at')
                    ->setTypeName('datetime_immutable')
                    ->setDefaultValue('CURRENT_TIMESTAMP')
                    ->setNotNull(true)
                    ->create(),
            )
            ->addPrimaryKeyConstraint(
                PrimaryKeyConstraint::editor()
                    ->setUnquotedColumnNames('id')
                    ->create(),
            )
            ->create();

        return $postsTable;
    }

    public function down()
    {
        echo get_class($this) . ' method is down()';
    }
};