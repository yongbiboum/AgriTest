<?php


return array(
'table' => array(
'mshop_customer_soumission' => function ( \Doctrine\DBAL\Schema\Schema $schema ) {

$table = $schema->createTable( 'mshop_attribute_soumission' );

$table->addColumn( 'id', 'integer', array( 'autoincrement' => true ) );
$table->addColumn( 'siteid', 'integer', array() );
$table->addColumn( 'user', 'string', array( 'length' => 255, 'notnull' => false ) );
$table->addColumn( 'lieu', 'string', array( 'length' => 255, 'notnull' => false ) );
$table->addColumn( 'prix', 'decimal', array( 'precision' => 12, 'scale' => 2 ));
$table->addColumn( 'currencyid', 'string', array( 'length' => 3, 'fixed' => true ) );
$table->addColumn( 'start', 'datetime', array( 'notnull' => false ) );
$table->addColumn( 'end', 'datetime', array( 'notnull' => false ) );
$table->addColumn( 'description', 'string', array( 'length' => 255, 'notnull' => false ) );
$table->addColumn( 'status', 'smallint', [] );
$table->addColumn( 'variete', 'string', array( 'length' => 255 ) );
$table->addColumn( 'mtime', 'datetime', array() );
$table->addColumn( 'ctime', 'datetime', array() );
$table->addColumn( 'editor', 'string', array( 'length' => 255 ) );

$table->setPrimaryKey( array( 'id' ), 'pk_msattmy_id' );
$table->addUniqueIndex( array( 'siteid', 'user' ), 'unq_msattmy_sid_myval' );

return $schema;
},
),



);
